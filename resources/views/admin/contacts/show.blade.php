@extends('layouts.admin')

@section('title', 'View Contact Message')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Message Details</h3>
  <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
  <div class="card-body">
    <p><strong>Name:</strong> {{ $contact->name }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Subject:</strong> {{ $contact->subject }}</p>
    <p><strong>Received:</strong> {{ $contact->created_at->format('Y-m-d H:i') }}</p>
    <hr>
    <p>{!! nl2br(e($contact->message)) !!}</p>
  </div>
</div>
@endsection