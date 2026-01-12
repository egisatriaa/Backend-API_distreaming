<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;


class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Route::bind('category', function ($value) {
            return Category::withTrashed()->findOrFail($value);
        });

        Route::bind('movie', function ($value) {
            return Movie::withTrashed()->findOrFail($value);
        });

        Route::bind('publicMovie', function ($value) {
            return Movie::whereNull('deleted_at')->findOrFail($value);
        });

        Route::bind('publicCategory', function ($value) {
            return Category::whereNull('deleted_at')->findOrFail($value);
        });
    }
}
