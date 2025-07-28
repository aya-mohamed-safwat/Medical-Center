<?php

namespace App\Http\Resources\Dashboard\Discounts;

use App\Http\Resources\Dashboard\Services\ServiceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountDetailsResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            'id'             => $this->id,
            'description'    => $this->description,
            'start_time'     => $this->start_time,
            'end_time'       => $this->end_time,
            'is_active'      => (bool)$this->is_active,
            'service'        => $this->whenLoaded('service', function () {
                return[
                    'id'   => $this->service->id,
                    'name' => $this->service->name,
                 ];
            }),
            'discount_type'  => $this->discount_type,
            'discount_value' => $this->discount_value,
            'after_discount' => $this->getDiscountedPrice( $this->service->doctor->first()?->price ?? 0),
            'image'          => $this->image,
        ];
    }
}
