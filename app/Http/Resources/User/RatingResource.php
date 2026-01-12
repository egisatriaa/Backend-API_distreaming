<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'score' => $this->score,
            'review' => $this->review_text,
            'created_at' => $this->created_at,

            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
            ],
        ];
    }
}
