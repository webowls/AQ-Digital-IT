<?php

namespace App\Http\Controllers;

use App\Mail\ContactConfirmation;
use App\Mail\ContactNotification;
use App\Models\Blog;
use App\Models\ContactMessage;
use App\Models\SmtpSetting;
use App\Models\HeroSlide;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class HomeController extends Controller
{
  public function index(): View
  {
    $settings = Setting::whereIn('key', [
      'app_name',
      'app_description',
      'contact_phone',
      'contact_email',
      'contact_address',
      'landing_heading',
      'landing_subheading',
      'app_logo',
      'app_favicon',
      'seo_home_title',
      'seo_home_description',
      'seo_home_keywords',
    ])->pluck('value', 'key');

    $services = Service::where('is_active', true)->latest()->get();
    $portfolios = Portfolio::where('is_active', true)->latest()->take(6)->get();
    $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
    $blogs = Blog::where('is_published', true)->orderByDesc('published_at')->orderByDesc('id')->take(3)->get();

    return view('site.home', [
      'settings'   => $settings,
      'services'   => $services,
      'portfolios' => $portfolios,
      'heroSlides' => $heroSlides,
      'blogs'      => $blogs,
      'metaTitle' => $settings['seo_home_title'] ?? ($settings['app_name'] ?? 'AQ Digital & IT Services'),
      'metaDescription' => $settings['seo_home_description'] ?? ($settings['app_description'] ?? 'Your trusted partner for innovative digital solutions.'),
      'metaKeywords' => $settings['seo_home_keywords'] ?? null,
    ]);
  }

  public function submitContact(Request $request): JsonResponse|RedirectResponse
  {
    $data = $request->validate([
      'name'    => ['required', 'string', 'max:255'],
      'email'   => ['required', 'email', 'max:255'],
      'subject' => ['required', 'string', 'max:255'],
      'message' => ['required', 'string'],
    ]);

    ContactMessage::create($data + ['is_read' => false]);

    // Send emails using the admin-configured SMTP settings (stored in DB)
    $smtp = SmtpSetting::first();

    if ($smtp && $smtp->is_active) {
      try {
        config([
          'mail.default'                 => $smtp->mailer ?: 'smtp',
          'mail.mailers.smtp.transport'  => 'smtp',
          'mail.mailers.smtp.host'       => $smtp->host,
          'mail.mailers.smtp.port'       => $smtp->port,
          'mail.mailers.smtp.encryption' => $smtp->encryption,
          'mail.mailers.smtp.username'   => $smtp->username,
          'mail.mailers.smtp.password'   => $smtp->password,
          'mail.from.address'            => $smtp->from_address,
          'mail.from.name'               => $smtp->from_name ?: config('app.name'),
        ]);

        $appName    = Setting::where('key', 'app_name')->value('value') ?? config('app.name');
        $adminEmail = Setting::where('key', 'contact_email')->value('value') ?? $smtp->from_address;

        Mail::to($data['email'])->send(new ContactConfirmation($data, $appName));
        Mail::to($adminEmail)->send(new ContactNotification($data, $appName));
      } catch (\Throwable $e) {
        logger()->error('Contact email failed: ' . $e->getMessage());
      }
    }

    $message = 'Thank you for your message! We will get back to you soon.';

    if ($request->expectsJson()) {
      return response()->json(['success' => true, 'message' => $message]);
    }

    return back()->with('success', $message);
  }
}
