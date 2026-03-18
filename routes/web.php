<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.store');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{blog:slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/sitemap.xml', [BlogController::class, 'sitemap'])->name('sitemap');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('admin.auth')->group(function (): void {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('services', ServiceController::class)->except(['show']);
        Route::resource('portfolios', PortfolioController::class)->except(['show', 'create']);
        Route::resource('hero-slides', HeroSlideController::class)->except(['show', 'create']);
        Route::resource('blogs', AdminBlogController::class)->except(['show']);
        Route::resource('users', UserController::class)->except(['show', 'create']);

        Route::get('/contacts', [ContactMessageController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{contact}', [ContactMessageController::class, 'show'])->name('contacts.show');
        Route::patch('/contacts/{contact}/mark-read', [ContactMessageController::class, 'markRead'])->name('contacts.mark-read');
        Route::delete('/contacts/{contact}', [ContactMessageController::class, 'destroy'])->name('contacts.destroy');

        Route::get('/settings/general', [SettingsController::class, 'general'])->name('settings.general');
        Route::post('/settings/general', [SettingsController::class, 'saveGeneral'])->name('settings.general.save');

        Route::get('/settings/account', [SettingsController::class, 'account'])->name('settings.account');
        Route::post('/settings/account', [SettingsController::class, 'saveAccount'])->name('settings.account.save');

        Route::get('/settings/smtp', [SettingsController::class, 'smtp'])->name('settings.smtp');
        Route::post('/settings/smtp', [SettingsController::class, 'saveSmtp'])->name('settings.smtp.save');
        Route::post('/settings/smtp/test', [SettingsController::class, 'testSmtp'])->name('settings.smtp.test');

        Route::get('/settings/environment', [SettingsController::class, 'environment'])->name('settings.environment');
        Route::post('/settings/environment', [SettingsController::class, 'saveEnvironment'])->name('settings.environment.save');

        Route::get('/settings/migrations', [SettingsController::class, 'migrations'])->name('settings.migrations');
        Route::post('/settings/migrations/run', [SettingsController::class, 'runMigrations'])->name('settings.migrations.run');

        Route::get('/settings/seo-health', [SettingsController::class, 'seoHealth'])->name('settings.seo-health');
    });
});
