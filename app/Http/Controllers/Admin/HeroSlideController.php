<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
  public function index(): View
  {
    $slides = HeroSlide::orderBy('sort_order')->orderBy('id')->get();

    return view('admin.hero-slides.index', compact('slides'));
  }

  public function store(Request $request): RedirectResponse
  {
    $data = $this->validateData($request);
    $data['illustration'] = $this->uploadImage($request);
    $data['is_active']    = $request->boolean('is_active');

    HeroSlide::create($data);

    return redirect()->route('admin.hero-slides.index')->with('success', 'Slide created successfully.');
  }

  public function edit(HeroSlide $heroSlide): View
  {
    return view('admin.hero-slides.edit', compact('heroSlide'));
  }

  public function update(Request $request, HeroSlide $heroSlide): RedirectResponse
  {
    $data = $this->validateData($request);

    if ($request->hasFile('illustration')) {
      $this->deleteImage($heroSlide->illustration);
      $data['illustration'] = $this->uploadImage($request);
    }

    $data['is_active'] = $request->boolean('is_active');

    $heroSlide->update($data);

    return redirect()->route('admin.hero-slides.index')->with('success', 'Slide updated successfully.');
  }

  public function destroy(HeroSlide $heroSlide): RedirectResponse
  {
    $this->deleteImage($heroSlide->illustration);
    $heroSlide->delete();

    return back()->with('success', 'Slide deleted successfully.');
  }

  private function validateData(Request $request): array
  {
    return $request->validate([
      'tag'          => ['required', 'string', 'max:100'],
      'heading'      => ['required', 'string', 'max:255'],
      'subtitle'     => ['required', 'string'],
      'bg_gradient'  => ['required', 'string', 'max:500'],
      'glow_color'   => ['required', 'string', 'max:100'],
      'sort_order'   => ['nullable', 'integer', 'min:0'],
      'is_active'    => ['nullable', 'boolean'],
      'illustration' => ['nullable', 'image', 'max:4096'],
    ]);
  }

  private function uploadImage(Request $request): ?string
  {
    if (! $request->hasFile('illustration')) {
      return null;
    }

    $file      = $request->file('illustration');
    $directory = public_path('uploads/hero-slides');
    File::ensureDirectoryExists($directory);

    $filename = uniqid('slide_', true) . '.' . $file->getClientOriginalExtension();
    $file->move($directory, $filename);

    return 'uploads/hero-slides/' . $filename;
  }

  private function deleteImage(?string $path): void
  {
    if ($path && File::exists(public_path($path))) {
      File::delete(public_path($path));
    }
  }
}
