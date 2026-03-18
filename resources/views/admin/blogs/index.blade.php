@extends('layouts.admin')

@section('title', 'Manage Blogs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Blogs</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlogModal">Add Blog</button>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>Image</th>
          <th>Title</th>
          <th>Slug</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($blogs as $blog)
        <tr>
          <td>@if($blog->featured_image)<img src="{{ asset($blog->featured_image) }}" width="70" alt="{{ $blog->title }}">@endif</td>
          <td>{{ $blog->title }}</td>
          <td><code>{{ $blog->slug }}</code></td>
          <td><span class="badge bg-{{ $blog->is_published ? 'success' : 'secondary' }}">{{ $blog->is_published ? 'Published' : 'Draft' }}</span></td>
          <td class="text-end">
            <a href="{{ route('blogs.show', $blog) }}" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
            <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this blog?')">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center py-4">No blogs found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">{{ $blogs->links() }}</div>

<div class="modal fade" id="addBlogModal" tabindex="-1" aria-labelledby="addBlogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBlogModalLabel">Add Blog</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @include('admin.blogs._form', ['blog' => null, 'showCancel' => false, 'editorId' => 'blogEditorCreate'])
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
    const el = document.getElementById('blogEditorCreate');
    if (el) {
      ClassicEditor.create(el).catch(console.error);
    }
  })();
</script>
@endpush