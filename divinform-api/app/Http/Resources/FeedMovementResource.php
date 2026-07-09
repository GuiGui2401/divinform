<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedMovementResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'feed_item_id'  => $this->feed_item_id,
            'farm_batch_id' => $this->farm_batch_id,
            'type'          => $this->type,
            'quantity'      => (float) $this->quantity,
            'qty_after'     => (float) $this->qty_after,
            'unit_cost'     => $this->unit_cost,
            'occurred_on'   => $this->occurred_on?->toDateString(),
            'note'          => $this->note,
            'item'          => $this->whenLoaded('item', fn () => [
                'id'   => $this->item->id,
                'name' => $this->item->name,
                'unit' => $this->item->unit,
            ]),
            'batch' => $this->whenLoaded('batch', fn () => $this->batch ? [
                'id'   => $this->batch->id,
                'code' => $this->batch->code,
            ] : null),
            'user' => $this->whenLoaded('user', fn () => $this->user?->name),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
