<?php

namespace App\Http\Resources\Public;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryPublicResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->category_name,
            'description' => $this->description,

            'movies' => MovieInCategoryResource::collection(
                $this->whenLoaded('movies')
            ),
        ];
    }
}
