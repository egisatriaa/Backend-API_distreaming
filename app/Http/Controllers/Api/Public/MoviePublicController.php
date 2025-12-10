<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MoviePublicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Movie::with('categories')
            ->whereNull('deleted_at');

        //search by title
        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        //search by category
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        //sorting -- default: terbaru
        $sortBy = $request->get('sort_by', 'release_year');
        $order = in_array($request->get('order'), ['asc', 'desc']) ? $request->get('order') : 'desc';

        // Validasi kolom yang boleh di-sort
        $allowedSorts = ['release_year', 'title', 'rating'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'release_year';
        }

        if ($sortBy === 'rating') {
            // Sort by avg rating (gunakan subquery atau join)
            $query->withAvg('ratings', 'score')
                ->orderBy('ratings_avg_score', $order);
        } else {
            $query->orderBy($sortBy, $order);
        }

        //pagination
        $perPage = $request->get('per_page', 10);
        $perPage = min(max((int) $perPage, 1), 100);

        $movies = $query->paginate($perPage);

        //Tambahkan rating_class ke setiap movie

        $movies->getCollection()->transform(function ($movie) {
            $avgRating = $movie->ratings_avg_score ?? $movie->ratings()->avg('score') ?? 0;

            if ($avgRating >= 8.5) {
                $ratingClass = 'Top Rated';
            } elseif ($avgRating >= 7.0) {
                $ratingClass = 'Popular';
            } else {
                $ratingClass = 'Regular';
            }

            $movie->rating_avg = (float) number_format($avgRating, 1);
            $movie->rating_class = $ratingClass;

            return $movie;
        });

        return response()->json([
            'message' => 'Movies berhasil ditampilkan.',
            'data' => $movies->withQueryString(), 
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie): JsonResponse
    {
        if ($movie->deleted_at !== null) {
            return response()->json(['message' => 'Movie tidak ditemukan'], 404);
        }

        $movie->load('categories');

        // Hitung rating rata-rata & kelas
        $avgRating = $movie->ratings()->avg('score') ?? 0;
        if ($avgRating >= 8.5) {
            $ratingClass = 'Top Rated';
        } elseif ($avgRating >= 7.0) {
            $ratingClass = 'Popular';
        } else {
            $ratingClass = 'Regular';
        }

        $movie->rating_avg = (float) number_format($avgRating, 1);
        $movie->rating_class = $ratingClass;

        return response()->json([
            'message' => 'Movie berhasil ditampilkan.',
            'data' => $movie,
        ]);
    }
}
