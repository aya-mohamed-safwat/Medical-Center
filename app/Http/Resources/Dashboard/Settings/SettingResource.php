<?php

namespace App\Http\Resources\Dashboard\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return[
            'id'        =>$this->id,
            'key'       => $this->key,
            'value'     => $this->value,
            'is_active' => (bool) $this->is_active
        ] ;
    }
}
