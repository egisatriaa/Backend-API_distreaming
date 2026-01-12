<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Public\CategoryPublicResource;
use App\Http\Resources\Public\MovieInCategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use App\Helpers\ApiResponse;

class CategoryPublicController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::whereNull('deleted_at')->get();

        return ApiResponse::success(
            CategoryPublicResource::collection($categories),
            'Categories fetched successfully.'
        );
    }

    public function show(Category $publicCategory): JsonResponse
    {
        $publicCategory->load([
            'movies' => fn($q) =>
            $q->whereNull('deleted_at')
                ->withAvg('ratings', 'score')
                ->orderByDesc('ratings_avg_score')
        ]);

        return ApiResponse::success(
            new CategoryPublicResource($publicCategory),
            'Category detail fetched.'
        );
    }
}
