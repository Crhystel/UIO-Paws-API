<?php

namespace App\Http\Controllers\Api\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\RegisterRequest;
use App\Http\Requests\Login\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $this->authService->registerUser($request->validated());
        
        return response()->json(['message' => 'Usuario registrado exitosamente.'], 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->attemptLogin(
            $request->email, 
            $request->password
        );

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], $result['status']);
        }

        return response()->json($result, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada.']);
    }

    public function userProfile(Request $request)
    {
        return response()->json($request->user()->load('roles'));
    }
}