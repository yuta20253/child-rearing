<?php

namespace App\Services;

use App\Repositories\Facility\FacilityRepositoryInterface;
use App\Repositories\FacilityFavorite\FacilityFavoriteRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class FacilityFavoriteService
{
    private FacilityFavoriteRepositoryInterface $facilityFavoriteRepository;
    private FacilityRepositoryInterface $facilityRepository;

    public function __construct(FacilityFavoriteRepositoryInterface $facilityFavoriteRepository, FacilityRepositoryInterface $facilityRepository)
    {
        $this->facilityFavoriteRepository = $facilityFavoriteRepository;
        $this->facilityRepository = $facilityRepository;
    }

    public function getFacilityFavorites()
    {
        $userId = Auth::id();
        $userFacilityFavorites = $this->facilityFavoriteRepository->getUserFacilityFavorites($userId);

        return $userFacilityFavorites->map(function ($facility) {
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

    public function register(string $facilityId): void
    {
        $userId = Auth::id();
        $this->facilityFavoriteRepository->register($facilityId, $userId);
    }

    public function cancel(string $facilityId): void
    {
        $userId = Auth::id();
        $this->facilityFavoriteRepository->cancel($facilityId, $userId);
    }

    public function findWithFavorite(string $id): bool
    {
        $user = Auth::user();
        $isFavorite = false;
        $facility = $this->facilityRepository->find($id);

        /** @var User|null $user */
        if ($user) {
            $isFavorite = $user->facilityFavorites()->where('facility_id', $facility->id)->exists();
        }

        return $isFavorite;
    }
}
