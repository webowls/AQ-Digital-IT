<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
  public function index(): View
  {
    return view('admin.dashboard', [
      'servicesCount' => Service::count(),
      'messagesCount' => ContactMessage::count(),
      'unreadCount' => ContactMessage::where('is_read', false)->count(),
      'usersCount' => User::count(),
    ]);
  }
}
