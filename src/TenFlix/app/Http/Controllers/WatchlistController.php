<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class WatchlistController extends Controller {
    public function watchlist(Request $request) {
        Log::info('hello');
        $validated = $request->validate([
            'id' => 'required'
        ])
        if (Auth::check()) {
            $userId = Auth::id();
            $userWatchlist = Auth::user()->watchlist;
            $splitWatchlist = explode(',', $userWatchlist);
            if(in_array($validated->id, $splitWatchlist)) {
                $splitWatchlist = array_filter($splitWatchlist, static function ($element) {
                    return $element !== $validated->id;
                })
            } else {
                $splitWatchlist = array_push($splitWatchlist, [$validated->id]);
            }

            User::update(
                ['id' => $userId],
                [
                    'watchlist' => implode(',', $splitWatchlist)
                ]
                );

        }
        return response()->json([], 200);


    }
}
