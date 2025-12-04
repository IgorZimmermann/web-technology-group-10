<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
    public function status(Request $request)
    {
        $tmdbId = (int) $request->query('id');

        if (!$tmdbId || !Auth::check()) {
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
    public function setWatchlist(Request $request)
    {
        return $this->togglePivot($request, 'watchlist');
    }

    // TOGGLE WATCHED
    public function setWatched(Request $request)
    {
        return $this->togglePivot($request, 'watched');
    }

    // SHARED HELPER FOR WATCHLIST/WATCHED
    private function togglePivot(Request $request, string $relation)
    {
        // turn js JSON request into objects
        $body   = json_decode($request->getContent() ?: '{}');
        $tmdbId = isset($body->id) ? (int) $body->id : 0;

        if (!$tmdbId) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid movie id',
            ], 400);
        }

        $movie = Movie::where('tmdb_id', $tmdbId)->first();

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found',
            ], 404);
        }

        $user = Auth::user();

        $alreadyIn = $user->{$relation}()
            ->where('movies.id', $movie->id)
            ->exists();

        // Laravel pivot helper, if $relation is watchlist it becomes watchlist() and vice versa with watched
        $user->{$relation}()->toggle($movie->id);

        return response()->json([
            'success' => true,
            'status'  => $alreadyIn ? 'removed' : 'added',
            'movieId' => $tmdbId,
        ]);
    }
}
