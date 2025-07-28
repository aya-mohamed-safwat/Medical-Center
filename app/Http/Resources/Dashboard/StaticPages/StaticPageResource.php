<?php

namespace App\Http\Resources\Dashboard\StaticPages;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaticPageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'slug'       => $this->slug,
            'content'    => $this->content,
            'image'      => $this->image,
            'is_active'  => (bool) $this->is_active,
        ];
    }
}
