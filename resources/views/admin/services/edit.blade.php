@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')
<h3 class="mb-3">Edit Service</h3>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('admin.services._form', ['service' => $service, 'editorId' => 'contentEditorEditPage'])
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
  ClassicEditor.create(document.querySelector('#contentEditorEditPage')).catch(console.error);
</script>
@endpush