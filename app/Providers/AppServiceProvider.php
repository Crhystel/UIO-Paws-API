<?php

namespace App\Providers;

use App\Repositories\Contracts\AnimalRepositoryInterface;
use App\Repositories\Contracts\BreedRepositoryInterface;
use App\Repositories\Contracts\SpeciesRepositoryInterface;
use App\Repositories\Contracts\MedicalRecordRepositoryInterface;
use App\Repositories\Contracts\ShelterRepositoryInterface;
use App\Repositories\Contracts\VolunteerOpportunityRepositoryInterface;
use App\Repositories\Contracts\DonationCatalogRepositoryInterface;
use App\Repositories\Contracts\DonationRepositoryInterface;
use Illuminate\Support\ServiceProvider; 
use Illuminate\Support\Facades\URL; 

// Implementaciones
use App\Repositories\Eloquent\AnimalRepository;
use App\Repositories\Eloquent\BreedRepository;
use App\Repositories\Eloquent\SpeciesRepository;
use App\Repositories\Eloquent\MedicalRecordRepository;
use App\Repositories\Eloquent\ShelterRepository;
use App\Repositories\Eloquent\DonationCatalogRepository;
use App\Repositories\Eloquent\DonationRepository;
use App\Repositories\Eloquent\VolunteerOpportunityRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       
        $this->app->bind(AnimalRepositoryInterface::class, AnimalRepository::class);
        $this->app->bind(BreedRepositoryInterface::class, BreedRepository::class);
        $this->app->bind(SpeciesRepositoryInterface::class, SpeciesRepository::class);
        $this->app->bind(MedicalRecordRepositoryInterface::class, MedicalRecordRepository::class);
        $this->app->bind(ShelterRepositoryInterface::class, ShelterRepository::class);
        $this->app->bind(DonationCatalogRepositoryInterface::class, DonationCatalogRepository::class);
        $this->app->bind(DonationRepositoryInterface::class, DonationRepository::class);
        $this->app->bind(VolunteerOpportunityRepositoryInterface::class, VolunteerOpportunityRepository::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
