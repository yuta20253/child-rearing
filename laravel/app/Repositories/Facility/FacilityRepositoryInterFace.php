<?php

namespace App\Repositories\Facility;

use App\Models\Facility;
use Illuminate\Database\Eloquent\Collection;

interface FacilityRepositoryInterface
{
    public function getAllFacilities(int $municipalityId): Collection;
}
