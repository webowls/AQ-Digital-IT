<div class="mb-3">
  <label class="form-label">Project Title</label>
  <input type="text" name="title" class="form-control" value="{{ old('title', $portfolio->title ?? '') }}" required>
</div>

<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Category (optional)</label>
    <input type="text" name="category" class="form-control" value="{{ old('category', $portfolio->category ?? '') }}" placeholder="Web Development">
  </div>
  <div class="col-md-6">
    <label class="form-label">Project URL (optional)</label>
    <input type="url" name="project_url" class="form-control" value="{{ old('project_url', $portfolio->project_url ?? '') }}" placeholder="https://example.com">
  </div>
</div>

<div class="mb-3 mt-3">
  <label class="form-label">Featured Image</label>
  <input type="file" name="featured_image" class="form-control" accept="image/*">
  @if(!empty($portfolio?->featured_image))
  <img src="{{ asset($portfolio->featured_image) }}" alt="Featured" class="mt-2" width="140">
  @endif
</div>

<div class="mb-3">
  <label class="form-label">Image Gallery</label>
  <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
  @if(!empty($portfolio?->gallery))
  <div class="row g-2 mt-2">
    @foreach($portfolio->gallery as $image)
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
  <label class="form-label">Description</label>
  <textarea name="description" class="form-control" rows="6" required>{{ old('description', $portfolio->description ?? '') }}</textarea>
</div>

<div class="form-check mb-3">
  <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $portfolio->is_active ?? true) ? 'checked' : '' }}>
  <label class="form-check-label" for="is_active">Active</label>
</div>

<button class="btn btn-primary" type="submit">Save Project</button>
@if(($showCancel ?? true) === true)
<a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary">Cancel</a>
@endif