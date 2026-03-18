@extends('layouts.admin')

@section('title', 'Environment Variables')

@section('content')
<h3 class="mb-3">Environment Variables</h3>
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('admin.settings.environment.save') }}">
      @csrf
      <div class="row g-3">
        @foreach($values as $key => $value)
        <div class="col-md-6">
          <label class="form-label">{{ $key }}</label>
          <input type="text" name="{{ $key }}" class="form-control" value="{{ old($key, $value) }}" {{ $key === 'DB_PASSWORD' ? '' : 'required' }}>
        </div>
        @endforeach
        <div class="col-md-6">
          <label class="form-label">DB_PASSWORD</label>
          <input type="text" name="DB_PASSWORD" class="form-control" value="{{ old('DB_PASSWORD', env('DB_PASSWORD')) }}">
        </div>
      </div>
      <button class="btn btn-primary mt-3">Save Environment</button>
    </form>
  </div>
</div>
@endsection