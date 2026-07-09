<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FarmUnitResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'type'       => $this->type,
            'location'   => $this->location,
            'capacity'   => $this->capacity,
            'active'     => $this->active,
            'notes'      => $this->notes,
            'sort_order' => $this->sort_order,
            'headcount'  => $this->headcount,
            'batches_count' => $this->whenCounted('batches'),
            'animals_count' => $this->whenCounted('animals'),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
