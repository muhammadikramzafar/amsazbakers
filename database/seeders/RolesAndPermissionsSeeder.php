<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // --- Permissions ---
        $permissions = [
            // Products
            'view products', 'create products', 'edit products', 'delete products',
            // Categories
            'view categories', 'create categories', 'edit categories', 'delete categories',
            // Reservations
            'view reservations', 'manage reservations',
            // Contact messages
            'view messages', 'delete messages',
            // Gallery
            'view gallery', 'manage gallery',
            // Users
            'view users', 'manage users',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // --- Roles ---

        // Super Admin — full access via Gate::before bypass; no explicit permissions needed
        Role::firstOrCreate(['name' => 'super-admin']);

        // Admin — full content management, no user management
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions([
            'view products', 'create products', 'edit products', 'delete products',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view reservations', 'manage reservations',
            'view messages', 'delete messages',
            'view gallery', 'manage gallery',
        ]);

        // Content Editor — create/edit content only, no deletes, no user management
        $editor = Role::firstOrCreate(['name' => 'content-editor']);
        $editor->syncPermissions([
            'view products', 'create products', 'edit products',
            'view categories', 'create categories', 'edit categories',
            'view reservations',
            'view messages',
            'view gallery', 'manage gallery',
        ]);

        // Remove old 'staff' role if it still exists from a previous seed
        Role::where('name', 'staff')->delete();

        // Assign super-admin role to the seeded admin user
        $adminUser = User::where('email', 'admin@bakerssweets.pk')->first();
        if ($adminUser && ! $adminUser->hasRole('super-admin')) {
            $adminUser->assignRole('super-admin');
        }
    }
}
