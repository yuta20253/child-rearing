<?php

namespace App\Repositories\FacilityFavorite;

use Illuminate\Database\Eloquent\Collection;

interface FacilityFavoriteRepositoryInterface
{
    public function getUserFacilityFavorites(int $id): Collection;
    public function register(string $facilityId, int $userId): void;
    public function cancel(string $facilityId, int $userId): void;
}
