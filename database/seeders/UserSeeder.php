<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Super',
                'last_name'  => 'Admin',
                'email'      => 'superadmin@adopcion.com',
                'password'   => 'UioPawsSuperAdmin123',
                'role'       => RoleEnum::SUPER_ADMIN
            ],
            [
                'first_name' => 'Admin',
                'last_name'  => 'Principal',
                'email'      => 'admin@adopcion.com',
                'password'   => 'UioPawsAdmin123',
                'role'       => RoleEnum::ADMIN
            ],
            [
                'first_name' => 'Usuario',
                'last_name'  => 'Ejemplo',
                'email'      => 'user@adopcion.com',
                'password'   => 'UioPawsUser123',
                'role'       => RoleEnum::USER
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'first_name'    => $userData['first_name'],
                    'last_name'     => $userData['last_name'],
                    'password_hash' => Hash::make($userData['password']),
                    'is_active'     => true,
                ]
            );

            $user->assignRole($userData['role']->value);
        }
    }
}