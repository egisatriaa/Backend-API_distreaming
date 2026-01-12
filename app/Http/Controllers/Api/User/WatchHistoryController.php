<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWatchHistoryRequest;
use App\Http\Resources\User\WatchHistoryResource;
use App\Models\Movie;
use App\Models\WatchHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class WatchHistoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->integer('per_page', 10), 50);

        $history = $request->user()
            ->watchHistory()
            ->with('movie:id,title,poster_url')
            ->orderByDesc('watched_at')
            ->paginate($perPage);

        return ApiResponse::success(
            WatchHistoryResource::collection($history->items()),
            'Riwayat tontonan berhasil ditampilkan.',
            200,
            [
                'current_page' => $history->currentPage(),
                'last_page' => $history->lastPage(),
                'per_page' => $history->perPage(),
                'total' => $history->total(),
            ]
        );
    }

    public function store(StoreWatchHistoryRequest $request, Movie $movie): JsonResponse
    {
        if ($movie->deleted_at) {
            return ApiResponse::error('Film tidak ditemukan.', 404);
        }

        $history = WatchHistory::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'movie_id' => $movie->id,
            ],
            [
                'is_completed' => $request->boolean('is_completed'),
                'watched_at' => now(),
            ]
        );

        return ApiResponse::success(
            new WatchHistoryResource(
                $history->load('movie:id,title,poster_url')
            ),
            'Riwayat tontonan berhasil disimpan.',
            201
        );
    }
}
