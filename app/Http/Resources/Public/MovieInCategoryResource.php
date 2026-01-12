<?php

namespace App\Http\Resources\Public;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieInCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $avgRating = $this->ratings_avg_score ?? 0;

        $ratingClass = match (true) {
            $avgRating >= 8.5 => 'Top Rated',
            $avgRating >= 7.0 => 'Popular',
            default => 'Regular',
        };

        return [
            'id' => $this->id,
            'title' => $this->title,
            'poster_url' => trim($this->poster_url),
            'release_year' => $this->release_year,
            'rating' => [
                'avg' => $avgRating > 0 ? round($avgRating, 1) : null,
                'class' => $ratingClass,
            ],
        ];
    }
}
