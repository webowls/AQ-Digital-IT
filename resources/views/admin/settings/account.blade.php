@extends('layouts.admin')

@section('title', 'Account Settings')

@section('content')
<h3 class="mb-3">Account Settings</h3>
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('admin.settings.account.save') }}">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Phone</label>
          <input type="text" name="phone" class="form-control" value="{{ old('phone', $admin->phone) }}">
        </div>
        <div class="col-md-6 d-flex align-items-end">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="two_factor_enabled" value="1" id="two_factor_enabled" {{ old('two_factor_enabled', $admin->two_factor_enabled) ? 'checked' : '' }}>
            <label class="form-check-label" for="two_factor_enabled">Enable 2FA (requires SMTP)</label>
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label">New Password</label>
          <input type="password" name="password" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="password_confirmation" class="form-control">
        </div>
      </div>
      <button class="btn btn-primary mt-3">Update Account</button>
    </form>
  </div>
</div>
@endsection