<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Login\AuthController;
use App\Http\Controllers\Api\Public\PublicContentController;
use App\Http\Controllers\Api\User\ApplicationController as UserApplicationController;
use App\Http\Controllers\Api\User\UserDonationApplicationController;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\Animals\AnimalController;
use App\Http\Controllers\Api\Animals\SpeciesController;
use App\Http\Controllers\Api\Animals\BreedController;
use App\Http\Controllers\Api\Shelters\ShelterController;
use App\Http\Controllers\Api\Donations\DonationItemsCatalogController;
use App\Http\Controllers\Api\Applications\ApplicationStatusController;
use App\Http\Controllers\Api\Applications\AdoptionApplicationController;
use App\Http\Controllers\Api\Applications\VolunteerApplicationController;
use App\Http\Controllers\Api\Applications\DonationApplicationController as AdminDonationApplicationController;
use App\Http\Controllers\Api\Donations\DonationController as AdminDonationController;
use App\Http\Controllers\Api\Animals\AnimalPhotoController;
use App\Http\Controllers\Api\Animals\MedicalRecordController;
use App\Http\Controllers\Api\Volunteers\VolunteerOpportunityController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\Admin\ApplicationController as AdminApplicationController;

// --- RUTAS PÚBLICAS Y DE AUTENTICACIÓN ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('public')->name('public.')->group(function () {
    Route::get('/animals', [PublicContentController::class, 'listAnimals'])->name('animals.index');
    Route::get('/animals/{animal}', [PublicContentController::class, 'showAnimal'])->name('animals.show');
    Route::get('/donation-items', [PublicContentController::class, 'listDonationItems'])->name('donation-items.index');
    Route::get('/volunteer-opportunities', [PublicContentController::class, 'listVolunteerOpportunities'])->name('volunteer-opportunities.index');
    Route::get('/breeds', [BreedController::class, 'index']); 
    Route::get('/shelters', [ShelterController::class, 'index']);
    Route::get('/species', [SpeciesController::class, 'index']);
});

// --- RUTAS PARA USUARIOS AUTENTICADOS ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // RUTA PRINCIPAL DE PERFIL
    Route::get('/profile', [ProfileController::class, 'getProfile']);

    // RUTAS AGRUPADAS POR LÓGICA DE USUARIO
    Route::prefix('user')->name('user.')->group(function () {
        // --- GESTIÓN DE APLICACIONES ---
        Route::get('/my-applications', [UserApplicationController::class, 'getMyApplications'])->name('applications.mine');
        Route::post('/adoption-applications', [UserApplicationController::class, 'storeAdoption'])->name('applications.storeAdoption');
        Route::post('/volunteer-applications', [UserApplicationController::class, 'storeVolunteer'])->name('applications.storeVolunteer');
        Route::post('/donation-applications', [UserDonationApplicationController::class, 'store'])->name('donations.apply');
        
        // --- GESTIÓN DE PERFIL ---
        Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
        Route::post('/profile/photo', [ProfileController::class, 'updateProfilePhoto'])->name('profile.photo.update');

        // --- GESTIÓN DE CONTACTOS DE EMERGENCIA ---
        Route::get('/emergency-contacts', [ProfileController::class, 'getEmergencyContacts'])->name('contacts.index');
        Route::post('/emergency-contacts', [ProfileController::class, 'storeEmergencyContact'])->name('contacts.store');
        Route::delete('/emergency-contacts/{contact}', [ProfileController::class, 'destroyEmergencyContact'])->name('contacts.destroy');
    });
});

// --- GESTIÓN DE USUARIOS (SOLO SUPER ADMIN) ---
Route::middleware(['auth:sanctum', 'permission:manage users'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::apiResource('users', AdminUserController::class);
    });

// --- GESTIÓN Y SOLICITUDES (SOLO ADMIN) ---
Route::middleware(['auth:sanctum', 'permission:manage animals|manage shelters|manage donation_catalog|review applications'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    
        // -----------------------------------------------------------------
        // GESTIÓN DE RECURSOS PRINCIPALES (Animales, Refugios, Catálogos)
        // -----------------------------------------------------------------
        Route::apiResource('animals', AnimalController::class);
        Route::apiResource('species', SpeciesController::class);
        Route::apiResource('breeds', BreedController::class);
        Route::apiResource('shelters', ShelterController::class);
        Route::apiResource('application-statuses', ApplicationStatusController::class);
        Route::apiResource('volunteer-opportunities', VolunteerOpportunityController::class);   
        Route::apiResource('donation-items-catalog', DonationItemsCatalogController::class)
             ->parameters(['donation-items-catalog' => 'item']);

        // -----------------------------------------------------------------
        // RUTAS ANIDADAS PARA GESTIÓN DE ANIMALES (Fotos e Historial Médico)
        // -----------------------------------------------------------------
        Route::post('animals/{animal}/photos', [AnimalPhotoController::class, 'store'])->name('animals.photos.store');
        Route::post('photos/{photo}', [AnimalPhotoController::class, 'update'])->name('photos.update');
        Route::delete('photos/{photo}', [AnimalPhotoController::class, 'destroy'])->name('photos.destroy');
        
        Route::post('animals/{animal}/medical-records', [MedicalRecordController::class, 'store'])->name('animals.records.store');
        Route::put('medical-records/{record}', [MedicalRecordController::class, 'update'])->name('records.update');
        Route::delete('medical-records/{record}', [MedicalRecordController::class, 'destroy'])->name('records.destroy');
        
        // -----------------------------------------------------------------
        // REVISIÓN DE SOLICITUDES
        // -----------------------------------------------------------------
        Route::get('/applications-summary', [AdminApplicationController::class, 'getApplicationSummary'])->name('applications.summary');

        // Solicitudes de Adopción
        Route::get('adoption-applications', [AdoptionApplicationController::class, 'index']);
        Route::get('adoption-applications/{application}', [AdoptionApplicationController::class, 'show']);
        Route::put('adoption-applications/{application}/status', [AdoptionApplicationController::class, 'updateStatus']);

        // Solicitudes de Voluntariado
        Route::get('volunteer-applications', [VolunteerApplicationController::class, 'index']);
        Route::get('volunteer-applications/{application}', [VolunteerApplicationController::class, 'show']);
        Route::put('volunteer-applications/{application}/status', [VolunteerApplicationController::class, 'updateStatus']);
        
        // Solicitudes de Donación
        Route::get('donation-applications', [AdminDonationApplicationController::class, 'index']);
        Route::get('donation-applications/{application}', [AdminDonationApplicationController::class, 'show']);
        Route::put('donation-applications/{application}/status', [AdminDonationApplicationController::class, 'updateStatus']);
        
        // -----------------------------------------------------------------
        // HISTORIAL DE DONACIONES (Aprobadas)
        // -----------------------------------------------------------------
        Route::apiResource('donations', AdminDonationController::class)->only(['index', 'show']);

        //Manejar fotos de animales
        Route::post('animals/{animal}/photos', [AnimalPhotoController::class, 'store'])->name('api.admin.animals.photos.store');
        Route::delete('photos/{photo}', [AnimalPhotoController::class, 'destroy'])->name('api.admin.photos.destroy');
        //Manejar el historial médico de los animales
        Route::post('animals/{animal}/medical-records', [MedicalRecordController::class, 'store'])->name('api.admin.animals.records.store');
        Route::delete('medical-records/{record}', [MedicalRecordController::class, 'destroy'])->name('api.admin.records.destroy');
});