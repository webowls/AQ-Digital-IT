<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
      'seo_home_title',
      'seo_home_description',
      'seo_home_keywords',
    ])->pluck('value', 'key');

    $services = Service::where('is_active', true)->latest()->get();
    $blogs = Blog::where('is_published', true)->orderByDesc('published_at')->orderByDesc('id')->take(3)->get();

    return view('site.home', [
      'settings' => $settings,
      'services' => $services,
      'blogs' => $blogs,
      'metaTitle' => $settings['seo_home_title'] ?? ($settings['app_name'] ?? 'AQ Digital & IT Services'),
      'metaDescription' => $settings['seo_home_description'] ?? ($settings['app_description'] ?? 'Your trusted partner for innovative digital solutions.'),
      'metaKeywords' => $settings['seo_home_keywords'] ?? null,
    ]);
  }

  public function submitContact(Request $request): RedirectResponse
  {
    $data = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255'],
      'subject' => ['required', 'string', 'max:255'],
      'message' => ['required', 'string'],
    ]);

    ContactMessage::create($data + ['is_read' => false]);

    return back()->with('success', 'Thank you for your message! We will get back to you soon.');
  }
}
