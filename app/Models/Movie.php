<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'duration_minutes',
        'release_year',
        'poster_url',
    ];

    protected $casts = [
        'release_year' => 'integer',
        'duration_minutes' => 'integer'
    ];

    protected $hidden = ['ratings_avg_score'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'movie_categories');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
