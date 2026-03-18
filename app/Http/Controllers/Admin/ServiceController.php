<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ServiceController extends Controller
{
  public function index(): View
  {
    $services = Service::latest()->paginate(15);

    return view('admin.services.index', compact('services'));
  }

  public function create(): RedirectResponse
  {
    return redirect()->route('admin.services.index');
  }

  public function store(Request $request): RedirectResponse
  {
    $data = $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'icon_class' => ['nullable', 'string', 'max:100'],
      'content' => ['required', 'string'],
      'is_active' => ['nullable', 'boolean'],
      'featured_image' => ['nullable', 'image', 'max:4096'],
      'gallery.*' => ['nullable', 'image', 'max:4096'],
    ]);

    $data['featured_image'] = $this->uploadImage($request, 'featured_image');
    $data['gallery'] = $this->uploadGallery($request);
    $data['is_active'] = $request->boolean('is_active');
    $data['icon_class'] = trim($data['icon_class'] ?? '') ?: 'bi bi-stars';

    Service::create($data);

    return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
  }

  public function edit(Service $service): View
  {
    return view('admin.services.edit', compact('service'));
  }

  public function update(Request $request, Service $service): RedirectResponse
  {
    $data = $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'icon_class' => ['nullable', 'string', 'max:100'],
      'content' => ['required', 'string'],
      'is_active' => ['nullable', 'boolean'],
      'featured_image' => ['nullable', 'image', 'max:4096'],
      'gallery.*' => ['nullable', 'image', 'max:4096'],
      'remove_gallery' => ['nullable', 'array'],
      'remove_gallery.*' => ['string'],
    ]);

    if ($request->hasFile('featured_image')) {
      $this->deleteImage($service->featured_image);
      $data['featured_image'] = $this->uploadImage($request, 'featured_image');
    }

    $gallery = $service->gallery ?? [];

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
    $data['icon_class'] = trim($data['icon_class'] ?? '') ?: 'bi bi-stars';

    $service->update($data);

    return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
  }

  public function destroy(Service $service): RedirectResponse
  {
    $this->deleteImage($service->featured_image);

    foreach ($service->gallery ?? [] as $imagePath) {
      $this->deleteImage($imagePath);
    }

    $service->delete();

    return back()->with('success', 'Service deleted successfully.');
  }

  private function uploadImage(Request $request, string $field): ?string
  {
    if (! $request->hasFile($field)) {
      return null;
    }

    $file = $request->file($field);
    $directory = public_path('uploads/services');
    File::ensureDirectoryExists($directory);

    $filename = uniqid('service_', true) . '.' . $file->getClientOriginalExtension();
    $file->move($directory, $filename);

    return 'uploads/services/' . $filename;
  }

  private function uploadGallery(Request $request): array
  {
    $paths = [];

    if (! $request->hasFile('gallery')) {
      return $paths;
    }

    $directory = public_path('uploads/services');
    File::ensureDirectoryExists($directory);

    foreach ($request->file('gallery') as $file) {
      if (! $file) {
        continue;
      }

      $filename = uniqid('gallery_', true) . '.' . $file->getClientOriginalExtension();
      $file->move($directory, $filename);
      $paths[] = 'uploads/services/' . $filename;
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
