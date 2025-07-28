<?php

namespace App\Http\Resources\Dashboard\Offers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                       => $this->id,
            'title'                    => $this->title,
            'discount_type'            => $this->discount_type,
            'discount_value'           => $this->discount_value,
            'original_price'           => $this->original_price,
            'after_discount'           => $this->getDiscountedPrice( $this->original_price ?? 0),
            'image'                    => $this->image,
            'sessions_number'          => $this->sessions_number,
        ];
    }
}
