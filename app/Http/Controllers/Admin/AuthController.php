<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
  public function showLogin(): View
  {
    if (Auth::check() && Auth::user()->canAccessAdminPanel()) {
      return redirect()->route('admin.dashboard');
    }

    return view('admin.auth.login');
  }

  public function login(Request $request): RedirectResponse
  {
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required', 'string'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
      if (! Auth::user()->canAccessAdminPanel()) {
        Auth::logout();

        return back()->withErrors([
          'email' => 'Your account is not allowed to access admin panel.',
        ])->onlyInput('email');
      }

      $request->session()->regenerate();

      return redirect()->intended(route('admin.dashboard'));
    }

    return back()->withErrors([
      'email' => 'Invalid admin credentials.',
    ])->onlyInput('email');
  }

  public function logout(Request $request): RedirectResponse
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login.form');
  }
}
