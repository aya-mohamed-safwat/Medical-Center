<?php

namespace App\Http\Resources\Clients\Images;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'url'            => asset('storage/' . $this->file_path),
        ];
    }
}
