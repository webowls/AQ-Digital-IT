@extends('layouts.admin')

@section('title', 'Hero Slides')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Hero Carousel Slides</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSlideModal">
    <i class="bi bi-plus-lg me-1"></i> Add Slide
  </button>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped mb-0 align-middle">
      <thead>
        <tr>
          <th style="width:80px">Preview</th>
          <th>Tag</th>
          <th>Heading</th>
          <th style="width:80px">Order</th>
          <th style="width:90px">Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($slides as $slide)
        <tr>
          <td>
            @if($slide->illustration)
            <img src="{{ asset($slide->illustration) }}" width="70" height="50" style="object-fit:cover;border-radius:6px" alt="{{ $slide->tag }}">
            @else
            <div style="width:70px;height:50px;border-radius:6px;background:{{ $slide->bg_gradient }};display:flex;align-items:center;justify-content:center">
              <i class="bi bi-image text-white" style="font-size:1.4rem;opacity:0.6"></i>
            </div>
            @endif
          </td>
          <td><span class="badge bg-secondary">{{ $slide->tag }}</span></td>
          <td>{{ Str::limit($slide->heading, 60) }}</td>
          <td class="text-center">{{ $slide->sort_order }}</td>
          <td>
            <span class="badge bg-{{ $slide->is_active ? 'success' : 'secondary' }}">
              {{ $slide->is_active ? 'Active' : 'Inactive' }}
            </span>
          </td>
          <td class="text-end">
            <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this slide?')">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">No slides yet. Add your first slide.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- Add Slide Modal --}}
<div class="modal fade" id="addSlideModal" tabindex="-1" aria-labelledby="addSlideModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSlideModalLabel">Add Hero Slide</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          @include('admin.hero-slides._form', ['inModal' => true])
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Slide</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection