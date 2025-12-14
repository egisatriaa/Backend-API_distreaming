<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $movies = Movie::with('categories')
            ->withAvg('ratings', 'score')
            ->whereNull('deleted_at')
            ->get();

        $movies->transform(function ($movie) {
            $avgRating = $movie->ratings_avg_score ?? 0;

            if ($avgRating >= 8.5) {
                $ratingClass = 'Top Rated';
            } elseif ($avgRating >= 7.0) {
                $ratingClass = 'Popular';
            } else {
                $ratingClass = 'Regular';
            }

            // unset($movie->ratings_avg_score);

            $movie->rating_avg = (float) number_format($avgRating, 1);
            $movie->rating_class = $ratingClass;

            return $movie;
        });

        return response()->json([
            'success' => true,
            'message' => 'Film berhasil diambil.',
            'data' => $movies,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request): JsonResponse
    {
        $data = $request->validated();

        $movie = Movie::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'release_year' => $data['release_year'],
            'duration_minutes' => $data['duration_minutes'],
            'poster_url' => $data['poster_url'] ?? null,
        ]);

        if (!empty($data['category_ids'])) {
            $movie->categories()->attach($data['category_ids']);
        }

        $movie->load('categories');

        return response()->json([
            'success' => true,
            'message' => 'Film berhasil ditambahkan.',
            'data' => $movie,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $movie = Movie::withTrashed()->with('categories')->find($id);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'film tidak ditemukan',
            ], 404);
        }

        if ($movie->deleted_at) {
            return response()->json([
                'success' => false,
                'message' => 'Film ini sudah di soft delete.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Film berhasil ditampilkan.',
            'data' => $movie,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, $id): JsonResponse
    {
        $movie = Movie::withTrashed()->find($id);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'film tidak ditemukan',
            ], 404);
        }

        $data = $request->validated();

        $movie->update([
            'title' => $data['title'] ?? $movie->title,
            'description' => $data['description'] ?? $movie->description,
            'release_year' => $data['release_year'] ?? $movie->release_year,
            'duration_minutes' => $data['duration_minutes'] ?? $movie->duration_minutes,
            'poster_url' => $data['poster_url'] ?? $movie->poster_url,
        ]);

        if (isset($data['category_ids'])) {
            $movie->categories()->sync($data['category_ids']);
        }

        $movie->load('categories');

        return response()->json([
            'success' => true,
            'message' => 'Film berhasil diperbarui.',
            'data' => $movie,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $movie): JsonResponse
    {
        if (!is_numeric($movie)) {
            return response()->json([
                'success' => false,
                'message' => 'ID film tidak valid.',
            ], 400);
        }

        // Cari film (termasuk yang soft-deleted)
        $movie = Movie::withTrashed()->find((int) $movie);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'film tidak ditemukan',
            ], 404);
        }

        $force = $request->boolean('force');
        $title = $movie->title;

        if ($force) {
            // Hard delete hanya boleh jika sudah di soft delete
            if (is_null($movie->deleted_at)) {
                return response()->json([
                    'success' => false,
                    'message' => "Film {$title} tidak bisa menghapus permanen. Silakan soft delete terlebih dahulu.",
                ], 422);
            }

            $movie->forceDelete();
            $message = "Film berjudul '{$title}' dihapus permanen.";
        } else {
            // Soft delete hanya jika belum dihapus
            if (!is_null($movie->deleted_at)) {
                return response()->json([
                    'success' => false,
                    'message' => "Film berjudul '{$title}' sudah di soft delete.",
                ], 400);
            }

            $movie->delete();
            $message = "Film berjudul '{$title}' berhasil di soft-delete.";
        }

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
}
