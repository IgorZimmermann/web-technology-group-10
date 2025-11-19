<?php

use Illuminate\Support\Facades\Route;
use App\Models\Movie;

Route::get('/', function () {
    $movies = Movie::all();
    $topMovies = Movie::orderBy('vote_count', 'desc')->take(10)->get();
    $actionMovies = Movie::where('genre', 'like', '%Action%')
        ->orderBy('vote_count', 'desc')
        ->take(12)
        ->get();
    return view('pages.home', [
        'movies' => $movies,
        'topMovies' => $topMovies,
        'actionMovies' => $actionMovies,
    ]);
});

Route::view('/login.html', 'pages.login');
Route::view('/signup.html', 'pages.signup');
