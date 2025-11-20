<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    public function destroy($id)
    {
        try {
            $movie = Movie::findOrFail($id);
            $movie->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Movie deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete movie: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'poster_path' => 'required|string',
        ]);

        try {
            $movie = Movie::create([
                'title' => $request->title,
                'poster_path' => $request->poster_path,
                'overview' => $request->overview ?? '',
                'release_date' => $request->release_date ?? now()->format('Y-m-d'),
                'vote_average' => $request->vote_average ?? 0,
                'vote_count' => $request->vote_count ?? 0,
                'genre' => $request->genre ?? null,
                'tmdb_id' => null, // Manually added movies don't have TMDB ID
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Movie added successfully',
                'data' => $movie
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add movie: ' . $e->getMessage()
            ], 500);
        }
    }
}



 