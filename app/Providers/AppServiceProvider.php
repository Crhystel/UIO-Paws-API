<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Repositories\Contracts\AnimalRepositoryInterface;
use App\Repositories\Eloquent\AnimalRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Dependency Inversion Principle (DIP)
        // Registramos que cuando se pida la interfaz, Laravel entregue la implementación Eloquent
        $this->app->bind(AnimalRepositoryInterface::class, AnimalRepository::class);
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
