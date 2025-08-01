<?php

namespace App\Http\Resources\Dashboard\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
            'number'   => $this->number,
            'active'   => (bool)$this->is_active
        ];
    }
}
