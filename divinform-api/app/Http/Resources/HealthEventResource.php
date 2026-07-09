<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HealthEventResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'farm_batch_id'    => $this->farm_batch_id,
            'farm_animal_id'   => $this->farm_animal_id,
            'type'             => $this->type,
            'label'            => $this->label,
            'medicine'         => $this->medicine,
            'dose'             => $this->dose,
            'quantity'         => $this->quantity,
            'occurred_on'      => $this->occurred_on?->toDateString(),
            'next_due_on'      => $this->next_due_on?->toDateString(),
            'withdrawal_until' => $this->withdrawal_until?->toDateString(),
            'cost'             => $this->cost,
            'note'             => $this->note,
            'batch'            => $this->whenLoaded('batch', fn () => $this->batch ? [
                'id'   => $this->batch->id,
                'code' => $this->batch->code,
            ] : null),
            'animal' => $this->whenLoaded('animal', fn () => $this->animal ? [
                'id'  => $this->animal->id,
                'tag' => $this->animal->tag,
            ] : null),
            'user'       => $this->whenLoaded('user', fn () => $this->user?->name),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
