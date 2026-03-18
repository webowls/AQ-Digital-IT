@extends('layouts.admin')

@section('title', 'Manage Services')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Services</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">Add Service</button>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>Image</th>
          <th>Icon</th>
          <th>Title</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($services as $service)
        <tr>
          <td>
            @if($service->featured_image)
            <img src="{{ asset($service->featured_image) }}" width="70" alt="{{ $service->title }}">
            @endif
          </td>
          <td>
            <i class="{{ $service->icon_class ?: 'bi bi-stars' }}"></i>
            <small class="text-muted d-block">{{ $service->icon_class ?: 'bi bi-stars' }}</small>
          </td>
          <td>{{ $service->title }}</td>
          <td>
            <span class="badge bg-{{ $service->is_active ? 'success' : 'secondary' }}">{{ $service->is_active ? 'Active' : 'Inactive' }}</span>
          </td>
          <td class="text-end">
            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this service?')">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center py-4">No services found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">{{ $services->links() }}</div>

<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addServiceModalLabel">Add Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @include('admin.services._form', ['service' => null, 'showCancel' => false, 'editorId' => 'contentEditorCreate'])
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
  (function() {
    const el = document.getElementById('contentEditorCreate');
    if (el) {
      ClassicEditor.create(el).catch(console.error);
    }
  })();
</script>
@endpush