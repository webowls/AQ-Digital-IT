@extends('layouts.admin')

@section('title', 'Add Blog')

@section('content')
<h3 class="mb-3">Add Blog</h3>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @include('admin.blogs._form', ['blog' => null, 'editorId' => 'blogEditorCreatePage'])
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
  ClassicEditor.create(document.querySelector('#blogEditorCreatePage')).catch(console.error);
</script>
@endpush