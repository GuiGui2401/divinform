<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FarmAnimalResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'farm_unit_id'  => $this->farm_unit_id,
            'farm_batch_id' => $this->farm_batch_id,
            'tag'           => $this->tag,
            'name'          => $this->name,
            'species'       => $this->species,
            'breed'         => $this->breed,
            'sex'           => $this->sex,
            'born_on'       => $this->born_on?->toDateString(),
            'entered_on'    => $this->entered_on?->toDateString(),
            'status'        => $this->status,
            'notes'         => $this->notes,
            'unit'          => $this->whenLoaded('unit', fn () => [
                'id'   => $this->unit->id,
                'name' => $this->unit->name,
            ]),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
