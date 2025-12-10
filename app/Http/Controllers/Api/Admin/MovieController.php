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
    public function index() : JsonResponse
    {
        $movie = Movie::with('categories')->get();
        return response()->json([
            'message' => 'Film berhasil diambil.',
            'data' => $movie,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $movie = Movie::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'release_year' => $data['release_year'],
            'duration_minutes' => $data['duration_minutes'],
            'poster_url' => $data['poster_url'] ?? null,
        ]);

        //masukkin kategory
        if(!empty($data['category_ids'])){
            $movie->categories()->attach($data['category_ids']);
        }

        // load relation response
        $movie->load('categories');

        return response()->json([
            'message' => 'Film berhasil ditambahkan.',
            'data' => $movie,
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        $movie->load('categories');
        return response()->json([
            'message' => 'Film berhasil ditampilkan.',
            'data' => $movie,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
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

        //eager
        $movie->load('categories');

        return response()->json([
            'message' => 'Movie updated successfully.',
            'data' => $movie,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Movie $movie): JsonResponse
    {
        $force = $request->boolean('force');

        if ($force) {
            $movie->forceDelete();
            $message = 'Movie permanently deleted.';
        } else {
            $movie->delete();
            $message = 'Movie soft deleted.';
        }

        return response()->json([
            'message' => $message,
        ]);
    }
}
