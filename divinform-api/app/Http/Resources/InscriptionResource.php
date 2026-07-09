<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InscriptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'formation_id'    => $this->formation_id,
            'formation_title' => $this->formation_title,
            'session_id'      => $this->formation_session_id,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'email'           => $this->email,
            'message'         => $this->message,
            'status'          => $this->status,
            'admin_note'      => $this->admin_note,
            'session'         => $this->whenLoaded('session', fn () => [
                'id'        => $this->session->id,
                'starts_on' => $this->session->starts_on?->toDateString(),
                'location'  => $this->session->location,
            ]),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
