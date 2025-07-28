<?php

namespace App\Http\Resources\Dashboard\Sliders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'description'    => $this->description,
            'link'           => $this->getRedirectUrl(),
            'type'           => $this->type,
            'order'          => $this->order,
            'start_at'       => $this->start_at,
            'end_at'         => $this->end_at,
            'image'          => $this->image,
            'discount_id'    => $this->discount->id ?? null,
            'discount_type'  => $this->discount->discount_type ?? null,
            'discount_value' => $this->discount->discount_value ?? null,
            'is_active'      => (bool) $this->is_active,
        ];
    }
}
