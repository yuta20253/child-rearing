<?php

namespace App\Repositories\Facility;

use App\Models\Facility;
use App\Repositories\Facility\FacilityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class FacilityRepository implements FacilityRepositoryInterface
{
    private Facility $facility;

    public function __construct(Facility $facility)
    {
        $this->facility = $facility;
    }

    public function getAllFacilities(): Collection
    {
        $user = Auth::user();

        $municipalityId = $user->address->municipality_id;
        return $this->facility
                    ->whereHas("address", function ($query) use ($municipalityId) {
                        $query->where("municipality_id", $municipalityId);
                    })
                    ->get();
    }
}
