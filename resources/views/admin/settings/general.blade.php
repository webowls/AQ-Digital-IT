@extends('layouts.admin')

@section('title', 'General Settings')

@section('content')
<h3 class="mb-3">General / App Settings</h3>

{{-- Branding card --}}
<div class="card mb-4">
  <div class="card-header fw-semibold">Branding</div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.settings.general.save') }}" enctype="multipart/form-data" id="brandingForm">
      @csrf
      <div class="row g-4">

        {{-- Logo --}}
        <div class="col-md-6">
          <label class="form-label fw-semibold">Site Logo</label>
          <div class="branding-preview-box mb-2" id="currentLogoWrap" style="{{ empty($settings['app_logo']) ? 'display:none' : '' }}">
            <img id="currentLogoImg" src="{{ !empty($settings['app_logo']) ? asset($settings['app_logo']) : '' }}" alt="Current Logo"
              style="max-height:52px;max-width:200px;border-radius:6px;background:#f0f0f5;padding:8px 12px;border:1px solid #dee2e6;display:block">
            <span class="text-muted small">Current logo</span>
          </div>
          <div class="branding-preview-box mb-2 d-none" id="logoPreviewWrap">
            <img id="logoPreview" src="" alt="Preview"
              style="max-height:52px;max-width:200px;border-radius:6px;background:#f0f0f5;padding:8px 12px;border:1px dashed #4f46e5;display:block">
            <span class="text-muted small">New logo preview</span>
          </div>
          <input type="file" name="app_logo" class="form-control branding-file-input"
            accept="image/png,image/jpeg,image/svg+xml,image/webp"
            data-preview="logoPreview" data-wrap="logoPreviewWrap" data-current="currentLogoWrap">
          <div class="form-text">PNG, JPG, SVG, WebP — max 2 MB. Transparent background recommended, ~160×40 px.</div>
        </div>

        {{-- Favicon --}}
        <div class="col-md-6">
          <label class="form-label fw-semibold">Favicon</label>
          <div class="branding-preview-box mb-2" id="currentFaviconWrap" style="{{ empty($settings['app_favicon']) ? 'display:none' : '' }}">
            <img id="currentFaviconImg" src="{{ !empty($settings['app_favicon']) ? asset($settings['app_favicon']) : '' }}" alt="Current Favicon"
              style="width:40px;height:40px;border-radius:6px;border:1px solid #dee2e6;background:#f0f0f5;padding:4px;display:block;object-fit:contain">
            <span class="text-muted small">Current favicon</span>
          </div>
          <div class="branding-preview-box mb-2 d-none" id="faviconPreviewWrap">
            <img id="faviconPreview" src="" alt="Preview"
              style="width:40px;height:40px;border-radius:6px;border:1px dashed #4f46e5;background:#f0f0f5;padding:4px;display:block;object-fit:contain">
            <span class="text-muted small">New favicon preview</span>
          </div>
          <input type="file" name="app_favicon" class="form-control branding-file-input"
            accept=".ico,.png,.svg,.jpg,.jpeg"
            data-preview="faviconPreview" data-wrap="faviconPreviewWrap" data-current="currentFaviconWrap">
          <div class="form-text">ICO, PNG, SVG — max 512 KB. Recommended: 32×32 px square.</div>
        </div>

      </div>
      <button class="btn btn-primary mt-3">Save Branding</button>
    </form>
  </div>
</div>

{{-- General settings card --}}
<div class="card">
  <div class="card-header fw-semibold">App &amp; SEO Settings</div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.settings.general.save') }}">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">App Name</label>
          <input type="text" name="app_name" class="form-control" value="{{ old('app_name', $settings['app_name'] ?? 'AQ Digital') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Contact Email</label>
          <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Contact Phone</label>
          <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Landing Heading</label>
          <input type="text" name="landing_heading" class="form-control" value="{{ old('landing_heading', $settings['landing_heading'] ?? '') }}">
        </div>
        <div class="col-12">
          <label class="form-label">App Description</label>
          <textarea name="app_description" class="form-control" rows="3">{{ old('app_description', $settings['app_description'] ?? '') }}</textarea>
        </div>
        <div class="col-12">
          <label class="form-label">Landing Subheading</label>
          <textarea name="landing_subheading" class="form-control" rows="3">{{ old('landing_subheading', $settings['landing_subheading'] ?? '') }}</textarea>
        </div>
        <div class="col-12">
          <label class="form-label">Contact Address</label>
          <textarea name="contact_address" class="form-control" rows="3">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
        </div>

        <div class="col-12">
          <hr>
        </div>
        <div class="col-12">
          <h5 class="mb-0">SEO Settings</h5>
        </div>
        <div class="col-md-6">
          <label class="form-label">SEO Home Title</label>
          <input type="text" name="seo_home_title" class="form-control" value="{{ old('seo_home_title', $settings['seo_home_title'] ?? '') }}" maxlength="255">
        </div>
        <div class="col-md-6">
          <label class="form-label">SEO Home Keywords</label>
          <input type="text" name="seo_home_keywords" class="form-control" value="{{ old('seo_home_keywords', $settings['seo_home_keywords'] ?? '') }}" maxlength="255" placeholder="digital, web development, seo">
        </div>
        <div class="col-12">
          <label class="form-label">SEO Home Description (max 160 chars)</label>
          <textarea name="seo_home_description" class="form-control" rows="2" maxlength="160">{{ old('seo_home_description', $settings['seo_home_description'] ?? '') }}</textarea>
        </div>
      </div>
      <button class="btn btn-primary mt-3">Save Settings</button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.querySelectorAll('.branding-file-input').forEach(function(input) {
    input.addEventListener('change', function() {
      var file = this.files[0];
      if (!file) return;
      var previewImg = document.getElementById(this.dataset.preview);
      var previewWrap = document.getElementById(this.dataset.wrap);
      var currentWrap = this.dataset.current ? document.getElementById(this.dataset.current) : null;
      var reader = new FileReader();
      reader.onload = function(e) {
        previewImg.src = e.target.result;
        previewWrap.classList.remove('d-none');
        if (currentWrap) currentWrap.style.display = 'none';
      };
      reader.readAsDataURL(file);
    });
  });
</script>
@endpush