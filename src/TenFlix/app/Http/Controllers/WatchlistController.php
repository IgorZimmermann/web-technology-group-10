<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ToggleWatchRequest;
use App\Models\Movie;

class WatchlistController extends Controller
{
    // SHOW WATCHLIST PAGE
    public function index()
    {
        $movies = Auth::user()->watchlist()->get();

        return view('pages.list', [
            'listTitle' => 'Watchlist',
            'movies'    => $movies,
        ]);
    }

    // SHOW WATCHED PAGE
    public function seen()
    {
        $movies = Auth::user()->watched()->get();

        return view('pages.list', [
            'listTitle' => 'Seen',
            'movies'    => $movies,
        ]);
    }

    // CHECK IF A MOVIE IS IN WATCHLIST 
    public function status(ToggleWatchRequest $request) 
    {
        $tmdbId = (int) $request->validated('id');

        if (!Auth::check()) {
            return response()->json(['inWatchlist' => false]);
        }

        $movieId = Movie::where('tmdb_id', $tmdbId)->value('id');

        if (!$movieId) {
            return response()->json(['inWatchlist' => false]);
        }

        $user = Auth::user();

        $inWatchlist = $user->watchlist()->where('movies.id', $movieId)->exists();

        return response()->json(['inWatchlist' => $inWatchlist]);
    }

    // TOGGLE WATCHLIST
    public function setWatchlist(ToggleWatchRequest $request)
    {
        return $this->togglePivot($request, 'watchlist');
    }

    // TOGGLE WATCHED
    public function setWatched(ToggleWatchRequest $request)
    {
        return $this->togglePivot($request, 'watched');
    }

    // SHARED HELPER FOR WATCHLIST/WATCHED
    private function togglePivot(ToggleWatchRequest $request, string $relation)
    {
        $data = $request->validated();
        $tmdbId = (int) $data['id'];

        $movie = Movie::where('tmdb_id', $tmdbId)->firstOrFail();

        $user = Auth::user();

        $alreadyIn = $user->{$relation}()
            ->where('movies.id', $movie->id)
            ->exists();

        $user->{$relation}()->toggle($movie->id);

        return response()->json([
            'success' => true,
            'status'  => $alreadyIn ? 'removed' : 'added',
            'movieId' => $tmdbId,
        ]);
    }
}
