<?php

use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;
use App\Models\User;

Route::get('/', function () {
    $movies = Movie::all();
    $watchlisted = array();
    if (Auth::check()) {
        $userId = Auth::id();
        $userWatchlist = User::where('id', $userId)->first()->watchlist;

        $watchlistSplit = explode(',', $userWatchlist);
        $watchlisted = $movies->filter(function ($element) use ($watchlistSplit) {
            return in_array($element->tmdb_id, $watchlistSplit ?? []);
        });
    }
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
        'watchlisted' => $watchlisted,
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

Route::get('/watchlist', function () {
    $movies = Movie::all();
    $watchlisted = array();
    if (Auth::check()) {
        $userId = Auth::id();
        $userWatchlist = User::where('id', $userId)->first()->watchlist;

        $watchlistSplit = explode(',', $userWatchlist);
        $watchlisted = $movies->filter(function ($element) use ($watchlistSplit) {
            return in_array($element->tmdb_id, $watchlistSplit ?? []);
        });
        return view('pages.list',
            [
                'listTitle' => "Watchlist",
                'movies' => $watchlisted
            ]
        );
    } else {
        return redirect()->route('login');
    }
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
})->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::post('/watchlist', [WatchlistController::class, 'setWatchlist']);

Route::get('/admin.html', function () {
    $movies = Movie::all();
    $topTenMovies = Movie::orderBy('vote_count', 'desc')->take(10)->get();
    return view('pages.admin', ['movies' => $movies, 'topTenMovies' => $topTenMovies]);
});
