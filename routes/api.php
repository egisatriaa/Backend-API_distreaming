<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\Admin\MovieController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Public\MoviePublicController;
use App\Http\Controllers\Api\User\RatingController;
use App\Http\Controllers\Api\User\WatchHistoryController;
use App\Http\Controllers\Api\Public\CategoryPublicController;

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

//Route publik
Route::prefix('guest')->group(function () {
    Route::get('/movies', [MoviePublicController::class, 'index']);
    Route::get('/movies/{publicMovie}', [MoviePublicController::class, 'show']);
    Route::get('/categories', [CategoryPublicController::class, 'index']);
    Route::get('/categories/{publicCategory}', [CategoryPublicController::class, 'show']);
    Route::get('/movies/{movie}/ratings', [RatingController::class, 'index']);
});

// Route User yang memerlukan autentikasi
Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('/me', fn(Request $request) => $request->user());
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    // Endpoint yang bisa diakses user tapi identik dengan guest
    Route::get('/movies', [MoviePublicController::class, 'index']);
    Route::get('/movies/{publicMovie}', [MoviePublicController::class, 'show']);
    Route::get('/categories', [CategoryPublicController::class, 'index']);
    Route::get('/categories/{publicCategory}', [CategoryPublicController::class, 'show']);

    // Endpoint khusus user
    Route::post('/movies/{movie}/rate', [RatingController::class, 'store']);
    Route::get('/movies/{movie}/ratings', [RatingController::class, 'index']);
    Route::post('/movies/{movie}/watch-history', [WatchHistoryController::class, 'store']);
    Route::get('/watch-history', [WatchHistoryController::class, 'index']);
});

//hanya admin yang bisa akses
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('movies', MovieController::class);
    Route::apiResource('categories', CategoryController::class);
});
