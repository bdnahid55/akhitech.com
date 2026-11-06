<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $modules = config('permission_modules.modules', []);

        $allPermissionNames = [];
        $editorPermissionNames = [];

        foreach ($modules as $moduleKey => $module) {
            foreach (array_keys($module['permissions'] ?? []) as $permissionName) {
                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]);

                $allPermissionNames[] = $permissionName;

                // Grant Editor role all content management modules
                if (in_array($moduleKey, ['services', 'packages', 'portfolios', 'posts', 'testimonials', 'achievements', 'pages', 'team'], true)) {
                    $editorPermissionNames[] = $permissionName;
                }
            }
        }

        // Create Super Admin role and grant all permissions
        $superAdminRole = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);
        $superAdminRole->syncPermissions($allPermissionNames);

        // Create Editor role
        $editorRole = Role::firstOrCreate([
            'name' => 'Editor',
            'guard_name' => 'web',
        ]);
        $editorRole->syncPermissions($editorPermissionNames);

        // Assign Super Admin role to default admin user
        $defaultAdmin = User::where('email', 'admin@akhitech.com')->first();
        if ($defaultAdmin) {
            $defaultAdmin->assignRole($superAdminRole);
        }

        // For any existing users that have no roles, assign Super Admin
        $usersWithoutRoles = User::doesntHave('roles')->get();
        foreach ($usersWithoutRoles as $user) {
            $user->assignRole($superAdminRole);
        }
    }
}
