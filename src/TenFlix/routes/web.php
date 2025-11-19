<?php

use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;

Route::get('/', function () {
    $movies = Movie::all();
    $bannerMovie = Movie::orderBy('vote_count', 'desc')->first();
    $topMovies = Movie::orderBy('vote_count', 'desc')->take(10)->get();
    $actionMovies = Movie::where('genre', 'like', '%Action%')
        ->orderBy('vote_count', 'desc')
        ->take(12)
        ->get();
    $thrillerMovies = Movie::where('genre', 'like', '%Thriller%')
        ->orderBy('vote_count', 'desc')
        ->take(12)
        ->get();
    $crimeMovies = Movie::where('genre', 'like', '%Crime%')
        ->orderBy('vote_count', 'desc')
        ->take(12)
        ->get();
    return view('pages.home', [
        'movies' => $movies,
        'bannerMovie' => $bannerMovie,
        'topMovies' => $topMovies,
        'actionMovies' => $actionMovies,
        'thrillerMovies' => $thrillerMovies,
        'crimeMovies' => $crimeMovies,
    ]);
})->name('home');

Route::get('/index.html', function () {
    return redirect()->route('home');
});

Route::get('/admin', function () {
    if (!Auth::check() || !Auth::user()->is_admin) {
        return redirect('/');
    }

    $movies = Movie::all();
    $topTenMovies = Movie::orderBy('vote_count', 'desc')->take(10)->get();

    return view('pages.admin', [
        'movies' => $movies,
        'topTenMovies' => $topTenMovies,
    ]);
});

Route::view('/login.html', 'pages.login');
Route::view('/signup.html', 'pages.signup');
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
