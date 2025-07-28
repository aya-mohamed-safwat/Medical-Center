<?php

namespace App\Http\Resources\Dashboard\Offers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                       => $this->id,
            'title'                    => $this->title,
            'description'              => $this->description,
            'discount_type'            => $this->discount_type,
            'discount_value'           => $this->discount_value,
            'original_price'           => $this->original_price,
            'after_discount'           => $this->getDiscountedPrice( $this->original_price ?? 0),
            'start_time'               => $this->start_time,
            'end_time'                 => $this->end_time,
            'image'                    => $this->image,
            'number_of_reservation'    => $this->number_of_reservation,
            'total_reservation'        => $this->total_reservation,
            'max_reservation_per_user' => $this->max_reservation_per_user ,
            'sessions_number'          => $this->sessions_number,
            'payment_timeout'          => $this->payment_timeout ,
            'service'                  => $this->whenLoaded('service' ,function () {
                return[
                  'name'   => $this->service->name,
                ];
            }),
            'speciality'               => $this->whenLoaded('speciality' ,function () {
                return[
                    'main'  => $this->specality?->name ?? null,
                    'sub'   => $this->speciality?->sub_speciality?->name ?? null,
                ];
            })
        ];
    }
}
