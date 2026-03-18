<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
  public function index(): View
  {
    $messages = ContactMessage::latest()->paginate(20);

    return view('admin.contacts.index', compact('messages'));
  }

  public function show(ContactMessage $contact): View
  {
    if (! $contact->is_read) {
      $contact->update([
        'is_read' => true,
        'read_at' => now(),
      ]);
    }

    return view('admin.contacts.show', compact('contact'));
  }

  public function markRead(ContactMessage $contact): RedirectResponse
  {
    $contact->update([
      'is_read' => true,
      'read_at' => now(),
    ]);

    return back()->with('success', 'Message marked as read.');
  }

  public function destroy(ContactMessage $contact): RedirectResponse
  {
    $contact->delete();

    return back()->with('success', 'Message deleted successfully.');
  }
}
