<?php

namespace App\Repositories\FacilityFavorite;

use Illuminate\Database\Eloquent\Collection;

interface FacilityFavoriteRepositoryInterface
{
    public function getUserFacilityFavorities(int $id): Collection;
    public function registerUserFacilityFavorite(int $facilityId, int $userId): bool;
    public function cancelUserFacilityFavorite(int $facilityId, int $userId): bool;
}
