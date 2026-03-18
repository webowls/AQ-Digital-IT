<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class PortfolioController extends Controller
{
  public function index(): View
  {
    $portfolios = Portfolio::latest()->paginate(15);

    return view('admin.portfolios.index', compact('portfolios'));
  }

  public function store(Request $request): RedirectResponse
  {
    $data = $this->validateData($request);

    $data['featured_image'] = $this->uploadImage($request, 'featured_image');
    $data['gallery'] = $this->uploadGallery($request);
    $data['is_active'] = $request->boolean('is_active');

    Portfolio::create($data);

    return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio project created successfully.');
  }

  public function edit(Portfolio $portfolio): View
  {
    return view('admin.portfolios.edit', compact('portfolio'));
  }

  public function update(Request $request, Portfolio $portfolio): RedirectResponse
  {
    $data = $this->validateData($request);

    if ($request->hasFile('featured_image')) {
      $this->deleteImage($portfolio->featured_image);
      $data['featured_image'] = $this->uploadImage($request, 'featured_image');
    }

    $gallery = $portfolio->gallery ?? [];

    foreach ($request->input('remove_gallery', []) as $imagePath) {
      $this->deleteImage($imagePath);
      $gallery = array_values(array_filter($gallery, fn(string $path): bool => $path !== $imagePath));
    }

    $newGallery = $this->uploadGallery($request);
    if ($newGallery) {
      $gallery = [...$gallery, ...$newGallery];
    }

    $data['gallery'] = $gallery;
    $data['is_active'] = $request->boolean('is_active');

    $portfolio->update($data);

    return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio project updated successfully.');
  }

  public function destroy(Portfolio $portfolio): RedirectResponse
  {
    $this->deleteImage($portfolio->featured_image);

    foreach ($portfolio->gallery ?? [] as $imagePath) {
      $this->deleteImage($imagePath);
    }

    $portfolio->delete();

    return back()->with('success', 'Portfolio project deleted successfully.');
  }

  private function validateData(Request $request): array
  {
    return $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'category' => ['nullable', 'string', 'max:120'],
      'description' => ['required', 'string'],
      'project_url' => ['nullable', 'url', 'max:255'],
      'is_active' => ['nullable', 'boolean'],
      'featured_image' => ['nullable', 'image', 'max:4096'],
      'gallery.*' => ['nullable', 'image', 'max:4096'],
      'remove_gallery' => ['nullable', 'array'],
      'remove_gallery.*' => ['string'],
    ]);
  }

  private function uploadImage(Request $request, string $field): ?string
  {
    if (! $request->hasFile($field)) {
      return null;
    }

    $file = $request->file($field);
    $directory = public_path('uploads/portfolios');
    File::ensureDirectoryExists($directory);

    $filename = uniqid('portfolio_', true) . '.' . $file->getClientOriginalExtension();
    $file->move($directory, $filename);

    return 'uploads/portfolios/' . $filename;
  }

  private function uploadGallery(Request $request): array
  {
    $paths = [];

    if (! $request->hasFile('gallery')) {
      return $paths;
    }

    $directory = public_path('uploads/portfolios');
    File::ensureDirectoryExists($directory);

    foreach ($request->file('gallery') as $file) {
      if (! $file) {
        continue;
      }

      $filename = uniqid('portfolio_gallery_', true) . '.' . $file->getClientOriginalExtension();
      $file->move($directory, $filename);
      $paths[] = 'uploads/portfolios/' . $filename;
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
