@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h3 class="mb-0">Dashboard Overview</h3>
  <span class="text-muted small">{{ now()->format('d M Y, h:i A') }}</span>
</div>

<div class="row g-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <h6 class="text-muted mb-1">Services</h6>
          <h4 class="mb-0">{{ $servicesCount }}</h4>
        </div>
        <i class="bi bi-briefcase fs-3 text-primary"></i>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <h6 class="text-muted mb-1">Messages</h6>
          <h4 class="mb-0">{{ $messagesCount }}</h4>
        </div>
        <i class="bi bi-envelope fs-3 text-success"></i>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <h6 class="text-muted mb-1">Unread</h6>
          <h4 class="mb-0">{{ $unreadCount }}</h4>
        </div>
        <i class="bi bi-envelope-exclamation fs-3 text-warning"></i>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <h6 class="text-muted mb-1">Users</h6>
          <h4 class="mb-0">{{ $usersCount }}</h4>
        </div>
        <i class="bi bi-people fs-3 text-info"></i>
      </div>
    </div>
  </div>
</div>
@endsection