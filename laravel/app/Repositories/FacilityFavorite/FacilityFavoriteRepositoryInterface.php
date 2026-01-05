<?php

namespace App\Repositories\FacilityFavorite;

use Illuminate\Database\Eloquent\Collection;

interface FacilityFavoriteRepositoryInterface
{
    public function getUserFacilityFavorites(int $id): Collection;
    public function register(int $facilityId, int $userId): void;
    public function cancel(int $facilityId, int $userId): void;
}
