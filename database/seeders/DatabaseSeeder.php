<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class, 
            ApplicationStatusSeeder::class, 
        ]);
        $superAdmin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@adopcion.com',
            'password_hash' => Hash::make('UioPawsSuperAdmin123'),
            'is_active' => true,
        ]);
        $superAdmin->assignRole('Super Admin');

        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Principal',
            'email' => 'admin@adopcion.com',
            'password_hash' => Hash::make('UioPawsAdmin123'),
            'is_active' => true,
        ]);
        $admin->assignRole('Admin');
        $user = User::create([
            'first_name' => 'Usuario',
            'last_name' => 'Ejemplo',
            'email' => 'user@adopcion.com',
            'password_hash' => Hash::make('UioPawsUser123'),
            'is_active' => true,
        ]);
        $user->assignRole('User');
    }
}