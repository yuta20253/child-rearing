<?php

namespace App\Providers;

use App\Repositories\Facility\FacilityRepository;
use App\Repositories\Facility\FacilityRepositoryInterface;
use App\Repositories\FacilityFavorite\FacilityFavoriteRepository;
use App\Repositories\FacilityFavorite\FacilityFavoriteRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Review\ReviewRepository;
use App\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(FacilityRepositoryInterface::class, FacilityRepository::class);
        $this->app->bind(FacilityFavoriteRepositoryInterface::class, FacilityFavoriteRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
