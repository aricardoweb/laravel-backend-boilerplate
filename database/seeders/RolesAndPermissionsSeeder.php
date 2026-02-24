<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        // Create Super Admin User
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@medcare.com'],
            [
                'name' => 'Super Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            ]
        );

        if (!$admin->hasRole('Super Admin')) {
            $admin->assignRole($superAdmin);
        }
    }
}
