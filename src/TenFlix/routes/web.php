<?php

use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Models\Movie;

// home at both "/" and "/index.html"
Route::view('/', 'pages.home')->name('home');
Route::view('/index.html', 'pages.home');


Route::get('/admin', function()
    {
    if (Auth::user()->is_admin==true) {
        return view('pages.admin');
    }
    else {
        return redirect('/');
    }
});

Route::view('/login.html', 'pages.login');
Route::view('/signup.html', 'pages.signup');
Route::get('/topten_slider.html', function () {
	$movies = App\Models\Movie::orderBy('vote_count', 'desc')->take(10)->get();
	return view('pages.topten_slider', ['movies' => $movies]);
});

Route::get('/signup', function () {
    return view('pages.signup');
});
Route::post('/signup', [SignupController::class, 'signup']);

Route::get('login', function () {
    return view('pages.login');
});
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/admin.html', function () {
    $movies = Movie::all();
    $topTenMovies = Movie::orderBy('vote_count', 'desc')->take(10)->get();
    return view('pages.admin', ['movies' => $movies, 'topTenMovies' => $topTenMovies]);
});
