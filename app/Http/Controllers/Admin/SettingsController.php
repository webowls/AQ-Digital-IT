<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Setting;
use App\Models\SmtpSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class SettingsController extends Controller
{
  public function general(): View
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

    return view('admin.settings.general', compact('settings'));
  }

  public function saveGeneral(Request $request): RedirectResponse
  {
    $data = $request->validate([
      'app_name' => ['required', 'string', 'max:255'],
      'app_description' => ['nullable', 'string'],
      'contact_phone' => ['nullable', 'string', 'max:255'],
      'contact_email' => ['nullable', 'email', 'max:255'],
      'contact_address' => ['nullable', 'string'],
      'landing_heading' => ['nullable', 'string', 'max:255'],
      'landing_subheading' => ['nullable', 'string'],
      'seo_home_title' => ['nullable', 'string', 'max:255'],
      'seo_home_description' => ['nullable', 'string', 'max:160'],
      'seo_home_keywords' => ['nullable', 'string', 'max:255'],
    ]);

    foreach ($data as $key => $value) {
      Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    return back()->with('success', 'General settings updated successfully.');
  }

  public function account(): View
  {
    $admin = Auth::user();

    return view('admin.settings.account', compact('admin'));
  }

  public function saveAccount(Request $request): RedirectResponse
  {
    $admin = Auth::user();

    $data = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $admin->id],
      'phone' => ['nullable', 'string', 'max:255'],
      'password' => ['nullable', 'string', 'min:8', 'confirmed'],
      'two_factor_enabled' => ['nullable', 'boolean'],
    ]);

    $smtp = SmtpSetting::first();
    $canEnable2FA = $smtp && $smtp->is_active && $smtp->host && $smtp->from_address;

    if ($request->boolean('two_factor_enabled') && ! $canEnable2FA) {
      return back()->withErrors([
        'two_factor_enabled' => 'Enable SMTP with valid host and from address before activating 2FA.',
      ]);
    }

    $admin->name = $data['name'];
    $admin->email = $data['email'];
    $admin->phone = $data['phone'] ?? null;
    $admin->two_factor_enabled = $request->boolean('two_factor_enabled');

    if (! empty($data['password'])) {
      $admin->password = Hash::make($data['password']);
    }

    $admin->save();

    return back()->with('success', 'Account settings updated successfully.');
  }

  public function smtp(): View
  {
    $smtp = SmtpSetting::first();

    return view('admin.settings.smtp', compact('smtp'));
  }

  public function saveSmtp(Request $request): RedirectResponse
  {
    $data = $request->validate([
      'mailer' => ['required', 'string', 'max:50'],
      'host' => ['nullable', 'string', 'max:255'],
      'port' => ['nullable', 'integer', 'min:1'],
      'username' => ['nullable', 'string', 'max:255'],
      'password' => ['nullable', 'string', 'max:255'],
      'encryption' => ['nullable', 'string', 'max:20'],
      'from_address' => ['nullable', 'email', 'max:255'],
      'from_name' => ['nullable', 'string', 'max:255'],
      'is_active' => ['nullable', 'boolean'],
    ]);

    if (empty($data['password'])) {
      $existing = SmtpSetting::first();
      $data['password'] = $existing?->password;
    }

    $data['is_active'] = $request->boolean('is_active');

    SmtpSetting::query()->updateOrCreate(['id' => 1], $data);

    return back()->with('success', 'SMTP settings saved successfully.');
  }

  public function testSmtp(Request $request): RedirectResponse
  {
    $request->validate([
      'test_email' => ['required', 'email'],
    ]);

    $smtp = SmtpSetting::first();

    if (! $smtp || ! $smtp->is_active) {
      return back()->withErrors(['test_email' => 'SMTP settings are not active.']);
    }

    config([
      'mail.default' => $smtp->mailer ?: 'smtp',
      'mail.mailers.smtp.transport' => 'smtp',
      'mail.mailers.smtp.host' => $smtp->host,
      'mail.mailers.smtp.port' => $smtp->port,
      'mail.mailers.smtp.encryption' => $smtp->encryption,
      'mail.mailers.smtp.username' => $smtp->username,
      'mail.mailers.smtp.password' => $smtp->password,
      'mail.from.address' => $smtp->from_address,
      'mail.from.name' => $smtp->from_name ?: config('app.name'),
    ]);

    try {
      Mail::raw('SMTP test email from AQ Digital admin panel.', function ($message) use ($request): void {
        $message->to($request->input('test_email'))->subject('SMTP Test');
      });

      return back()->with('success', 'SMTP test email sent successfully.');
    } catch (\Throwable $exception) {
      return back()->withErrors([
        'test_email' => 'SMTP test failed: ' . $exception->getMessage(),
      ]);
    }
  }

  public function environment(): View
  {
    return view('admin.settings.environment', [
      'values' => [
        'APP_ENV' => env('APP_ENV'),
        'APP_DEBUG' => env('APP_DEBUG'),
        'APP_URL' => env('APP_URL'),
        'DB_CONNECTION' => env('DB_CONNECTION'),
        'DB_HOST' => env('DB_HOST'),
        'DB_PORT' => env('DB_PORT'),
        'DB_DATABASE' => env('DB_DATABASE'),
        'DB_USERNAME' => env('DB_USERNAME'),
      ],
    ]);
  }

  public function saveEnvironment(Request $request): RedirectResponse
  {
    $data = $request->validate([
      'APP_ENV' => ['required', 'string', 'max:50'],
      'APP_DEBUG' => ['required', 'in:true,false'],
      'APP_URL' => ['required', 'url'],
      'DB_CONNECTION' => ['required', 'string', 'max:50'],
      'DB_HOST' => ['required', 'string', 'max:255'],
      'DB_PORT' => ['required', 'string', 'max:10'],
      'DB_DATABASE' => ['required', 'string', 'max:255'],
      'DB_USERNAME' => ['required', 'string', 'max:255'],
      'DB_PASSWORD' => ['nullable', 'string', 'max:255'],
    ]);

    foreach ($data as $key => $value) {
      $this->setEnvironmentValue($key, $value);
    }

    Artisan::call('config:clear');

    return back()->with('success', 'Environment values updated. Config cache cleared.');
  }

  public function migrations(): View
  {
    Artisan::call('migrate:status', ['--no-ansi' => true]);
    $statusOutput = Artisan::output();

    $lastMigration = \DB::table('migrations')->latest('batch')->latest('id')->first();

    return view('admin.settings.migrations', [
      'statusOutput' => $statusOutput,
      'lastMigration' => $lastMigration,
    ]);
  }

  public function runMigrations(): RedirectResponse
  {
    Artisan::call('migrate', ['--force' => true]);
    $output = Artisan::output();

    return back()->with('success', "Migrations executed.\n" . $output);
  }

  public function seoHealth(): View
  {
    $settings = Setting::whereIn('key', [
      'seo_home_title',
      'seo_home_description',
      'seo_home_keywords',
    ])->pluck('value', 'key');

    $checks = [];

    $checks[] = $this->check('APP_URL configured', !empty(env('APP_URL')), !empty(env('APP_URL')) ? 'APP_URL is configured.' : 'APP_URL is missing from environment.', 'fail');
    $checks[] = $this->check('APP_DEBUG disabled', env('APP_DEBUG') === false || env('APP_DEBUG') === 'false', 'APP_DEBUG is disabled.', 'Disable APP_DEBUG in production.', 'warn');
    $checks[] = $this->check('Home meta title', !empty($settings['seo_home_title']), 'Home meta title is configured.', 'Set SEO Home Title in General settings.', 'warn');
    $checks[] = $this->check('Home meta description', !empty($settings['seo_home_description']), 'Home meta description is configured.', 'Set SEO Home Description (max 160 chars).', 'warn');
    $checks[] = $this->check('Sitemap route', true, 'Sitemap available at /sitemap.xml.', 'Sitemap route unavailable.', 'fail');
    $checks[] = $this->check('Robots.txt present', file_exists(public_path('robots.txt')), 'robots.txt file exists.', 'Create and configure robots.txt.', 'warn');

    $publishedBlogs = Blog::where('is_published', true)->count();
    $blogsMissingMeta = Blog::where('is_published', true)
      ->where(function ($query) {
        $query->whereNull('meta_title')->orWhere('meta_title', '')
          ->orWhereNull('meta_description')->orWhere('meta_description', '');
      })->count();
    $blogsMissingImage = Blog::where('is_published', true)
      ->where(function ($query) {
        $query->whereNull('featured_image')->orWhere('featured_image', '');
      })->count();

    $checks[] = $this->check('Published blogs available', $publishedBlogs > 0, $publishedBlogs . ' published blog(s) found.', 'Publish at least one blog for SEO crawl depth.', 'warn');
    $checks[] = $this->check('Blog meta completeness', $blogsMissingMeta === 0, 'All published blogs have meta title and description.', $blogsMissingMeta . ' published blog(s) missing meta title/description.', 'warn');
    $checks[] = $this->check('Blog featured images', $blogsMissingImage === 0, 'All published blogs have featured image.', $blogsMissingImage . ' published blog(s) missing featured image.', 'warn');

    $score = 100;
    foreach ($checks as $check) {
      if ($check['status'] === 'fail') {
        $score -= 20;
      }

      if ($check['status'] === 'warn') {
        $score -= 8;
      }
    }

    $score = max($score, 0);

    return view('admin.settings.seo-health', compact('checks', 'score'));
  }

  private function check(string $label, bool $condition, string $passMessage, string $failMessage, string $severity = 'fail'): array
  {
    if ($condition) {
      return [
        'label' => $label,
        'status' => 'pass',
        'message' => $passMessage,
      ];
    }

    return [
      'label' => $label,
      'status' => $severity,
      'message' => $failMessage,
    ];
  }

  private function setEnvironmentValue(string $key, ?string $value): void
  {
    $path = app()->environmentFilePath();
    $escapedValue = $value === null ? '' : '"' . addcslashes($value, '"') . '"';

    $content = file_get_contents($path);
    $pattern = "/^{$key}=.*/m";

    if (preg_match($pattern, $content)) {
      $content = preg_replace($pattern, "{$key}={$escapedValue}", $content);
    } else {
      $content .= PHP_EOL . "{$key}={$escapedValue}";
    }

    file_put_contents($path, $content);
  }
}
