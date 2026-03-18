@extends('layouts.admin')

@section('title', 'Add Service')

@section('content')
<h3 class="mb-3">Add Service</h3>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @include('admin.services._form', ['service' => null, 'editorId' => 'contentEditorCreatePage'])
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
  ClassicEditor.create(document.querySelector('#contentEditorCreatePage')).catch(console.error);
</script>
@endpush