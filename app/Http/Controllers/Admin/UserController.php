<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::with('roles');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->input('role'));
            });
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        $roles = Role::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function show(int $id): View
    {
        $user = User::with(['roles', 'applications.contest', 'interests.contest'])->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function edit(int $id): View
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone'      => ['nullable', 'string', 'max:50'],
            'country'    => ['nullable', 'string', 'max:100'],
            'city'       => ['nullable', 'string', 'max:100'],
            'is_active'  => ['nullable', 'boolean'],
            'roles'      => ['nullable', 'array'],
            'roles.*'    => ['string', 'exists:roles,name'],
        ]);

        $user->update([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'phone'     => $validated['phone'] ?? null,
            'country'   => $validated['country'] ?? null,
            'city'      => $validated['city'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function toggleActive(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->update(['is_active' => ! $user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "User {$status} successfully.");
    }
}
