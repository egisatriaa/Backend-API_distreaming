<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\Admin\MovieController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Public\MoviePublicController;
use App\Http\Controllers\Api\User\RatingController;
use App\Http\Controllers\Api\User\WatchHistoryController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

//Route publik
Route::get('/movies', [MoviePublicController::class, 'index']);
Route::get('/movies/{movie}', [MoviePublicController::class, 'show']);

// Route yang memerlukan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $request) => $request->user()); // kembalikan user yang sedang login
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::post('/movies/{movie}/rate', [RatingController::class, 'store']);
    Route::get('/movies/{movie}/ratings', [RatingController::class, 'index']);
    Route::post('/movies/{movie}/watch', [WatchHistoryController::class, 'store']);
    Route::get('/watch-history', [WatchHistoryController::class, 'index']);
});

//hanya admin yang bisa akses
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('movies', MovieController::class);
    Route::apiResource('categories', CategoryController::class);
});
