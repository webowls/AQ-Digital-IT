@extends('layouts.admin')

@section('title', 'Manage Portfolio')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Portfolio</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPortfolioModal">Add Project</button>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>Image</th>
          <th>Title</th>
          <th>Category</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($portfolios as $portfolio)
        <tr>
          <td>
            @if($portfolio->featured_image)
            <img src="{{ asset($portfolio->featured_image) }}" width="70" alt="{{ $portfolio->title }}">
            @endif
          </td>
          <td>{{ $portfolio->title }}</td>
          <td>{{ $portfolio->category ?: '-' }}</td>
          <td>
            <span class="badge bg-{{ $portfolio->is_active ? 'success' : 'secondary' }}">{{ $portfolio->is_active ? 'Active' : 'Inactive' }}</span>
          </td>
          <td class="text-end">
            <a href="{{ route('admin.portfolios.edit', $portfolio) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="{{ route('admin.portfolios.destroy', $portfolio) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this portfolio project?')">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center py-4">No portfolio projects found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">{{ $portfolios->links() }}</div>

<div class="modal fade" id="addPortfolioModal" tabindex="-1" aria-labelledby="addPortfolioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPortfolioModalLabel">Add Portfolio Project</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @include('admin.portfolios._form', ['portfolio' => null, 'showCancel' => false])
        </form>
      </div>
    </div>
  </div>
</div>
@endsection