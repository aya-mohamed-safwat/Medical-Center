<?php

namespace App\Http\Resources\Clients\ClientProfiles;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientAuthResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'email'   => $this->email,
            'number'  => $this->number,
            'password'=> $this->password,
        ];
    }
}
