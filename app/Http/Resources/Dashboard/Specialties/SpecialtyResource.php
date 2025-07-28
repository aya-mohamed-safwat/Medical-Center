<?php

namespace App\Http\Resources\Dashboard\Specialties;

use App\Http\Resources\Clients\Doctors\DoctorProResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialtyResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'specialty' => $this->name,
            'image'     => $this->image,

             'sub_specialities' => $this->whenLoaded('subSpecialty', function () {
                 return SpecialtyResource::collection($this->subSpecialty);
             }),

            'doctors'   => $this->whenLoaded('doctors', function () {
                return DoctorProResource::collection($this->doctors);
            }),
        ];
    }
}
