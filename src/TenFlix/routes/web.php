<?php

use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TopTenController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;
use App\Models\User;

Route::get('/', function () {
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

Route::get('/browse', function () {
    $movies = Movie::paginate(20);
    return view('pages.browse', [
        'listTitle' => "Browse",
        'movies' => $movies
    ]);
});

Route::get('/watchlist', function () {
    $watchlisted = array();
    if (Auth::check()) {
        $userId = Auth::id();
        $userWatchlist = User::where('id', $userId)->first()->watchlist;

        $watchlistSplit = array_filter(explode(',', $userWatchlist));
        $watchlisted = Movie::whereIn('tmdb_id', $watchlistSplit)->get();
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

Route::get('/watched', function () {
    $watched = array();
    if (Auth::check()) {
        $userId = Auth::id();
        $userWatched = User::where('id', $userId)->first()->watched;

        $watchedSplit = array_filter(explode(',', $userWatched));
        $watched = Movie::whereIn('tmdb_id', $watchedSplit)->get();
        return view('pages.list',
            [
                'listTitle' => "Seen",
                'movies' => $watched
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
})->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::post('/watchlist', [WatchlistController::class, 'setWatchlist']);
Route::post('/watched', [WatchlistController::class, 'setWatched']);
Route::get('/api/watchlist-status', function (\Illuminate\Http\Request $request) {
    $movieId = $request->query('id');

    if (!Auth::check() || !$movieId) {
        return response()->json(['inWatchlist' => false]);
    }

    $userWatchlist = Auth::user()->watchlist ?? '';
    $watchlistIds = array_filter(explode(',', $userWatchlist), fn($id) => strlen($id) > 0);

    return response()->json(['inWatchlist' => in_array((string)$movieId, $watchlistIds)]);
});

Route::get('/admin.html', function () {
    $movies = Movie::all();
    $topTenMovies = Movie::getTopTen();
    return view('pages.admin', ['movies' => $movies, 'topTenMovies' => $topTenMovies]);
});

Route::delete('/admin/movies/{movie}', [MovieController::class, 'destroy'])
    ->middleware('auth')
    ->name('admin.movies.destroy');
Route::get('/api/top-ten', [TopTenController::class, 'index']);
Route::post('/api/top-ten', [TopTenController::class, 'update']);
Route::post('/api/top-ten/reset', [TopTenController::class, 'reset']);

Route::post('/api/movies', [MovieController::class, 'store']);
Route::delete('/api/movies/{id}', [MovieController::class, 'destroy']);
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
                'tmdb_id' => $movie->tmdb_id,
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
