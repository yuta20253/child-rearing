<?php

namespace App\Repositories\FacilityFavorite;

use App\Models\User;
use App\Repositories\FacilityFavorite\FacilityFavoriteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FacilityFavoriteRepository implements FacilityFavoriteRepositoryInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserFacilityFavorities(int $userId): Collection
    {
        return $this->user->findOrFail($userId)->facilityFavorities()->get();
    }
}
