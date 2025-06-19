<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Role management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // Permission management
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',

            // Content management
            'view content',
            'create content',
            'edit content',
            'delete content',

            // Settings
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Manager role
        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'view roles',
            'view permissions',
            'view content',
            'create content',
            'edit content',
            'delete content',
            'manage settings',
        ]);



        // Create admin user
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Create manager user
        $manager = User::create([
            'first_name' => 'Manager',
            'last_name' => 'User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
        ]);
        $manager->assignRole('manager');


    }
}
