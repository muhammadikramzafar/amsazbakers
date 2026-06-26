<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

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

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

        // --- Roles ---

        // Super Admin gets everything (bypass all permission checks via Gate::before)
        $superAdmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super-admin']);

        // Admin gets all except user management
        $admin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions([
            'view products', 'create products', 'edit products', 'delete products',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view reservations', 'manage reservations',
            'view messages', 'delete messages',
            'view gallery', 'manage gallery',
        ]);

        // Staff can view and manage reservations / messages only
        $staff = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'staff']);
        $staff->syncPermissions([
            'view products',
            'view categories',
            'view reservations', 'manage reservations',
            'view messages',
        ]);

        // Assign super-admin role to the seeded admin user
        $adminUser = \App\Models\User::where('email', 'admin@bakerssweets.pk')->first();
        if ($adminUser) {
            $adminUser->assignRole('super-admin');
        }
    }
}
