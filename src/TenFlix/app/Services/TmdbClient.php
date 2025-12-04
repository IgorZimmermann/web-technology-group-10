<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TmdbClient 
{
    public function fetchMovie(int $tmdbId): array
    {
        $apiKey = config('services.tmdb.key');

        if (!$apiKey) {
            throw new \RuntimeException('TMDB API key not configured');
        }

        $baseUrl = config('services.tmdb.base_url', 'https://api.themoviedb.org/3');

        $response = Http::get("{$baseUrl}/movie/{$tmdbId}", [
            'api_key' => $apiKey,
        ]);

        if ($response->failed()) {
            throw new \RuntimeException('Failed to fetch movie from TMDB');
        }

        return $response->json();
    }
}
