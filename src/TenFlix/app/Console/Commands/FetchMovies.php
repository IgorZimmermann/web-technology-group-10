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
                            //'genre' => $movieData['genere'],
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

        $this->info('Import completed!');
    }
}
