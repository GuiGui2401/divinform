<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormationSessionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'formation_id'      => $this->formation_id,
            'starts_on'         => $this->starts_on?->toDateString(),
            'ends_on'           => $this->ends_on?->toDateString(),
            'location'          => $this->location,
            'seats'             => $this->seats,
            'seats_taken'       => $this->seats_taken,
            'seats_left'        => $this->seats_left,
            'is_full'           => $this->is_full,
            'registration_open' => $this->registration_open,
        ];
    }
}
