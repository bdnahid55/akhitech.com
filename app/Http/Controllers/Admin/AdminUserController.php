<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    /**
     * Display a listing of admin users.
     */
    public function index(): View
    {
        Gate::authorize('admins.view');

        $admins = User::with('roles')->latest()->paginate(15);

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin account.
     */
    public function create(): View
    {
        Gate::authorize('admins.create');

        $roles = Role::all();

        return view('admin.admins.create', compact('roles'));
    }

    /**
     * Store a newly created admin account in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('admins.create');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'password' => $validated['password'],
        ]);

        if (! empty($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        return redirect()->route('admin.admins.index')
            ->with('success', 'নতুন এডমিন একাউন্ট সফলভাবে তৈরি হয়েছে!');
    }

    /**
     * Show the form for editing the specified admin account.
     */
    public function edit(User $admin): View
    {
        Gate::authorize('admins.edit');

        $roles = Role::all();
        $adminRoles = $admin->roles->pluck('name')->toArray();

        return view('admin.admins.edit', compact('admin', 'roles', 'adminRoles'));
    }

    /**
     * Update the specified admin account in storage.
     */
    public function update(Request $request, User $admin): RedirectResponse
    {
        Gate::authorize('admins.edit');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$admin->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
        ];

        if (! empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $admin->update($data);

        // Prevent self-demotion from Super Admin if the current user is editing themselves and is the only Super Admin
        if (isset($validated['roles'])) {
            $admin->syncRoles($validated['roles']);
        }

        return redirect()->route('admin.admins.index')
            ->with('success', 'এডমিন একাউন্ট সফলভাবে আপডেট হয়েছে!');
    }

    /**
     * Remove the specified admin account from storage.
     */
    public function destroy(User $admin): RedirectResponse
    {
        Gate::authorize('admins.delete');

        if ($admin->id === Auth::id()) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'আপনি নিজের এডমিন একাউন্ট মুছে ফেলতে পারবেন না!');
        }

        if (User::count() <= 1) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'কমপক্ষে একজন এডমিন একাউন্ট থাকা আবশ্যক!');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'এডমিন একাউন্ট সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
