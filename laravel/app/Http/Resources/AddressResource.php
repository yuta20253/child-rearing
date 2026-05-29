<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'town' => $this->town,
            'municipality' => [
                'id' => $this->municipality?->id,
                'name' => $this->municipality?->name,
                'prefecture' => [
                    'id' => $this->municipality?->prefecture?->id,
                    'name' => $this->municipality?->prefecture?->name,
                ],
            ],
        ];
    }
}
