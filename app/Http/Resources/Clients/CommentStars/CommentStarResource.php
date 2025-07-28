<?php

namespace App\Http\Resources\Clients\CommentStars;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentStarResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'comment' => $this->comment,
            'stars'   => $this->stars,
            'client' => $this->whenLoaded('client', function () {
                return [
                    'id'   => $this->client->id,
                    'name' => $this->client->name,
                ];
            }),
            'doctor' => $this->whenLoaded('doctor', function () {
                return [
                    'id'   => $this->doctor->id,
                    'name' => $this->doctor->name,
                ];
            }),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
