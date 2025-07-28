<?php

namespace App\Http\Resources\Dashboard\Sliders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'description'    => $this->description,
            'link'           => $this->getRedirectUrl(),
            'discount_id'    => $this->discount->id,
            'discount_type'  => $this->discount->discount_type ?? null,
            'discount_value' => $this->discount->discount_value ?? null,
            'image'          => $this->image,

        ];
    }
}
