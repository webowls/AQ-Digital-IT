@extends('layouts.admin')

@section('title', 'Edit Blog')

@section('content')
<h3 class="mb-3">Edit Blog</h3>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('admin.blogs._form', ['blog' => $blog, 'editorId' => 'blogEditorEditPage'])
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
  ClassicEditor.create(document.querySelector('#blogEditorEditPage')).catch(console.error);
</script>
@endpush