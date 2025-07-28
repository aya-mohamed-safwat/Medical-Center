<?php

namespace App\Http\Resources\Clients\ClientProfiles;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->user->id,
            'name'     => $this->user->name,
            'email'    => $this->user->email,
            'number'   => $this->user->number,
            'password' => $this->user->password,
//            'image'    => asset("storage/" . $this->attachment->file_path ?? null),
            'active'  => (bool)$this->user->is_active,
        ];
    }
}
