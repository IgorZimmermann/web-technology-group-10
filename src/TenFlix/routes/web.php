<?php

use Illuminate\Support\Facades\Route;
use App\Models\Movie;

Route::get('/', function () {
    $movies = Movie::all();
    $topMovies = Movie::orderBy('vote_count', 'desc')->take(10)->get();
    return view('pages.home', [
        'movies' => $movies,
        'topMovies' => $topMovies,
    ]);
});

Route::view('/login.html', 'pages.login');
Route::view('/signup.html', 'pages.signup');
