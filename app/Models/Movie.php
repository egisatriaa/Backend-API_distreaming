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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'movie_categories');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('score');
    }

    public function scopeFilterBySearch($query, $search)
    {
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }
        return $query;
    }

    public function scopeFilterByCategory($query, $categoryId)
    {
        if ($categoryId) {
            $query->whereHas('categories', fn($q) => $q->where('id', $categoryId));
        }
        return $query;
    }
}
