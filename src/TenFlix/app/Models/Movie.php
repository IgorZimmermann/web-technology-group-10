<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
      protected $fillable = [
        'tmdb_id',
        'title',
        'overview',
        'release_date',
        'poster_path',
        'genre',
        'vote_average',
        'vote_count',
        'top_ten_position',
    ];

    
    public static function getTopTen()
    {
        $customTopTen = self::whereNotNull('top_ten_position')
            ->orderBy('top_ten_position', 'asc')
            ->get();
        
        if ($customTopTen->count() > 0) {
            return $customTopTen;
        }
        
        return self::orderBy('vote_count', 'desc')
            ->take(10)
            ->get();
    }
}
