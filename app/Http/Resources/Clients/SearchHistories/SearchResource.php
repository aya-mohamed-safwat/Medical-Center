<?php

namespace App\Http\Resources\Clients\SearchHistories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'search'     => $this->search,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
