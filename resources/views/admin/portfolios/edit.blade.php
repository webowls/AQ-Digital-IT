@extends('layouts.admin')

@section('title', 'Edit Portfolio Project')

@section('content')
<h3 class="mb-3">Edit Portfolio Project</h3>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('admin.portfolios._form', ['portfolio' => $portfolio])
    </form>
  </div>
</div>
@endsection