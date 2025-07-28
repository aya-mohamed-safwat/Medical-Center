<?php

namespace App\Http\Resources\Dashboard\DoctorProfiles;

use App\Http\Resources\Dashboard\Specialties\SpecialtyResource;
use App\Http\Resources\Dashboard\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user'             => new UserResource($this->whenLoaded('user')),
            'speciality'       => SpecialtyResource::collection($this->whenLoaded('specialities')),
            'gender'           => $this->gender,
            'bio'              => $this->bio,
            'experience_years' => $this->experience_years,
            'price'            => $this->price,
            'min'              => $this->min,
            'max'              => $this->max,
            'image'            => $this->image,
        ];
    }
}
