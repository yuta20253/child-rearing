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
                    ->whereHas("address", function ($query) use ($municipalityId) {
                        $query->where("municipality_id", $municipalityId);
                    })
                    ->when($name, function (Builder $query, string $name) {
                        $query->where('name', 'LIKE', "%{$name}%");
                    })
                    ->get();
    }

    public function find(int $id): Facility
    {
        return $this->facility->findOrFail($id);
    }
}
