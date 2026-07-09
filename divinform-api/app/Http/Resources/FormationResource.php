<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'slug'          => $this->slug,
            'summary'       => $this->summary,
            'description'   => $this->description,
            'level'         => $this->level,
            'duration'      => $this->duration,
            'prerequisites' => $this->prerequisites,
            'objectives'    => $this->objectives ?? [],
            'program'       => $this->program ?? [],
            'certification' => $this->certification,
            'price'         => $this->price,
            'currency'      => $this->currency,
            'images'        => $this->images ?? [],
            'badge'         => $this->badge,
            'badge_color'   => $this->badge_color,
            'featured'      => $this->featured,
            'active'        => $this->active,
            'views_count'   => $this->views_count,
            'contact_count' => $this->contact_count,
            'sort_order'    => $this->sort_order,
            'sessions'      => FormationSessionResource::collection(
                $this->whenLoaded('sessions')
            ),
            'upcoming_sessions' => FormationSessionResource::collection(
                $this->whenLoaded('upcomingSessions')
            ),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
