<?php

namespace App\Http\Resources\Dashboard\Specialties;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MainSpecialtyResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'specialty' => $this->name,
        ];
    }
}
