<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $guard = 'sanctum';

        foreach (PermissionEnum::cases() as $permission) {
            Permission::firstOrCreate([
                'name' => $permission->value, 
                'guard_name' => $guard
            ]);
        }

        // Roles
        $userRole = Role::firstOrCreate(['name' => RoleEnum::USER->value, 'guard_name' => $guard]);
        
        $adminRole = Role::firstOrCreate(['name' => RoleEnum::ADMIN->value, 'guard_name' => $guard]);
        $adminRole->syncPermissions([ 
            PermissionEnum::MANAGE_ANIMALS->value,
            PermissionEnum::MANAGE_SHELTERS->value,
            PermissionEnum::MANAGE_DONATION_CATALOG->value,
            PermissionEnum::REVIEW_APPLICATIONS->value,
        ]);

        $superAdminRole = Role::firstOrCreate(['name' => RoleEnum::SUPER_ADMIN->value, 'guard_name' => $guard]);
        $superAdminRole->syncPermissions([PermissionEnum::MANAGE_USERS->value]);
    }
}