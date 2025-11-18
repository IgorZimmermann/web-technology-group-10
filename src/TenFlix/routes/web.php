<?php

use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Models\Movie;

Route::get('/', function () {
    $movies = Movie::all();
    return view('pages.home', ['movies' => $movies]);
})->name('home');

Route::get('/index.html', function () {
    $movies = Movie::all();
    return view('pages.home', ['movies' => $movies]);
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
    return view('pages.admin', ['movies' => $movies]);
});
