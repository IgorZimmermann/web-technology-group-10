<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class AdminController extends Controller
{
    public function index()
    {
        $movies = Movie::orderBy('id', 'asc')->get();
        $topTenMovies = Movie::getTopTen();

        return view('pages.admin', [
            'movies' => $movies,
            'topTenMovies' => $topTenMovies,
        ]);
    }
}
