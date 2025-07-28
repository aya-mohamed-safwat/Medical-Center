<?php

namespace App\Http\Resources\Dashboard\Discounts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return[
            'id'             => $this->id,
            'description'    => $this->description,
            'discount_type'  => $this->discount_type,
            'discount_value' => $this->discount_value,
            'image'          => $this->image,

        ];
    }
}
