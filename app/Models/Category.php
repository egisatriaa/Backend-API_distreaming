<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_name',
        'description',
    ];

    protected $cast = [
        'category_name' => 'string',
    ];

    public function movies(){
        return $this->belongsToMany(Movie::class, 'movie_categories');
    }
}
