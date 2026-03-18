<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
  public function index(): View
  {
    $authUser = Auth::user();

    $users = User::query()
      ->when(! $authUser->isSuperadmin(), function ($query): void {
        $query->where('user_type', '!=', 'superadmin');
      })
      ->latest()
      ->paginate(20);

    return view('admin.users.index', [
      'users' => $users,
      'authUser' => $authUser,
    ]);
  }

  public function edit(User $user): View
  {
    $authUser = Auth::user();

    if ($user->isSuperadmin() && ! $authUser->isSuperadmin()) {
      abort(403, 'Only superadmin can manage superadmin users.');
    }

    return view('admin.users.edit', compact('user', 'authUser'));
  }

  public function store(Request $request): RedirectResponse
  {
    $authUser = Auth::user();

    $data = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', 'unique:users,email'],
      'password' => ['required', 'string', 'min:8'],
      'user_type' => ['required', 'string', 'max:50'],
      'account_status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
    ]);

    if ($data['user_type'] === 'superadmin' && ! $authUser->isSuperadmin()) {
      return back()->withErrors(['user_type' => 'Only superadmin can create a superadmin user.'])->withInput();
    }

    User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
      'user_type' => $data['user_type'],
      'is_admin' => in_array($data['user_type'], ['superadmin', 'admin'], true),
      'account_status' => $data['account_status'],
      'two_factor_enabled' => false,
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
  }

  public function update(Request $request, User $user): RedirectResponse
  {
    $authUser = Auth::user();

    if ($user->isSuperadmin() && ! $authUser->isSuperadmin()) {
      abort(403, 'Only superadmin can manage superadmin users.');
    }

    $data = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
      'password' => ['nullable', 'string', 'min:8'],
      'user_type' => ['required', 'string', 'max:50'],
      'account_status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
    ]);

    if ($data['user_type'] === 'superadmin' && ! $authUser->isSuperadmin()) {
      return back()->withErrors(['user_type' => 'Only superadmin can assign superadmin role.'])->withInput();
    }

    if ($user->isSuperadmin() && $authUser->isSuperadmin()) {
      $willDemote = $data['user_type'] !== 'superadmin';
      $willDisable = $data['account_status'] !== 'active';
      $superadminCount = User::where('user_type', 'superadmin')->count();

      if (($willDemote || $willDisable) && $superadminCount <= 1) {
        return back()->withErrors(['user_type' => 'At least one active superadmin must exist in the system.'])->withInput();
      }
    }

    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->user_type = $data['user_type'];
    $user->is_admin = in_array($data['user_type'], ['superadmin', 'admin'], true);
    $user->account_status = $data['account_status'];

    if (! empty($data['password'])) {
      $user->password = Hash::make($data['password']);
    }

    $user->save();

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
  }

  public function destroy(User $user): RedirectResponse
  {
    $authUser = Auth::user();

    if ($user->id === $authUser->id) {
      return back()->withErrors(['user' => 'You cannot delete your own account.']);
    }

    if ($user->isSuperadmin() && ! $authUser->isSuperadmin()) {
      abort(403, 'Only superadmin can manage superadmin users.');
    }

    if ($user->isSuperadmin()) {
      $superadminCount = User::where('user_type', 'superadmin')->count();
      if ($superadminCount <= 1) {
        return back()->withErrors(['user' => 'At least one superadmin must exist in the system.']);
      }
    }

    $user->delete();

    return back()->with('success', 'User deleted successfully.');
  }
}
