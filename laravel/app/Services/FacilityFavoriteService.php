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

        return $userFacilityFavorities->map(function ($facility) {
            $address = $facility?->address;
            $municipality = $address?->municipality;
            $prefecture = $municipality?->prefecture;

            $fullAddress = ($prefecture?->name ?? '') . ($municipality?->name ?? '') . ($address?->town ?? '');
            return [
                'id' => $facility->id,
                'name' => $facility->name,
                'address' => $fullAddress,
                'rating' => round($facility->reviews()->avg('rating') ?? 0, 1),
            ];
        })->toArray();
    }

    public function registerFacilityFavorite(int $facilityId)
    {
        $userId = Auth::id();
        $this->facilityFavoriteRepository->registerUserFacilityFavorite($facilityId, $userId);
    }

    public function cancelFacilityFavorite(int $facilityId)
    {
        $userId = Auth::id();
        $this->facilityFavoriteRepository->cancelUserFacilityFavorite($facilityId, $userId);
    }
}
