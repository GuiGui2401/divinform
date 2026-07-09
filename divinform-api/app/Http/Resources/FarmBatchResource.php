<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FarmBatchResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'farm_unit_id'    => $this->farm_unit_id,
            'product_id'      => $this->product_id,
            'code'            => $this->code,
            'species'         => $this->species,
            'breed'           => $this->breed,
            'started_on'      => $this->started_on?->toDateString(),
            'expected_end_on' => $this->expected_end_on?->toDateString(),
            'initial_qty'     => $this->initial_qty,
            'current_qty'     => $this->current_qty,
            'avg_weight_g'    => $this->avg_weight_g,
            'mortality_count' => $this->mortality_count,
            'mortality_rate'  => $this->mortality_rate,
            'feed_conversion' => $this->feedConversionRatio(),
            'status'          => $this->status,
            'notes'           => $this->notes,
            'unit'            => $this->whenLoaded('unit', fn () => [
                'id'   => $this->unit->id,
                'name' => $this->unit->name,
                'type' => $this->unit->type,
            ]),
            'product' => $this->whenLoaded('product', fn () => $this->product ? [
                'id'   => $this->product->id,
                'name' => $this->product->name,
            ] : null),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
