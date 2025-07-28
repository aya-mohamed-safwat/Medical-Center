<?php

namespace App\Http\Resources\Clients\Doctors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'image'    => $this->doctorProfile->image,
            'doctorProfile' => $this->whenLoaded('doctorProfile', function () {
                return[
                    'experience_years' => $this->doctorProfile?->experience_years,
                    'price'            => $this->doctorProfile?->price,
                    'duration' => $this->doctorProfile?->min .'-'.$this->doctorProfile?->max,

                ];
            }),

            'speciality' => $this->doctorProfile?->specialities?->firstwhere('parent_id','!=',null)?->name
                ?? $this->doctorProfile?->specialities?->firstwhere('parent_id',null)?->name,

            'average_rating'   => round($this->average_rating ?? 0, 1),
            'reviews_count'    => $this->reviews_count ?? 0,
        ];
    }
}
