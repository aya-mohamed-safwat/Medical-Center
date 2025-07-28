<?php

namespace App\Http\Resources\Clients\Doctors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorProResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->user->id,
            'name'     => $this->user->name,
            'image'    => $this->image,
            'speciality' => $this->doctorProfile?->specialities?->firstwhere('parent_id','!=',null)?->name
                ?? $this->specialities?->firstwhere('parent_id',null)?->name,

            'price' => $this->price,
            'duration' => $this->min .'-'.$this->max,

            'average_rating'   => round($this->average_rating ?? 0, 1),
            'reviews_count'    => $this->reviews_count ?? 0,
        ];
    }
}
