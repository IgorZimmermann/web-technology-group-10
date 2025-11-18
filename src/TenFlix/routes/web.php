<?php

use Illuminate\Support\Facades\Route;
use App\Models\Movie;

Route::get('/', function () {
    $movies = Movie::all();
    return view('pages.home', ['movies' => $movies]);
});


Route::view('/login.html', 'pages.login');

Route::view('/signup.html', 'pages.signup');

Route::get('/topten_slider.html', function () {
	$movies = App\Models\Movie::orderBy('vote_count', 'desc')->take(10)->get();
	return view('pages.topten_slider', ['movies' => $movies]);
});
