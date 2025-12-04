<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $movies = Movie::where('title', 'ilike', '%' . $query . '%')
            ->limit(8)
            ->get()
            ->map(function ($movie) {
                return [
                    'id' => $movie->id,
                    'tmdb_id' => $movie->tmdb_id,
                    'title' => $movie->title,
                    'poster_path' => $movie->poster_path,
                    'release_date' => $movie->release_date,
                    'genre' => $movie->genre,
                    'overview' => $movie->overview,
                    'vote_average' => $movie->vote_average,
                    'vote_count' => $movie->vote_count,
                ];
            });

        return response()->json($movies);
    }
}
