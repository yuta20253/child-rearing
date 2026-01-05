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

    public function getUserFacilityFavorites(int $userId): Collection
    {
        return $this->user->findOrFail($userId)->facilityFavorites()->get();
    }

    public function register(int $facilityId, int $userId): void
    {
        $this->user->findOrFail($userId)->facilityFavorites()->syncWithoutDetaching($facilityId);
    }

    public function cancel(int $facilityId, int $userId): void
    {
        $this->user->findOrFail($userId)->facilityFavorites()->detach($facilityId);
    }
}
