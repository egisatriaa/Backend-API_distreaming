<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(Movie $movie): JsonResponse
    {
        if ($movie->deleted_at !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Film tidak ditemukan.'
            ], 404);
        }

        $ratings = $movie->ratings()->with('user:id,username')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar rating berhasil ditampilkan.',
            'data' => $ratings,
        ]);
    }

    public function store(StoreRatingRequest $request, Movie $movie): JsonResponse
    {
        // Pastikan film aktif
        if ($movie->deleted_at !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Film tidak ditemukan.'
            ], 404);
        }

        $userId = $request->user()->id;

        // Cek apakah user sudah pernah rating film ini
        if (Rating::where('user_id', $userId)->where('movie_id', $movie->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan rating untuk film ini.'
            ], 409);
        }

        $rating = Rating::create([
            'user_id' => $userId,
            'movie_id' => $movie->id,
            'score' => $request->score,
            'review_text' => $request->review_text,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rating berhasil ditambahkan.',
            'data' => $rating,
        ], 201);
    }
}
