<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\Admin\AnimalController;
use App\Http\Controllers\Api\Admin\SpeciesController;
use App\Http\Controllers\Api\Admin\BreedController;
use App\Http\Controllers\Api\Admin\ShelterController;
use App\Http\Controllers\Api\Admin\DonationItemsCatalogController;
use App\Http\Controllers\Api\Admin\ApplicationStatusController;
use App\Http\Controllers\Api\Admin\AdoptionApplicationController;
use App\Http\Controllers\Api\Admin\VolunteerApplicationController;
use App\Http\Controllers\Api\Admin\DonationController;

// Rutas Públicas 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Rutas para Usuarios Autenticados
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'userProfile']);
});

//Rutas Protegidas solo para Administradores
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    // CRUD de Usuarios
    Route::apiResource('users', AdminUserController::class);
    Route::apiResource('animals', AnimalController::class);
    Route::apiResource('species', SpeciesController::class);
    Route::apiResource('breeds', BreedController::class);
    Route::apiResource('shelters', ShelterController::class);

    // Gestión de Catálogos Generales
    Route::apiResource('donation-items-catalog', DonationItemsCatalogController::class);
    Route::apiResource('application-statuses', ApplicationStatusController::class);

    // Gestión de Solicitudes de Adopción
    Route::get('adoption-applications', [AdoptionApplicationController::class, 'index'])->name('adoption-applications.index');
    Route::get('adoption-applications/{application}', [AdoptionApplicationController::class, 'show'])->name('adoption-applications.show');
    Route::put('adoption-applications/{application}/status', [AdoptionApplicationController::class, 'updateStatus'])->name('adoption-applications.updateStatus');

    // Gestión de Solicitudes de Voluntariado
    Route::get('volunteer-applications', [VolunteerApplicationController::class, 'index'])->name('volunteer-applications.index');
    Route::get('volunteer-applications/{application}', [VolunteerApplicationController::class, 'show'])->name('volunteer-applications.show');
    Route::put('volunteer-applications/{application}/status', [VolunteerApplicationController::class, 'updateStatus'])->name('volunteer-applications.updateStatus');

    // Visualización de Donaciones
    Route::apiResource('donations', DonationController::class)->only(['index', 'show']);
});