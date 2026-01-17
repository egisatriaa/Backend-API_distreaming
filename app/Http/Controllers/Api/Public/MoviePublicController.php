<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Public\MoviePublicResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class MoviePublicController extends Controller
{
    public function index(Request $request): JsonResponse
{
    $query = Movie::with(['categories' => fn($q) => $q->whereNull('categories.deleted_at')])
            ->withAvg('ratings', 'score')
            ->whereNull('movies.deleted_at');

    // filter by search
    $query->filterBySearch($request->search);

    // filter by category, jika category_id ada
    if ($request->category_id) {
        $categoryId = intval($request->category_id);
        $query->whereHas('categories', function($q) use ($categoryId) {
            $q->where('categories.id', $categoryId) 
            ->whereNull('categories.deleted_at'); 
        });
    }

    $perPage = min($request->integer('per_page', 10), 100);
    $movies = $query->orderByDesc('release_year')->paginate($perPage);

    return ApiResponse::success(
        MoviePublicResource::collection($movies->items()),
        'Movies fetched successfully.',
        200,
        [
            'current_page' => $movies->currentPage(),
            'last_page' => $movies->lastPage(),
            'per_page' => $movies->perPage(),
            'total' => $movies->total(),
        ]
    );
}


    public function show(Movie $publicMovie): JsonResponse
    {
        return ApiResponse::success(
            new MoviePublicResource($publicMovie),
            'Movie detail fetched successfully.'
        );
    }
}
