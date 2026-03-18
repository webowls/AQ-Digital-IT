@extends('layouts.admin')

@section('title', 'General Settings')

@section('content')
<h3 class="mb-3">General / App Settings</h3>
<div class="card">
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