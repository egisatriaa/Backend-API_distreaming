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
        // withAvg
        $query = Movie::with('categories')
            ->withAvg('ratings', 'score')
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

        //  order by
        if ($sortBy === 'rating') {
            $query->orderBy('ratings_avg_score', $order);
        } else {
            $query->orderBy($sortBy, $order);
        }

        //pagination
        $perPage = $request->get('per_page', 10);
        $perPage = min(max((int) $perPage, 1), 100);

        $movies = $query->paginate($perPage);

        //Tambah rating_class ke setiap movie
        $movies->getCollection()->transform(function ($movie) {
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

            return $movie;
        });

        return response()->json([
            'success' => true,
            'message' => 'Movies berhasil ditampilkan.',
            'data' => $movies->withQueryString(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $movie): JsonResponse
    {
        if (!is_numeric($movie)) {
            return response()->json([
                'success' => false,
                'message' => 'ID movie tidak valid.',
            ], 400);
        }

        // Cari HANYA movie yang aktif + hitung avg rating dalam 1 query
        $movieModel = Movie::withAvg('ratings', 'score')
            ->with('categories')
            ->find((int) $movie);

        if (!$movieModel) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $avgRating = $movieModel->ratings_avg_score ?? 0;

        if ($avgRating >= 8.5) {
            $ratingClass = 'Top Rated';
        } elseif ($avgRating >= 7.0) {
            $ratingClass = 'Popular';
        } else {
            $ratingClass = 'Regular';
        }

        $movieModel->rating_avg = (float) number_format($avgRating, 1);
        $movieModel->rating_class = $ratingClass;

        return response()->json([
            'success' => true,
            'message' => 'Movie berhasil ditampilkan.',
            'data' => $movieModel,
        ]);
    }
}
