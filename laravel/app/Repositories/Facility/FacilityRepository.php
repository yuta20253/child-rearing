<?php

namespace App\Repositories\Facility;

use App\Models\Facility;
use App\Repositories\Facility\FacilityRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class FacilityRepository implements FacilityRepositoryInterface
{
    private Facility $facility;

    public function __construct(Facility $facility)
    {
        $this->facility = $facility;
    }

    public function getAll($municipalityId, $name): Collection
    {
        return $this->facility
                    ->with(['address.municipality.prefecture'])
                    ->whereHas('address', function ($q) use ($municipalityId) {
                        $q->where('municipality_id', $municipalityId);
                    })
                    ->when($name, fn ($q) => $q->where('name', 'LIKE', "%{$name}%"))
                    ->get();
    }

    public function find(int $id): Facility
    {
        return $this->facility
                    ->with(['hours', 'phone', 'reviews.user', 'address.municipality.prefecture'])
                    ->findOrFail($id);
    }
}
