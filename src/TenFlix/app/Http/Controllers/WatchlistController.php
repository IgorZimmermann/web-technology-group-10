<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class WatchlistController extends Controller {
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
}
