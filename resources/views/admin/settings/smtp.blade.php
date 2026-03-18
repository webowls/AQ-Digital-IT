@extends('layouts.admin')

@section('title', 'SMTP Settings')

@section('content')
<h3 class="mb-3">SMTP Settings</h3>

<div class="card mb-3">
  <div class="card-body">
    <form method="POST" action="{{ route('admin.settings.smtp.save') }}">
      @csrf
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Mailer</label>
          <input type="text" name="mailer" class="form-control" value="{{ old('mailer', $smtp->mailer ?? 'smtp') }}" required>
        </div>
        <div class="col-md-5">
          <label class="form-label">Host</label>
          <input type="text" name="host" class="form-control" value="{{ old('host', $smtp->host ?? '') }}">
        </div>
        <div class="col-md-2">
          <label class="form-label">Port</label>
          <input type="number" name="port" class="form-control" value="{{ old('port', $smtp->port ?? '') }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="smtp_active" {{ old('is_active', $smtp->is_active ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="smtp_active">Active</label>
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" value="{{ old('username', $smtp->username ?? '') }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Leave blank to keep existing">
        </div>
        <div class="col-md-4">
          <label class="form-label">Encryption</label>
          <input type="text" name="encryption" class="form-control" value="{{ old('encryption', $smtp->encryption ?? '') }}" placeholder="tls/ssl">
        </div>
        <div class="col-md-4">
          <label class="form-label">From Address</label>
          <input type="email" name="from_address" class="form-control" value="{{ old('from_address', $smtp->from_address ?? '') }}">
        </div>
        <div class="col-md-4">
          <label class="form-label">From Name</label>
          <input type="text" name="from_name" class="form-control" value="{{ old('from_name', $smtp->from_name ?? '') }}">
        </div>
      </div>
      <button class="btn btn-primary mt-3">Save SMTP</button>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h5>Test SMTP</h5>
    <form method="POST" action="{{ route('admin.settings.smtp.test') }}" class="row g-2">
      @csrf
      <div class="col-md-8">
        <input type="email" name="test_email" class="form-control" placeholder="Enter recipient email" required>
      </div>
      <div class="col-md-4">
        <button class="btn btn-success w-100">Send Test Email</button>
      </div>
    </form>
  </div>
</div>
@endsection