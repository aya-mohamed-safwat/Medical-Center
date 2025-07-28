<?php

namespace App\Http\Resources\Clients\Favorites;

use App\Http\Resources\Clients\Doctors\DoctorProResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id'        =>  $this->pivot->id,
            'doctor'    => new DoctorProResource($this->doctorProfile),
        ];
    }
}
