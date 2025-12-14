<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Movie;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // // Custom binding untuk category (include soft deleted)
        // Route::bind('category', function ($value) {
        //     return Category::withTrashed()->findOrFail($value);
        // });

        // // Custom binding untuk movie (include soft deleted)
        // Route::bind('movie', function ($value) {
        //     return Movie::withTrashed()->find($value);
        // });
    }
}
