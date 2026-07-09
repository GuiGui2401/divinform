<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'category_id'   => $this->category_id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'short_desc'    => $this->short_desc,
            'description'   => $this->description,
            'images'        => $this->images ?? [],
            'badge'         => $this->badge,
            'badge_color'   => $this->badge_color,
            'featured'      => $this->featured,
            'active'        => $this->active,
            'views_count'   => $this->views_count,
            'contact_count' => $this->contact_count,
            'sort_order'    => $this->sort_order,
            'specs'         => $this->whenLoaded('specs', fn () =>
                $this->specs->map(fn ($s) => [
                    'label' => $s->label,
                    'value' => $s->value,
                ])
            ),
            'category' => $this->whenLoaded('category', fn () => [
                'id'   => $this->category->id,
                'name' => $this->category->name,
                'icon' => $this->category->icon,
                'slug' => $this->category->slug,
            ]),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
