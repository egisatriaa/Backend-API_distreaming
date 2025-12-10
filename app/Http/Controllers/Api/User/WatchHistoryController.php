<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWatchHistoryRequest;
use App\Models\Movie;
use App\Models\WatchHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WatchHistoryController extends Controller
{
    public function store(StoreWatchHistoryRequest $request, Movie $movie): JsonResponse
    {
        if ($movie->deleted_at !== null) {
            return response()->json(['message' => 'Film tidak ditemukan.'], 404);
        }

        $existing = WatchHistory::where('user_id', $request->user()->id)
            ->where('movie_id', $movie->id)
            ->first();

        if ($existing) {
            // Update entri yang ada (opsional: bisa juga buat entri baru tiap sesi)
            $existing->update([
                'is_completed' => $request->boolean('is_completed'),
                // watched_at tetap waktu pertama kali ditonton
            ]);
            $watchHistory = $existing;
        } else {
            // Buat entri baru
            $watchHistory = WatchHistory::create([
                'user_id' => $request->user()->id,
                'movie_id' => $movie->id,
                'is_completed' => $request->boolean('is_completed'),
                // watched_at diisi otomatis oleh model
            ]);
        }

        return response()->json([
            'message' => 'Riwayat tontonan berhasil disimpan.',
            'data' => $watchHistory,
        ], 201);
    }

    public function index(Request $request): JsonResponse
    {
        $watchHistory = $request->user()
            ->watchHistory()
            ->with('movie:id,title,poster_url')
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Riwayat tontonan berhasil ditampilkan.',
            'data' => $watchHistory,
        ]);
    }
}