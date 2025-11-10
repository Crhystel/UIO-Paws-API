<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Login\AuthController;
use App\Http\Controllers\Api\Public\PublicContentController;
use App\Http\Controllers\Api\User\ApplicationController as UserApplicationController;
use App\Http\Controllers\Api\User\UserDonationController;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\Animals\AnimalController;
use App\Http\Controllers\Api\Animals\SpeciesController;
use App\Http\Controllers\Api\Animals\BreedController;
use App\Http\Controllers\Api\Shelters\ShelterController;
use App\Http\Controllers\Api\Donations\DonationItemsCatalogController;
use App\Http\Controllers\Api\Applications\ApplicationStatusController;
use App\Http\Controllers\Api\Applications\AdoptionApplicationController;
use App\Http\Controllers\Api\Applications\VolunteerApplicationController;
use App\Http\Controllers\Api\Donations\DonationController as AdminDonationControl;

// Apunta a Api/Login/AuthController
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Apunta a Api/Public/PublicContentController
Route::prefix('public')->name('public.')->group(function () {
    Route::get('/animals', [PublicContentController::class, 'listAnimals'])->name('animals.index');
    Route::get('/animals/{animal}', [PublicContentController::class, 'showAnimal'])->name('animals.show');
    Route::get('/donation-items', [PublicContentController::class, 'listDonationItems'])->name('donation-items.index');
});
Route::middleware('auth:sanctum')->group(function () {
    // Gestión de Sesión y Perfil (usa el AuthController de Login)
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'userProfile']);

    // Acciones del Usuario (apuntan a controladores en Api/User)
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/my-applications', [UserApplicationController::class, 'getMyApplications'])->name('applications.mine');
        Route::post('/adoption-applications', [UserApplicationController::class, 'storeAdoption'])->name('applications.storeAdoption');
        Route::post('/volunteer-applications', [UserApplicationController::class, 'storeVolunteer'])->name('applications.storeVolunteer');
        Route::post('/donations', [UserDonationController::class, 'store'])->name('donations.store');
    });
});
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Gestión de Usuarios (Apunta a Api/Admin/AdminUserController)
    Route::apiResource('users', AdminUserController::class);

    // Gestión de Animales (Apunta a Api/Animals/*)
    Route::apiResource('animals', AnimalController::class);
    Route::apiResource('species', SpeciesController::class);
    Route::apiResource('breeds', BreedController::class);
    
    // Gestión de Refugios (Apunta a Api/Shelters/*)
    Route::apiResource('shelters', ShelterController::class);

    // Gestión de Catálogos (Apunta a Api/Donations/* y Api/Applications/*)
    Route::apiResource('donation-items-catalog', DonationItemsCatalogController::class);
    Route::apiResource('application-statuses', ApplicationStatusController::class);

    // Revisión de Solicitudes (Apunta a Api/Applications/*)
    Route::get('adoption-applications', [AdoptionApplicationController::class, 'index'])->name('adoption-applications.index');
    Route::get('adoption-applications/{application}', [AdoptionApplicationController::class, 'show'])->name('adoption-applications.show');
    Route::put('adoption-applications/{application}/status', [AdoptionApplicationController::class, 'updateStatus'])->name('adoption-applications.updateStatus');

    Route::get('volunteer-applications', [VolunteerApplicationController::class, 'index'])->name('volunteer-applications.index');
    Route::get('volunteer-applications/{application}', [VolunteerApplicationController::class, 'show'])->name('volunteer-applications.show');
    Route::put('volunteer-applications/{application}/status', [VolunteerApplicationController::class, 'updateStatus'])->name('volunteer-applications.updateStatus');

    // Visualización de Historial de Donaciones (Apunta a Api/Donations/*)
    Route::apiResource('donations', AdminDonationController::class)->only(['index', 'show']);
});