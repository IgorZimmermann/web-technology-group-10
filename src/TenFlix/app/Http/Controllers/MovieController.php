<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\MovieStoreRequest;
use App\Services\TmdbClient;


class MovieController extends Controller
{
    public function __construct(private TmdbClient $tmdb)
    {
    }

    public function destroy(Movie $movie): JsonResponse
    {
        $movie->delete();

        return response()->json(['message' => 'Movie deleted']);
    }
    
    public function store(MovieStoreRequest $request): JsonResponse
    {
        $tmdbId = (int) $request->validated('tmdb_id');

        $existingMovie = Movie::where('tmdb_id', $tmdbId)->first();
            if ($existingMovie) {
                return response()->json([
                    'success' => false,
                    'message' => 'Movie with this TMDB ID already exists'
                ], 400);
            }
    
        try {
            $movieData = $this->tmdb->fetchMovie($tmdbId);
            $genres = collect($movieData['genres'] ?? [])->pluck('name')->implode(', ');

            $movie = Movie::create([
                'tmdb_id' => $tmdbId,
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
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add movie: ' . $e->getMessage()
            ], 500);
        }
    }
}
