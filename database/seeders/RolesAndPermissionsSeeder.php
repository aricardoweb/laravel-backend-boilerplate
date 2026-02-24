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
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $user = Role::create(['name' => 'User']);

        // Create Super Admin User
        $admin = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@medcare.com',
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
        ]);

        $admin->assignRole($superAdmin);
    }
}
