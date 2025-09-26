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

    public function getAll()
    {
        $user = Auth::user();
        $municipalityId = $user->address->municipality_id;
        return $this->facilityRepository->getAll($municipalityId);
    }
}
