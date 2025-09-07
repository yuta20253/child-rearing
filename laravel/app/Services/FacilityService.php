<?php

namespace App\Services;

use App\Repositories\Facility\FacilityRepositoryInterface;

class FacilityService
{
    private FacilityRepositoryInterface $facilityRepository;

    public function __construct(FacilityRepositoryInterface $facilityRepository)
    {
        $this->facilityRepository = $facilityRepository;
    }

    public function getAllFacilities()
    {
        return $this->facilityRepository->getAllFacilities();
    }
}
