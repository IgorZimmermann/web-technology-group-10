<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;

class FetchMovies extends Command
{
    protected $signature = 'tmdb:fetch-movies {pages=5}';
    protected $description = 'Fetch popular movies from TMDB API';

    public function handle()
    {
        $pages = $this->argument('pages');
        $apiKey = config('services.tmdb.key');
        $baseUrl = config('services.tmdb.base_url');
        $genreMap = $this->fetchGenreMap($baseUrl, $apiKey);

        $this->info("Fetching {$pages} pages of movies...");

        for ($page = 1; $page <= $pages; $page++) {
            $response = Http::get("{$baseUrl}/movie/popular", [
                'api_key' => $apiKey,
                'page' => $page,
            ]);

            if ($response->successful()) {
                $movies = $response->json()['results'];

                foreach ($movies as $movieData) {
                    Movie::updateOrCreate(
                        ['tmdb_id' => $movieData['id']],
                        [
                            'title' => $movieData['title'],
                            'overview' => $movieData['overview'],
                            'release_date' => $movieData['release_date'] ?? null,
                            'genre' => $this->formatGenres($movieData['genre_ids'] ?? [], $genreMap),
                            'poster_path' => $movieData['poster_path'],
                            'vote_average' => $movieData['vote_average'],
                            'vote_count' => $movieData['vote_count'],
                        ]
                    );
                }

                $this->info("Page {$page} imported successfully!");
            } else {
                $this->error("Failed to fetch page {$page}");
            }

            sleep(1);
        }

        $this->assignDefaultTopTenIfEmpty();
        $this->info('Import completed!');
    }

    private function assignDefaultTopTenIfEmpty(): void
    {
        if (Movie::whereNotNull('top_ten_position')->exists()) {
            return;
        }

        $topTen = Movie::orderBy('vote_count', 'desc')
            ->take(10)
            ->get();

        foreach ($topTen as $index => $movie) {
            $movie->top_ten_position = $index + 1;
            $movie->save();
        }
    }

    // Fetch the TMDB genre list and convert id into a name map
    private function fetchGenreMap(string $baseUrl, string $apiKey): array
    {   
        // fetch genre id list
        $response = Http::get("{$baseUrl}/genre/movie/list", [
            'api_key' => $apiKey,
            'language' => 'en-US',
        ]);

        if (! $response->successful()) {
            $this->warn('Unable to retrieve TMDB genres; continuing without genre labels.');
            return [];
        }
        // creates a genre map based on the result 
        return collect($response->json('genres', []))
        ->pluck('name', 'id')   // [id => name]
        ->toArray();

        return $genreMap;
    }

        // for each genreIds in a genre map it returns the genre name
    private function formatGenres(array $genreIds, array $genreMap): ?string
    {
        if (empty($genreIds) || empty($genreMap)) {
            return null;
        }

        $names = collect($genreIds)
        ->map(fn ($id) => $genreMap[$id] ?? null)  // lookup id in map
        ->filter()                                  // remove nulls
        ->all();

        return empty($names) ? null : implode(', ', $names);
    }
}
