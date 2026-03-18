<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
  public function index(): View
  {
    $blogs = Blog::latest()->paginate(15);

    return view('admin.blogs.index', compact('blogs'));
  }

  public function create(): RedirectResponse
  {
    return redirect()->route('admin.blogs.index');
  }

  public function store(Request $request): RedirectResponse
  {
    $data = $this->validateData($request);

    $data['slug'] = $this->generateUniqueSlug($data['title']);
    $data['featured_image'] = $this->uploadImage($request, 'featured_image');
    $data['gallery'] = $this->uploadGallery($request);
    $data['is_published'] = $request->boolean('is_published');
    $data['published_at'] = $data['is_published'] ? now() : null;

    Blog::create($data);

    return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
  }

  public function edit(Blog $blog): View
  {
    return view('admin.blogs.edit', compact('blog'));
  }

  public function update(Request $request, Blog $blog): RedirectResponse
  {
    $data = $this->validateData($request);

    $data['slug'] = $this->generateUniqueSlug($data['title'], $blog->id);

    if ($request->hasFile('featured_image')) {
      $this->deleteImage($blog->featured_image);
      $data['featured_image'] = $this->uploadImage($request, 'featured_image');
    }

    $gallery = $blog->gallery ?? [];
    foreach ($request->input('remove_gallery', []) as $imagePath) {
      $this->deleteImage($imagePath);
      $gallery = array_values(array_filter($gallery, fn(string $path): bool => $path !== $imagePath));
    }

    $newGallery = $this->uploadGallery($request);
    if ($newGallery) {
      $gallery = [...$gallery, ...$newGallery];
    }

    $data['gallery'] = $gallery;
    $data['is_published'] = $request->boolean('is_published');

    if ($data['is_published'] && ! $blog->published_at) {
      $data['published_at'] = now();
    }

    if (! $data['is_published']) {
      $data['published_at'] = null;
    }

    $blog->update($data);

    return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
  }

  public function destroy(Blog $blog): RedirectResponse
  {
    $this->deleteImage($blog->featured_image);

    foreach ($blog->gallery ?? [] as $imagePath) {
      $this->deleteImage($imagePath);
    }

    $blog->delete();

    return back()->with('success', 'Blog deleted successfully.');
  }

  private function validateData(Request $request): array
  {
    return $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'content' => ['required', 'string'],
      'tags' => ['nullable', 'string'],
      'meta_title' => ['nullable', 'string', 'max:255'],
      'meta_description' => ['nullable', 'string'],
      'meta_keywords' => ['nullable', 'string'],
      'is_published' => ['nullable', 'boolean'],
      'featured_image' => ['nullable', 'image', 'max:4096'],
      'gallery.*' => ['nullable', 'image', 'max:4096'],
      'remove_gallery' => ['nullable', 'array'],
      'remove_gallery.*' => ['string'],
    ]);
  }

  private function generateUniqueSlug(string $title, ?int $blogId = null): string
  {
    $baseSlug = Str::slug($title);
    $slug = $baseSlug;
    $counter = 2;

    while (Blog::where('slug', $slug)
      ->when($blogId, fn($query) => $query->where('id', '!=', $blogId))
      ->exists()
    ) {
      $slug = $baseSlug . '-' . $counter;
      $counter++;
    }

    return $slug;
  }

  private function uploadImage(Request $request, string $field): ?string
  {
    if (! $request->hasFile($field)) {
      return null;
    }

    $file = $request->file($field);
    $directory = public_path('uploads/blogs');
    File::ensureDirectoryExists($directory);

    $filename = uniqid('blog_', true) . '.' . $file->getClientOriginalExtension();
    $file->move($directory, $filename);

    return 'uploads/blogs/' . $filename;
  }

  private function uploadGallery(Request $request): array
  {
    $paths = [];

    if (! $request->hasFile('gallery')) {
      return $paths;
    }

    $directory = public_path('uploads/blogs');
    File::ensureDirectoryExists($directory);

    foreach ($request->file('gallery') as $file) {
      if (! $file) {
        continue;
      }

      $filename = uniqid('blog_gallery_', true) . '.' . $file->getClientOriginalExtension();
      $file->move($directory, $filename);
      $paths[] = 'uploads/blogs/' . $filename;
    }

    return $paths;
  }

  private function deleteImage(?string $path): void
  {
    if (! $path) {
      return;
    }

    $absolutePath = public_path($path);
    if (File::exists($absolutePath)) {
      File::delete($absolutePath);
    }
  }
}
