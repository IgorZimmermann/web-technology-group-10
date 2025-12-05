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
        $actionMovies = Movie::genre('Action')->take(12)->get();
        $thrillerMovies = Movie::genre('Thriller')->take(12)->get();
        $crimeMovies = Movie::genre('Crime')->take(12)->get();
        
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
