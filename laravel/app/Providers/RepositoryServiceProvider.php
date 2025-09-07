<?php

namespace App\Providers;

use App\Repositories\Facility\FacilityRepository;
use App\Repositories\Facility\FacilityRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(FacilityRepositoryInterface::class, FacilityRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
