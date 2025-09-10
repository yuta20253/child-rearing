<?php

namespace App\Services;

use App\Models\Facility;
use App\Repositories\Facility\FacilityRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class FacilityService
{
    private FacilityRepositoryInterface $facilityRepository;

    public function __construct(FacilityRepositoryInterface $facilityRepository)
    {
        $this->facilityRepository = $facilityRepository;
    }

    public function getAllFacilities()
    {
        $user = Auth::user();
        $municipalityId = $user->address->municipality_id;
        return $this->facilityRepository->getAllFacilities($municipalityId);
    }

    public function find(int $id): Facility
    {
        return $this->facilityRepository->find($id);
    }
}
