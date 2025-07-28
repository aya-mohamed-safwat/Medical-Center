<?php

namespace App\Http\Resources\Clients\ClientOffers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientOfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'offer'    => $this->whenLoaded('offer', function () {
                return [
                    'title'           => $this->offer->title,
                    'description'     => $this->offer->description,
                    'image'           => $this->offer->image,
                    'original_price'  => $this->offer->original_price,
                    'after_discount'  => $this->offer->getDiscountedPrice( $this->offer->original_price ?? 0),
                    ];
            }),
            'sessions' => [
                $this->offer->sessions_number,
                $this->offer->sessions_number - $this->remaining_sessions,
            ],
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
