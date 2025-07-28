<?php

namespace App\Http\Resources\Dashboard\Services;

use App\Http\Resources\Dashboard\Discounts\DiscountDetailsResource;
use App\Http\Resources\Dashboard\Specialties\SpecialtyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id'             => $this->id,
            'discount'       => $this->whenLoaded('discount' ,function () {
                return[
                    'id'             => $this->discount->id,
                    'description'    => $this->discount->description,
                    'start_time'     => $this->discount->start_time,
                    'end_time'       => $this->discount->end_time,
                    'discount_type'  => $this->discount->discount_type,
                    'discount_value' => $this->discount->discount_value,
                    'after_discount' => $this->discount->getDiscountedPrice( $this->doctor->first()?->price ?? 0),
                ];
            }) ,
            'name'           => $this->name,
            'description'    => $this->description,
            'image'          => $this->image,
            'is_active'      => (bool)$this->is_active,
            'original_price' => optional($this->doctor->first())->price,

        ];
    }
}
