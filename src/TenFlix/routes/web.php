<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{SignupController,LoginController,TopTenController,MovieController,WatchlistController,HomeController,AdminController,SearchController};

// HOMEPAGE
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/index.html', fn() => redirect()->route('home'));

// DASHBOARD
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin.html', fn () => redirect()->route('admin.index'));
});

// SIGNUP
Route::view('/signup.html', 'pages.signup');
Route::get('/signup', fn () => view('pages.signup'));
Route::post('/signup', [SignupController::class, 'signup']);

// LOGIN & LOGOUT
Route::view('/login.html', 'pages.login');
Route::get('/login', fn () => view('pages.login'))->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

// WATCHLIST / WATCHED LIST
Route::middleware(['auth'])->group(function () {
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::get('/watched',  [WatchlistController::class, 'seen'])->name('watched.index');

    Route::post('/watchlist', [WatchlistController::class, 'setWatchlist']);
    Route::post('/watched',  [WatchlistController::class, 'setWatched']);
    
    // WATCHLIST STATUS
    Route::get('/api/watchlist-status', [WatchlistController::class, 'status']);
});



// SEARCH FUNCTION
Route::get('/api/search', [SearchController::class, 'index']);

// ADMIN EDIT TOP 10 + MOVIES
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/api/top-ten', [TopTenController::class, 'index']);
    Route::post('/api/top-ten', [TopTenController::class, 'update']);
    Route::post('/api/top-ten/reset', [TopTenController::class, 'reset']);

    Route::post('/api/movies', [MovieController::class, 'store']);
    Route::delete('/api/movies/{movie}', [MovieController::class, 'destroy'])->name('admin.movies.destroy');
    
});
