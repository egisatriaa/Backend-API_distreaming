<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryPublicController extends Controller
{
    /**
     * Display a listing of categories (public).
     */
    public function index(): JsonResponse
    {
        $categories = Category::whereNull('deleted_at')->get();

        return response()->json([
            'success' => true,
            'message' => 'Categories berhasil ditampilkan.',
            'data' => $categories,
        ]);
    }

    /**
     * Display the specified category with its movies (public).
     */
    public function show(Category $category): JsonResponse
    {
        if ($category->deleted_at !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $category->load([
            'movies' => function ($query) {
                $query->whereNull('movies.deleted_at')
                    ->select(
                        'movies.id',
                        'movies.title',
                        'movies.poster_url',
                        'movies.release_year'
                    )
                    ->withAvg('ratings', 'score')
                    ->orderByDesc('ratings_avg_score');
            }
        ]);

        $category->movies->transform(function ($movie) {
            $avgRating = $movie->ratings_avg_score ?? 0;

            if ($avgRating >= 8.5) {
                $ratingClass = 'Top Rated';
            } elseif ($avgRating >= 7.0) {
                $ratingClass = 'Popular';
            } else {
                $ratingClass = 'Regular';
            }

            $movie->rating_avg = (float) number_format($avgRating, 1);
            $movie->rating_class = $ratingClass;

            unset($movie->ratings_avg_score);

            return $movie;
        });

        return response()->json([
            'success' => true,
            'message' => 'Category berhasil ditampilkan.',
            'data' => $category,
        ]);
    }
}
