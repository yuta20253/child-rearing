<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'facility_id' => $this->facility_id,
            'title' => $this->title,
            'start_datetime' => $this->start_datetime,
            'end_datetime' => $this->end_datetime,
            'capacity' => $this->capacity,
        ];
    }
}
