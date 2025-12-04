<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function destroy(Movie $movie): JsonResponse
    {
        $movie->delete();

        return response()->json(['message' => 'Movie deleted']);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'tmdb_id' => 'required|integer',
        ]);

        try {
            $existingMovie = Movie::where('tmdb_id', $request->tmdb_id)->first();
            if ($existingMovie) {
                return response()->json([
                    'success' => false,
                    'message' => 'Movie with this TMDB ID already exists'
                ], 400);
            }

            $apiKey = env('TMDB_API_KEY');
            if (!$apiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'TMDB API key not configured'
                ], 500);
            }

            $response = Http::get("https://api.themoviedb.org/3/movie/{$request->tmdb_id}", [
                'api_key' => $apiKey,
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch movie from TMDB. Please check the TMDB ID.'
                ], 404);
            }

            $movieData = $response->json();

            $genres = collect($movieData['genres'] ?? [])->pluck('name')->implode(', ');

            $movie = Movie::create([
                'tmdb_id' => $request->tmdb_id,
                'title' => $movieData['title'] ?? 'Unknown',
                'poster_path' => $movieData['poster_path'] ?? '',
                'overview' => $movieData['overview'] ?? '',
                'release_date' => $movieData['release_date'] ?? now()->format('Y-m-d'),
                'vote_average' => $movieData['vote_average'] ?? 0,
                'vote_count' => $movieData['vote_count'] ?? 0,
                'genre' => $genres ?: null,
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
