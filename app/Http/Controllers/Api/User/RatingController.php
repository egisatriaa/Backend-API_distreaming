<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Resources\User\RatingResource;
use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class RatingController extends Controller
{
    public function index(Request $request, Movie $movie): JsonResponse
    {
        if ($movie->deleted_at) {
            return ApiResponse::error('Film tidak ditemukan.', 404);
        }

        $perPage = min($request->integer('per_page', 10), 50);

        $ratings = $movie->ratings()
            ->with('user:id,username')
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return ApiResponse::success(
            RatingResource::collection($ratings->items()),
            'Daftar rating berhasil ditampilkan.',
            200,
            [
                'current_page' => $ratings->currentPage(),
                'last_page' => $ratings->lastPage(),
                'per_page' => $ratings->perPage(),
                'total' => $ratings->total(),
            ]
        );
    }

    public function store(StoreRatingRequest $request, Movie $movie): JsonResponse
    {
        if ($movie->deleted_at) {
            return ApiResponse::error('Film tidak ditemukan.', 404);
        }

        $userId = $request->user()->id;

        if (
            Rating::where('user_id', $userId)
            ->where('movie_id', $movie->id)
            ->exists()
        ) {
            return ApiResponse::error(
                'Anda sudah memberikan rating untuk film ini.',
                409
            );
        }

        $rating = Rating::create([
            'user_id' => $userId,
            'movie_id' => $movie->id,
            'score' => $request->score,
            'review_text' => $request->review_text,
        ]);

        return ApiResponse::success(
            new RatingResource(
                $rating->load('user:id,username')
            ),
            'Rating berhasil ditambahkan.',
            201
        );
    }
}
