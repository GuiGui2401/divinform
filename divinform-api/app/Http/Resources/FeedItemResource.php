<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'unit'            => $this->unit,
            'current_qty'     => (float) $this->current_qty,
            'alert_threshold' => (float) $this->alert_threshold,
            'unit_cost'       => $this->unit_cost,
            'active'          => $this->active,
            'is_low'          => $this->is_low,
            'created_at'      => $this->created_at?->toDateTimeString(),
        ];
    }
}
