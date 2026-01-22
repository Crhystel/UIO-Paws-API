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
                'first_name' => 'Juan',
                'last_name'  => 'Admin',
                'email'      => 'juan@gmail.com',
                'password'   => '123456789',
                'role'       => RoleEnum::SUPER_ADMIN
            ],
            [
                'first_name' => 'Alva',
                'last_name'  => 'Principal',
                'email'      => 'alva@gmail.com',
                'password'   => '123456789',
                'role'       => RoleEnum::ADMIN
            ],
            [
                'first_name' => 'Ana',
                'last_name'  => 'Ejemplo',
                'email'      => 'ana@gmail.com',
                'password'   => '123456789',
                'role'       => RoleEnum::USER
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']], // Busca por email
                [
                    'first_name'    => $userData['first_name'],
                    'last_name'     => $userData['last_name'],
                    'password_hash' => Hash::make($userData['password']),
                    'is_active'     => true,
                ]
            );

            // Solo asigna el rol si no lo tiene para evitar errores
            if (!$user->hasRole($userData['role']->value)) {
                $user->assignRole($userData['role']->value);
            }
        }
    }
}