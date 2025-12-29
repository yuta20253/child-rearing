<?php

namespace App\Repositories\FacilityFavorite;

use App\Models\FacilityFavorite;
use Illuminate\Database\Eloquent\Collection;

interface FacilityFavoriteRepositoryInterface
{
    public function getUserFacilityFavorities(int $id): Collection;
    public function registerUserFacilityFavorite(int $facilityId, int $userId): bool;
}
