<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WatchHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'movie_id',
        'is_completed',
    ];

    protected $casts = [
        'watched_at' => 'datetime',
        'is_completed' => 'boolean',
    ];

    //Boot method untuk mengatur watched_at otomatis.
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($watchHistory) {
            // Jika watched_at belum di-set (misal oleh sistem internal), set ke waktu sekarang
            if (empty($watchHistory->watched_at)) {
                $watchHistory->watched_at = now();
            }
        });
    }

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
