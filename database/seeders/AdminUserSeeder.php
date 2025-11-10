<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Principal',
            'email' => 'admin@adopcion.com',
            'password_hash' => Hash::make('UioPaws123'), 
            'is_active' => true,
        ]);

        $admin->assignRole('admin');
    }
}