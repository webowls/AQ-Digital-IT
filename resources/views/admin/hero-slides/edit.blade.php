@extends('layouts.admin')

@section('title', 'Edit Hero Slide')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Edit Hero Slide</h3>
  <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left me-1"></i> Back
  </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

@if($errors->any())
<div class="alert alert-danger">
  <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.hero-slides.update', $heroSlide) }}" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')
      @include('admin.hero-slides._form', ['slide' => $heroSlide])
    </form>
  </div>
</div>
@endsection