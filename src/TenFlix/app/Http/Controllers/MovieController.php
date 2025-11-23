<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function destroy(Movie $movie): JsonResponse
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $movie->delete();

        return response()->json(['message' => 'Movie deleted']);
    }
}
