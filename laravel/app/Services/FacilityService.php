<?php

namespace App\Services;

use App\Models\Facility;
use App\Repositories\Facility\FacilityRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class FacilityService
{
    private FacilityRepositoryInterface $facilityRepository;

    public function __construct(FacilityRepositoryInterface $facilityRepository)
    {
        $this->facilityRepository = $facilityRepository;
    }

    public function getAll(?string $name = null)
    {
        $user = Auth::user();
        if ($user && $user->address) {
            $municipalityId = $user->address->municipality_id;
        } else {
            $municipalityId = 1566;
        }
        return $this->facilityRepository->getAll($municipalityId, $name);
    }

    public function find(string $id): Facility
    {
        return $this->facilityRepository->find($id);
    }

    public function findWithFavorite(string $id): array
    {
        $user = Auth::user();
        $is_favorite = false;
        $facility = $this->facilityRepository->find($id);

        /** @var User|null $user */
        if ($user) {
            $isFavorite = $user->facilityFavorites()->where('facility_id', $facility->id)->exists();
        }

        return [
            'facility' => $facility,
            'isFavorite' => $isFavorite,
        ];
    }
}
