<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Public\PublicContentController;
use App\Http\Controllers\Api\User\ApplicationController as UserApplicationController;
use App\Http\Controllers\Api\User\UserDonationController;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\Admin\AnimalController;
use App\Http\Controllers\Api\Admin\SpeciesController;
use App\Http\Controllers\Api\Admin\BreedController;
use App\Http\Controllers\Api\Admin\ShelterController;
use App\Http\Controllers\Api\Admin\DonationItemsCatalogController;
use App\Http\Controllers\Api\Admin\ApplicationStatusController;
use App\Http\Controllers\Api\Admin\AdoptionApplicationController;
use App\Http\Controllers\Api\Admin\VolunteerApplicationController;
use App\Http\Controllers\Api\Admin\DonationController as AdminDonationController;

// Autenticación (Login/Registro)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Contenido para Visitantes
Route::prefix('public')->name('public.')->group(function () {
    Route::get('/animals', [PublicContentController::class, 'listAnimals'])->name('animals.index');
    Route::get('/animals/{animal}', [PublicContentController::class, 'showAnimal'])->name('animals.show');
    Route::get('/donation-items', [PublicContentController::class, 'listDonationItems'])->name('donation-items.index');
});
Route::middleware('auth:sanctum')->group(function () {
    // Gestión de Sesión y Perfil
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'userProfile']);

    // Acciones del Usuario (Solicitudes, Donaciones)
    Route::prefix('user')->name('user.')->group(function () {
        // Consultar mis solicitudes
        Route::get('/my-applications', [UserApplicationController::class, 'getMyApplications'])->name('applications.mine');

        // Enviar nuevas solicitudes
        Route::post('/adoption-applications', [UserApplicationController::class, 'storeAdoption'])->name('applications.storeAdoption');
        Route::post('/volunteer-applications', [UserApplicationController::class, 'storeVolunteer'])->name('applications.storeVolunteer');
        
        // Realizar una donación
        Route::post('/donations', [UserDonationController::class, 'store'])->name('donations.store');
    });
});
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Gestión de Entidades Principales (CRUDs)
    Route::apiResource('users', AdminUserController::class);
    Route::apiResource('animals', AnimalController::class);
    Route::apiResource('species', SpeciesController::class);
    Route::apiResource('breeds', BreedController::class);
    Route::apiResource('shelters', ShelterController::class);

    // Gestión de Catálogos
    Route::apiResource('donation-items-catalog', DonationItemsCatalogController::class);
    Route::apiResource('application-statuses', ApplicationStatusController::class);

    // Revisión de Solicitudes
    Route::get('adoption-applications', [AdoptionApplicationController::class, 'index'])->name('adoption-applications.index');
    Route::get('adoption-applications/{application}', [AdoptionApplicationController::class, 'show'])->name('adoption-applications.show');
    Route::put('adoption-applications/{application}/status', [AdoptionApplicationController::class, 'updateStatus'])->name('adoption-applications.updateStatus');

    Route::get('volunteer-applications', [VolunteerApplicationController::class, 'index'])->name('volunteer-applications.index');
    Route::get('volunteer-applications/{application}', [VolunteerApplicationController::class, 'show'])->name('volunteer-applications.show');
    Route::put('volunteer-applications/{application}/status', [VolunteerApplicationController::class, 'updateStatus'])->name('volunteer-applications.updateStatus');

    // Visualización de Historial de Donaciones
    Route::apiResource('donations', AdminDonationController::class)->only(['index', 'show']);
});