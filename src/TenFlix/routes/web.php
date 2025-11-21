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
    $topTenMovies = Movie::orderBy('vote_count', 'desc')->take(10)->get();
    return view('pages.admin', ['movies' => $movies, 'topTenMovies' => $topTenMovies]);
});

// Search API endpoint
Route::get('/api/search', function (\Illuminate\Http\Request $request) {
    $query = $request->query('q', '');

    if (strlen($query) < 2) {
        return response()->json([]);
    }

    $movies = Movie::where('title', 'ilike', '%' . $query . '%')
        ->limit(8)
        ->get()
        ->map(function ($movie) {
            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'poster_path' => $movie->poster_path,
                'release_date' => $movie->release_date,
                'genre' => $movie->genre,
                'overview' => $movie->overview,
                'vote_average' => $movie->vote_average,
                'vote_count' => $movie->vote_count,
            ];
        });

    return response()->json($movies);
});
