<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Setting;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BlogController extends Controller
{
  public function index(): View
  {
    $settings = Setting::whereIn('key', [
      'app_name',
      'app_description',
      'seo_home_title',
      'seo_home_description',
      'seo_home_keywords',
    ])->pluck('value', 'key');

    $blogs = Blog::where('is_published', true)
      ->orderByDesc('published_at')
      ->orderByDesc('id')
      ->paginate(9);

    return view('site.blogs.index', [
      'settings' => $settings,
      'blogs' => $blogs,
      'metaTitle' => $settings['seo_home_title'] ?? ($settings['app_name'] ?? 'AQ Digital') . ' Blog',
      'metaDescription' => $settings['seo_home_description'] ?? ($settings['app_description'] ?? 'Latest updates and insights.'),
      'metaKeywords' => $settings['seo_home_keywords'] ?? null,
    ]);
  }

  public function show(Blog $blog): View
  {
    abort_unless($blog->is_published, 404);

    $settings = Setting::whereIn('key', ['app_name', 'app_description'])->pluck('value', 'key');

    return view('site.blogs.show', [
      'settings' => $settings,
      'blog' => $blog,
      'metaTitle' => $blog->meta_title ?: $blog->title,
      'metaDescription' => $blog->meta_description ?: str(strip_tags($blog->content))->limit(160),
      'metaKeywords' => $blog->meta_keywords ?: $blog->tags,
    ]);
  }

  public function sitemap(): Response
  {
    $blogs = Blog::where('is_published', true)
      ->orderByDesc('updated_at')
      ->get(['slug', 'updated_at']);

    $xml = view('site.blogs.sitemap', compact('blogs'))->render();

    return response($xml, 200, ['Content-Type' => 'application/xml']);
  }
}
