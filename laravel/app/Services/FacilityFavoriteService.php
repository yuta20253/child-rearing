<?php

namespace App\Services;

use App\Repositories\FacilityFavorite\FacilityFavoriteRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class FacilityFavoriteService
{
    private FacilityFavoriteRepositoryInterface $facilityFavoriteRepository;

    public function __construct(FacilityFavoriteRepositoryInterface $facilityFavoriteRepository)
    {
        $this->facilityFavoriteRepository = $facilityFavoriteRepository;
    }

    public function getFacilityFavorities()
    {
        $userId = Auth::id();
        $userFacilityFavorities = $this->facilityFavoriteRepository->getUserFacilityFavorites($userId);

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

    public function registerFacilityFavorite(int $facilityId): void
    {
        $userId = Auth::id();
        $this->facilityFavoriteRepository->register($facilityId, $userId);
    }

    public function cancel(int $facilityId): void
    {
        $userId = Auth::id();
        $this->facilityFavoriteRepository->cancel($facilityId, $userId);
    }
}
