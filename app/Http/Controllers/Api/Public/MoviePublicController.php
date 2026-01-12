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
        $query = Movie::with('categories')
            ->withAvg('ratings', 'score')
            ->whereNull('deleted_at');;

        // Search by title 
        $query->filterBySearch($request->search)
            ->filterByCategory($request->category_id);

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
