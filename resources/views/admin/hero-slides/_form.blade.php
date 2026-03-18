@php $s = $slide ?? null; $inModal = $inModal ?? false; @endphp

<div class="row g-3">
  <div class="col-md-8">
    <label class="form-label fw-semibold">Tag Label <span class="text-danger">*</span></label>
    <input type="text" name="tag" class="form-control" value="{{ old('tag', $s?->tag) }}" placeholder="e.g. Web Development" required>
    <small class="text-muted">Short label shown above the heading (e.g. "Mobile Development")</small>
  </div>
  <div class="col-md-4">
    <label class="form-label fw-semibold">Sort Order</label>
    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $s?->sort_order ?? 0) }}" min="0">
    <small class="text-muted">Lower numbers appear first</small>
  </div>
</div>

<div class="mb-3 mt-3">
  <label class="form-label fw-semibold">Heading <span class="text-danger">*</span></label>
  <input type="text" name="heading" class="form-control" value="{{ old('heading', $s?->heading) }}" placeholder="Main headline text" required>
</div>

<div class="mb-3">
  <label class="form-label fw-semibold">Subtitle <span class="text-danger">*</span></label>
  <textarea name="subtitle" class="form-control" rows="3" required>{{ old('subtitle', $s?->subtitle) }}</textarea>
  <small class="text-muted">Supporting description shown below the heading</small>
</div>

<div class="row g-3 mb-3">
  <div class="col-md-8">
    <label class="form-label fw-semibold">Background Gradient</label>
    <input type="text" name="bg_gradient" class="form-control font-monospace" value="{{ old('bg_gradient', $s?->bg_gradient ?? 'linear-gradient(135deg, #06091a 0%, #0d1130 50%, #151845 100%)') }}" required>
    <small class="text-muted">CSS gradient — e.g. <code>linear-gradient(135deg, #06091a, #151845)</code></small>
  </div>
  <div class="col-md-4">
    <label class="form-label fw-semibold">Illustration Glow Color</label>
    <input type="text" name="glow_color" class="form-control font-monospace" value="{{ old('glow_color', $s?->glow_color ?? 'rgba(99, 102, 241, 0.45)') }}" required>
    <small class="text-muted">e.g. <code>rgba(99, 102, 241, 0.45)</code></small>
  </div>
</div>

<div class="mb-3">
  <label class="form-label fw-semibold">Illustration Image</label>
  <input type="file" name="illustration" class="form-control hero-slide-img-input" accept="image/*">

  {{-- Live preview of newly selected file --}}
  <div class="hero-slide-img-preview mt-2" style="display:none">
    <p class="text-muted mb-1" style="font-size:0.82rem">New image preview:</p>
    <img src="" alt="Preview" style="max-height:120px;border-radius:8px;border:1px solid #dee2e6">
  </div>

  {{-- Current image (edit mode) --}}
  @if($s?->illustration)
  <div class="mt-2 d-flex align-items-center gap-3 hero-slide-current-img">
    <img src="{{ asset($s->illustration) }}" alt="Current illustration" style="max-height:100px;border-radius:8px;border:1px solid #dee2e6">
    <small class="text-muted">Current image. Upload a new one to replace it.</small>
  </div>
  @else
  <small class="text-muted">Upload a PNG/SVG/JPG illustration shown on the right side of the slide. Leave empty to use gradient only.</small>
  @endif
</div>

<div class="form-check mb-3">
  <input class="form-check-input" type="checkbox" name="is_active" value="1" id="slide_is_active"
    {{ old('is_active', $s?->is_active ?? true) ? 'checked' : '' }}>
  <label class="form-check-label" for="slide_is_active">Active (visible on homepage)</label>
</div>

{{-- Gradient preview strip --}}
@if($s?->bg_gradient)
<div class="mb-3">
  <small class="text-muted d-block mb-1">Gradient preview:</small>
  <div style="height:28px;border-radius:8px;background:{{ $s->bg_gradient }}"></div>
</div>
@endif

{{-- Save / Cancel buttons — only shown outside the modal (modal has its own footer) --}}
@if(!$inModal)
<div class="d-flex gap-2 mt-4 pt-3 border-top">
  <button type="submit" class="btn btn-primary px-4">
    <i class="bi bi-check-lg me-1"></i> Save Slide
  </button>
  <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-secondary">Cancel</a>
</div>
@endif

<script>
  (function() {
    // Scope to this specific form instance so multiple modals don't conflict
    var inputs = document.querySelectorAll('.hero-slide-img-input');
    inputs.forEach(function(input) {
      input.addEventListener('change', function() {
        var wrapper = input.closest('div.mb-3');
        var preview = wrapper.querySelector('.hero-slide-img-preview');
        var previewImg = preview.querySelector('img');
        var currentImg = wrapper.querySelector('.hero-slide-current-img');
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
            if (currentImg) {
              currentImg.style.display = 'none';
            }
          };
          reader.readAsDataURL(input.files[0]);
        } else {
          preview.style.display = 'none';
          if (currentImg) {
            currentImg.style.display = '';
          }
        }
      });
    });
  }());
</script>