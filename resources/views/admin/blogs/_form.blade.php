<div class="mb-3">
  <label class="form-label">Title</label>
  <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title ?? '') }}" required>
</div>

<div class="mb-3">
  <label class="form-label">Featured Image</label>
  <input type="file" name="featured_image" class="form-control" accept="image/*">
  @if(!empty($blog?->featured_image))
  <img src="{{ asset($blog->featured_image) }}" alt="Featured" class="mt-2" width="150">
  @endif
</div>

<div class="mb-3">
  <label class="form-label">Image Gallery</label>
  <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
  @if(!empty($blog?->gallery))
  <div class="row g-2 mt-2">
    @foreach($blog->gallery as $image)
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
  <textarea name="content" id="{{ $editorId ?? 'blogEditor' }}" class="form-control" rows="10" required>{{ old('content', $blog->content ?? '') }}</textarea>
</div>

<div class="row g-3">
  <div class="col-md-4">
    <label class="form-label">Tags (optional, comma separated)</label>
    <input type="text" name="tags" class="form-control" value="{{ old('tags', $blog->tags ?? '') }}" placeholder="seo, marketing, web development">
  </div>
  <div class="col-md-4">
    <label class="form-label">Meta Title (optional)</label>
    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $blog->meta_title ?? '') }}">
  </div>
  <div class="col-md-4">
    <label class="form-label">Meta Keywords (optional)</label>
    <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $blog->meta_keywords ?? '') }}">
  </div>
  <div class="col-12">
    <label class="form-label">Meta Description (optional)</label>
    <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
  </div>
</div>

<div class="form-check my-3">
  <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published" {{ old('is_published', $blog->is_published ?? true) ? 'checked' : '' }}>
  <label class="form-check-label" for="is_published">Published</label>
</div>

<button class="btn btn-primary" type="submit">Save Blog</button>
@if(($showCancel ?? true) === true)
<a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
@endif