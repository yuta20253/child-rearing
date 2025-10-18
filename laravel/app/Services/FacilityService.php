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
            $municipalityId = 1598;
        }
        return $this->facilityRepository->getAll($municipalityId, $name);
    }

    public function find(int $id): Facility
    {
        return $this->facilityRepository->find($id);
    }
}
