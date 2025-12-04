<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class WatchlistController extends Controller {


    public function index()
    {
        $userWatchlist = Auth::user()->watchlist ?? '';
        $ids = array_filter(explode(',', $userWatchlist))

        $movies = Movie::whereIn('tmdb_id', $ids)->get();

        return view('page.list', [
            'listTitle' => 'Watchlist',
            'movies' => $movies,
        ]);
    }

    public function seen()
    {
        $userWatched = Auth::user()->watched ?? '';
        $ids = array_filter(explode(',', $userWatched))

        $movies = Movie::whereIn('tmdb_id', $ids)->get();

        return view('page.list', [
            'listTitle' => 'Watchlist',
            'movies' => $movies,
        ]);
    }

    public function status(Request $request)
    {
        $movieId = $request->query('id');

        if (!Auth::check() || !$movieId) {
            return response()->json(['inWatchlist' => false]);
        }

        $userWatchlist = Auth::user()->watchlist ?? '';
        $watchlistIds = array_filter(explode(',', $userWatchlist), fn($id) => strlen($id) > 0);

        return response()->json(['inWatchlist' => in_array((string)$movieId, $watchlistIds)]);
    }

    public function setWatchlist(Request $request) {
        $body = json_decode($request->getContent());
        $id = (string)$body->id;

        if (!Auth::check()) {
            return 'not authed';
        }

        $userId = Auth::id();
        $userWatchlist = Auth::user()->watchlist;

        $splitWatchlist = array_filter(explode(',', $userWatchlist), static function ($elem) {
            return strlen($elem) > 0;
        });
        if (in_array($id, $splitWatchlist)) {
            $splitWatchlist = array_filter($splitWatchlist, function ($element) use ($id) {
                return $element != $id;
            });
        } else {
            $splitWatchlist[] = $id;
        }

        $newWatchlist = implode(',', $splitWatchlist);

        User::where('id',$userId)->update(['watchlist' => $newWatchlist]);

        return "{$newWatchlist}";
    }

    public function setWatched(Request $request) {
        $body = json_decode($request->getContent());
        $id = (string)$body->id;

        if (!Auth::check()) {
            return 'not authed';
        }

        $userId = Auth::id();
        $userWatched = Auth::user()->watched;

        $splitWatched = array_filter(explode(',', $userWatched), static function ($elem) {
            return strlen($elem) > 0;
        });
        if (in_array($id, $splitWatched)) {
            $splitWatched = array_filter($splitWatched, function ($element) use ($id) {
                return $element != $id;
            });
        } else {
            $splitWatched[] = $id;
        }

        $newWatched = implode(',', $splitWatched);

        User::where('id',$userId)->update(['watched' => $newWatched]);

        return "{$newWatched}";
    }
}
