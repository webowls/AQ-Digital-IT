@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<h3 class="mb-3">Edit User</h3>

<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
      @csrf
      @method('PUT')
      @include('admin.users._form', ['user' => $user, 'authUser' => $authUser])
    </form>
  </div>
</div>
@endsection