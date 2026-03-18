@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Users</h3>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Type</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td><span class="badge bg-info text-dark">{{ ucfirst($user->user_type) }}</span></td>
          <td>
            <span class="badge bg-{{ $user->account_status === 'active' ? 'success' : ($user->account_status === 'inactive' ? 'secondary' : 'warning text-dark') }}">
              {{ ucfirst($user->account_status) }}
            </span>
          </td>
          <td class="text-end">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this user?')">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center py-4">No users found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">{{ $users->links() }}</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
          @csrf
          @include('admin.users._form', ['user' => null, 'authUser' => $authUser])
        </form>
      </div>
    </div>
  </div>
</div>
@endsection