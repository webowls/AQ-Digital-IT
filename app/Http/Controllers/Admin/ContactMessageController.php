<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
  public function index(): View
  {
    $messages = ContactMessage::latest()->paginate(20);

    return view('admin.contacts.index', compact('messages'));
  }

  public function show(Request $request, ContactMessage $contact): JsonResponse|View
  {
    if (! $contact->is_read) {
      $contact->update(['is_read' => true, 'read_at' => now()]);
    }

    if ($request->expectsJson()) {
      return response()->json([
        'id'         => $contact->id,
        'name'       => $contact->name,
        'email'      => $contact->email,
        'subject'    => $contact->subject,
        'message'    => $contact->message,
        'is_read'    => $contact->is_read,
        'created_at' => $contact->created_at->format('M d, Y \a\t h:i A'),
      ]);
    }

    return view('admin.contacts.show', compact('contact'));
  }

  public function markRead(Request $request, ContactMessage $contact): JsonResponse|RedirectResponse
  {
    $contact->update(['is_read' => true, 'read_at' => now()]);

    if ($request->expectsJson()) {
      return response()->json(['success' => true]);
    }

    return back()->with('success', 'Message marked as read.');
  }

  public function destroy(Request $request, ContactMessage $contact): JsonResponse|RedirectResponse
  {
    $contact->delete();

    if ($request->expectsJson()) {
      return response()->json(['success' => true]);
    }

    return back()->with('success', 'Message deleted successfully.');
  }
}
