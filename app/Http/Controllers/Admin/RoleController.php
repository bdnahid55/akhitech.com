<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index(): View
    {
        Gate::authorize('roles.manage');

        $roles = Role::with(['permissions'])
            ->withCount('users')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        Gate::authorize('roles.manage');

        $modules = config('permission_modules.modules', []);

        return view('admin.roles.create', compact('modules'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('roles.manage');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role = Role::create([
            'name' => trim($validated['name']),
            'guard_name' => 'web',
        ]);

        if (! empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.roles.index')
            ->with('success', 'নতুন রোল সফলভাবে তৈরি হয়েছে!');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role): View
    {
        Gate::authorize('roles.manage');

        $modules = config('permission_modules.modules', []);
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'modules', 'rolePermissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        Gate::authorize('roles.manage');

        $isSuperAdmin = $role->name === 'Super Admin';

        $validated = $request->validate([
            'name' => [
                $isSuperAdmin ? 'nullable' : 'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        if (! $isSuperAdmin && ! empty($validated['name'])) {
            $role->name = trim($validated['name']);
            $role->save();
        }

        // For Super Admin, always ensure all permissions remain or update as selected
        $permissions = $validated['permissions'] ?? [];
        $role->syncPermissions($permissions);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.roles.index')
            ->with('success', 'রোল সফলভাবে আপডেট হয়েছে!');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        Gate::authorize('roles.manage');

        if ($role->name === 'Super Admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'সুপার এডমিন রোল মুছে ফেলা সম্ভব নয়!');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'এই রোলে ইউজার যুক্ত থাকায় এটি মুছে ফেলা যাবে না! আগে ইউজারদের অন্য রোল দিন।');
        }

        $role->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.roles.index')
            ->with('success', 'রোল সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
