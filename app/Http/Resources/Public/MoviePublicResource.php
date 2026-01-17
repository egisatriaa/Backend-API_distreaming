<?php

namespace App\Http\Resources\Public;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MoviePublicResource extends JsonResource
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
            'description' => $this->description,
            'duration_minutes' => $this->duration_minutes,
            'release_year' => $this->release_year,
            'poster_url' => trim($this->poster_url),

            'title_img' => $this->title_img,
            'bg_img' => $this->bg_img,
            'preview_img' => $this->preview_img,
            'trailer_url' => $this->trailer_url,
            'age_limit' => $this->age_limit,
            'release_date' => $this->release_date,
            'type' => $this->type,
            'is_active' => $this->is_active,

            'rating' => [
                'avg' => $avgRating > 0 ? round($avgRating, 1) : null,
                'class' => $ratingClass,
            ],

            'categories' => $this->categories->map(fn($category) => [
                'id' => $category->id,
                'name' => $category->category_name,
            ]),
        ];
    }
}
