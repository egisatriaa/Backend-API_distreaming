<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\Admin\MovieAdminResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class MovieController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->integer('per_page', 10), 100);

        $query = Movie::with('categories')
            ->withAvg('ratings', 'score')
            ->withTrashed()
            ->orderByDesc('created_at');

        $query->filterBySearch($request->search)
            ->filterByCategory($request->category_id);

        $movies = $query->paginate($perPage);

        return ApiResponse::success(
            MovieAdminResource::collection($movies->items()),
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

    public function store(StoreMovieRequest $request): JsonResponse
    {
        $data = $request->validated();

        $movie = Movie::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'release_year' => $data['release_year'],
            'duration_minutes' => $data['duration_minutes'],
            'poster_url' => $data['poster_url'] ?? null,
            'title_img' => $data['title_img'] ?? null,
            'bg_img' => $data['bg_img'] ?? null,
            'preview_img' => $data['preview_img'] ?? null,
            'trailer_url' => $data['trailer_url'] ?? null,
            'age_limit' => $data['age_limit'] ?? null,
            'release_date' => $data['release_date'] ?? null,
            'type' => $data['type'] ?? 'now_playing',
            'is_active' => $data['is_active'] ?? true,
        ]);

        if (!empty($data['category_ids'])) {
            $movie->categories()->attach($data['category_ids']);
        }

        $movie->load('categories', 'ratings');

        return ApiResponse::success(
            new MovieAdminResource($movie),
            'Movie created successfully.',
            201
        );
    }

    public function show(Movie $movie): JsonResponse
    {
        return ApiResponse::success(
            new MovieAdminResource($movie->load('categories', 'ratings')),
            'Movie detail fetched successfully.'
        );
    }

    public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
    {
        $data = $request->validated();

        $movie->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'release_year' => $data['release_year'],
            'duration_minutes' => $data['duration_minutes'],
            'poster_url' => $data['poster_url'] ?? null,
            'title_img' => $data['title_img'] ?? null,
            'bg_img' => $data['bg_img'] ?? null,
            'preview_img' => $data['preview_img'] ?? null,
            'trailer_url' => $data['trailer_url'] ?? null,
            'age_limit' => $data['age_limit'] ?? null,
            'release_date' => $data['release_date'] ?? null,
            'type' => $data['type'] ?? $movie->type,
            'is_active' => $data['is_active'] ?? $movie->is_active,
        ]);

        if (array_key_exists('category_ids', $data)) {
            $movie->categories()->sync($data['category_ids']);
        }

        $movie->load('categories', 'ratings');

        return ApiResponse::success(
            new MovieAdminResource($movie),
            'Movie updated successfully.'
        );
    }

    public function destroy(Request $request, Movie $movie): JsonResponse
    {
        $force = $request->boolean('force');

        if ($force) {
            if (!$movie->trashed()) {
                return ApiResponse::error(
                    'Hard delete hanya bisa dilakukan setelah soft delete.',
                    422
                );
            }

            $movie->forceDelete();

            return ApiResponse::success(
                null,
                'Movie permanently deleted.'
            );
        }

        if ($movie->trashed()) {
            return ApiResponse::error(
                'Movie already soft deleted.',
                400
            );
        }

        $movie->delete();

        return ApiResponse::success(
            null,
            'Movie soft deleted.'
        );
    }
}
