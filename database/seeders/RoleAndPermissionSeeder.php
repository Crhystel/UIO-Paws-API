<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'manage users', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'manage animals', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'manage shelters', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'manage donation_catalog', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'review applications', 'guard_name' => 'sanctum']);

        // ROL 1: Usuario Normal 
        Role::create(['name' => 'User', 'guard_name' => 'sanctum']);

        // ROL 2: Admin 
        $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'sanctum']);
        $adminRole->givePermissionTo([
            'manage animals',
            'manage shelters',
            'manage donation_catalog',
            'review applications',
        ]);

        // ROL 3: Super Admin
        $superAdminRole = Role::create(['name' => 'Super Admin', 'guard_name' => 'sanctum']);
        $superAdminRole->givePermissionTo('manage users');
    }
}