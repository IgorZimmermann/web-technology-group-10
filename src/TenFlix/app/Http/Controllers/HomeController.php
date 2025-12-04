<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        $bannerMovie = Movie::orderBy('vote_count', 'desc')->first();
        $topMovies = Movie::getTopTen();
        $actionMovies = Movie::where('genre', 'like', '%Action%')->orderBy('vote_count', 'desc')->take(12)->get();
        $thrillerMovies = Movie::where('genre', 'like', '%Thriller%')->orderBy('vote_count', 'desc')->take(12)->get();
        $crimeMovies = Movie::where('genre', 'like', '%Crime%')->orderBy('vote_count', 'desc')->take(12)->get();
        
        return view('pages.home', [
            'movies' => $movies,
            'bannerMovie' => $bannerMovie,
            'topMovies' => $topMovies,
            'actionMovies' => $actionMovies,
            'thrillerMovies' => $thrillerMovies,
            'crimeMovies' => $crimeMovies,
        ]);
    }
}
