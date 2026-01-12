<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WatchHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'watched_at' => $this->watched_at,
            'is_completed' => $this->is_completed,

            'movie' => [
                'id' => $this->movie->id,
                'title' => $this->movie->title,
                'poster_url' => trim($this->movie->poster_url),
            ],
        ];
    }
}
