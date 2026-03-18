<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
  </div>

  <div class="col-md-6">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
  </div>

  <div class="col-md-6">
    <label class="form-label">Password {{ isset($user) ? '(leave blank to keep existing)' : '' }}</label>
    <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
  </div>

  <div class="col-md-3">
    <label class="form-label">User Type</label>
    <select name="user_type" class="form-select" required>
      @php
      $selectedType = old('user_type', $user->user_type ?? 'customer');
      $canManageSuperadmin = $authUser->isSuperadmin();
      @endphp

      @if($canManageSuperadmin)
      <option value="superadmin" {{ $selectedType === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
      @endif
      <option value="admin" {{ $selectedType === 'admin' ? 'selected' : '' }}>Admin</option>
      <option value="customer" {{ $selectedType === 'customer' ? 'selected' : '' }}>Customer</option>
      <option value="editor" {{ $selectedType === 'editor' ? 'selected' : '' }}>Editor</option>
    </select>
  </div>

  <div class="col-md-3">
    <label class="form-label">Account Status</label>
    <select name="account_status" class="form-select" required>
      @php $selectedStatus = old('account_status', $user->account_status ?? 'active'); @endphp
      <option value="active" {{ $selectedStatus === 'active' ? 'selected' : '' }}>Active</option>
      <option value="inactive" {{ $selectedStatus === 'inactive' ? 'selected' : '' }}>Inactive</option>
      <option value="suspended" {{ $selectedStatus === 'suspended' ? 'selected' : '' }}>Suspended</option>
    </select>
  </div>
</div>

<div class="mt-3">
  <button class="btn btn-primary" type="submit">Save User</button>
  <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
</div>