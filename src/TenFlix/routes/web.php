<?php

use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TopTenController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;

Route::get('/', function () {
    $movies = Movie::all();
    $bannerMovie = Movie::orderBy('vote_count', 'desc')->first();
    $topMovies = Movie::getTopTen();
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

    $movies = Movie::orderBy('id', 'asc')->get();
    $topTenMovies = Movie::getTopTen();

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
    $topTenMovies = Movie::getTopTen();
    return view('pages.admin', ['movies' => $movies, 'topTenMovies' => $topTenMovies]);
});

Route::get('/api/top-ten', [TopTenController::class, 'index']);
Route::post('/api/top-ten', [TopTenController::class, 'update']);
Route::post('/api/top-ten/reset', [TopTenController::class, 'reset']);

Route::post('/api/movies', [MovieController::class, 'store']);
Route::delete('/api/movies/{id}', [MovieController::class, 'destroy']);
