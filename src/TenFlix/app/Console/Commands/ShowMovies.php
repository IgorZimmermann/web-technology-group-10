<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Movie;

class ShowMovies extends Command
{
    protected $signature = 'movies:show {limit=10}';
    protected $description = 'Show movies from database';

    public function handle()
    {
        $limit = $this->argument('limit');

        $this->info("Total movies: " . Movie::count());
        $this->line("");

        $movies = Movie::take($limit)->get();

        foreach ($movies as $movie) {
            $this->info("Title: {$movie->title}");
            $this->line("Release: {$movie->release_date}");
            $this->line("Rating: {$movie->vote_average}/10");
            $this->line("---");
        }
    }
}
