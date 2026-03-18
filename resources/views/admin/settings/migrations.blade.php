@extends('layouts.admin')

@section('title', 'Migrations')

@section('content')
<h3 class="mb-3">Migrations</h3>

<div class="card mb-3">
  <div class="card-body">
    <form method="POST" action="{{ route('admin.settings.migrations.run') }}">
      @csrf
      <button class="btn btn-primary">Run Pending Migrations</button>
    </form>
  </div>
</div>

<div class="card mb-3">
  <div class="card-header">Last Migration</div>
  <div class="card-body">
    @if($lastMigration)
    <p class="mb-0"><strong>Migration:</strong> {{ $lastMigration->migration }}</p>
    <p class="mb-0"><strong>Batch:</strong> {{ $lastMigration->batch }}</p>
    @else
    <p class="mb-0">No migration history found yet.</p>
    @endif
  </div>
</div>

<div class="card">
  <div class="card-header">Migration Status</div>
  <div class="card-body">
    <pre class="mb-0">{{ $statusOutput }}</pre>
  </div>
</div>
@endsection