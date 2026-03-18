<div class="mb-3">
  <label class="form-label">Service Title</label>
  <input type="text" name="title" class="form-control" value="{{ old('title', $service->title ?? '') }}" required>
</div>

<div class="mb-3">
  <label class="form-label">Service Icon (Bootstrap Icons class)</label>
  <input type="text" name="icon_class" class="form-control" value="{{ old('icon_class', $service->icon_class ?? 'bi bi-stars') }}" list="serviceIconSuggestions" placeholder="bi bi-code-slash">
  <datalist id="serviceIconSuggestions">
    <option value="bi bi-code-slash"></option>
    <option value="bi bi-phone"></option>
    <option value="bi bi-palette"></option>
    <option value="bi bi-brush"></option>
    <option value="bi bi-cloud"></option>
    <option value="bi bi-megaphone"></option>
    <option value="bi bi-stars"></option>
  </datalist>
  <small class="text-muted">Use any Bootstrap Icons class, e.g. <code>bi bi-code-slash</code>.</small>
</div>

<div class="mb-3">
  <label class="form-label">Featured Image</label>
  <input type="file" name="featured_image" class="form-control" accept="image/*">
  @if(!empty($service?->featured_image))
  <img src="{{ asset($service->featured_image) }}" alt="Featured" class="mt-2" width="140">
  @endif
</div>

<div class="mb-3">
  <label class="form-label">Image Gallery</label>
  <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
  @if(!empty($service?->gallery))
  <div class="row g-2 mt-2">
    @foreach($service->gallery as $image)
    <div class="col-md-3">
      <img src="{{ asset($image) }}" class="img-fluid rounded" alt="Gallery">
      <div class="form-check mt-1">
        <input class="form-check-input" type="checkbox" name="remove_gallery[]" value="{{ $image }}" id="remove_{{ md5($image) }}">
        <label class="form-check-label" for="remove_{{ md5($image) }}">Remove</label>
      </div>
    </div>
    @endforeach
  </div>
  @endif
</div>

<div class="mb-3">
  <label class="form-label">Content (Rich Text)</label>
  <textarea name="content" id="{{ $editorId ?? 'contentEditor' }}" class="form-control" rows="8" required>{{ old('content', $service->content ?? '') }}</textarea>
</div>

<div class="form-check mb-3">
  <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
  <label class="form-check-label" for="is_active">Active</label>
</div>

<button class="btn btn-primary" type="submit">Save</button>
@if(($showCancel ?? true) === true)
<a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancel</a>
@endif