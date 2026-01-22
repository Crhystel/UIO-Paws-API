<?php

namespace App\Services;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function registerUser(array $data)
    {
        $data['password_hash'] = Hash::make($data['password']);
        $data['is_active'] = true;
        unset($data['password']);

        $user = User::create($data);
        $user->assignRole(RoleEnum::USER->value); 

        return $user;
    }

    public function attemptLogin(string $email, string $password)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return ['error' => 'Usuario no encontrado en la base de datos.', 'status' => 404];
        }

        if (!Hash::check($password, $user->password_hash)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        $userRole = $user->getRoleNames()->first();

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user_role' => $userRole,
            'status' => 200
        ];
    }
}