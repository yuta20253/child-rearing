<?php

namespace App\Services;

use App\Repositories\FacilityFavorite\FacilityFavoriteRepository;
use Illuminate\Support\Facades\Auth;

class FacilityFavoriteService
{
    private FacilityFavoriteRepository $facilityFavoriteRepository;

    public function __construct(FacilityFavoriteRepository $facilityFavoriteRepository)
    {
        $this->facilityFavoriteRepository = $facilityFavoriteRepository;
    }

    public function getFacilityFavorities()
    {
        $userId = Auth::id();
        $userFacilityFavorities = $this->facilityFavoriteRepository->getUserFacilityFavorities($userId);

        return $userFacilityFavorities->map(function ($facilityFavorite) {
            return [
                'id' => $facilityFavorite->id,
                'name' => $facilityFavorite->name,
            ];
        })->toArray();
    }

}
