@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<h3 class="mb-3">Contact Messages</h3>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead>
        <tr>
          <th>Status</th>
          <th>Name</th>
          <th>Email</th>
          <th>Subject</th>
          <th>Date</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($messages as $message)
        <tr>
          <td>
            <span class="badge bg-{{ $message->is_read ? 'secondary' : 'warning text-dark' }}">{{ $message->is_read ? 'Read' : 'Unread' }}</span>
          </td>
          <td>{{ $message->name }}</td>
          <td>{{ $message->email }}</td>
          <td>{{ $message->subject }}</td>
          <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
          <td class="text-end">
            <a href="{{ route('admin.contacts.show', $message) }}" class="btn btn-sm btn-outline-primary">View</a>
            @if(!$message->is_read)
            <form action="{{ route('admin.contacts.mark-read', $message) }}" method="POST" class="d-inline">
              @csrf
              @method('PATCH')
              <button class="btn btn-sm btn-outline-success">Mark Read</button>
            </form>
            @endif
            <form action="{{ route('admin.contacts.destroy', $message) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this message?')">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4">No contact messages found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">{{ $messages->links() }}</div>
@endsection