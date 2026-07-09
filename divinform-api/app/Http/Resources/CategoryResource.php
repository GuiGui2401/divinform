<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'slug'           => $this->slug,
            'icon'           => $this->icon,
            'image'          => $this->image,
            'description'    => $this->description,
            'color'          => $this->color,
            'active'         => $this->active,
            'sort_order'     => $this->sort_order,
            'products_count' => $this->whenCounted('products', $this->products_count ?? 0),
            'created_at'     => $this->created_at?->toDateTimeString(),
        ];
    }
}
