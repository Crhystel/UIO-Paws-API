<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Login\AuthController;
use App\Http\Controllers\Api\Public\PublicContentController;
use App\Http\Controllers\Api\User\ApplicationController as UserApplicationController;
use App\Http\Controllers\Api\User\DonationApplicationController as UserDonationApplicationController;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Middleware\IsAdminMiddleware;

// --- RUTAS PÚBLICAS Y DE AUTENTICACIÓN ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('public')->name('public.')->group(function () {
    Route::get('/animals', [PublicContentController::class, 'listAnimals'])->name('animals.index');
    Route::get('/animals/{animal}', [PublicContentController::class, 'showAnimal'])->name('animals.show');
    Route::get('/donation-items', [PublicContentController::class, 'listDonationItems'])->name('donation-items.index');
});

// --- RUTAS PARA USUARIOS AUTENTICADOS (ROL 'User') ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'userProfile']);

// --- Rutas Protegidas solo para Administradores (CRUD de Usuarios) ---
Route::middleware(['auth:sanctum', IsAdminMiddleware::class])->prefix('admin')->group(function () {
    Route::apiResource('users', AdminUserController::class);
});