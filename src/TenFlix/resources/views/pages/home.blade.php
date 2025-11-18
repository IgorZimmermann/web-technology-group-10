@extends('layouts.base')

@section('title', 'TenFlix')

@push('styles')
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="/css/watchlist.css">
@endpush

@section('body')
    <nav class="navbar">
        <div class="navbar-wrapper">
            <div class="navbar-link-wrapper">
                <a href="">home</a>
            </div>
            <div>
                <span>logo here</span>
            </div>
            <div class="navbar-link-wrapper">
                @auth{{--  todo: implement a better logout --}}
                    <span>{{ Auth::user()->name }}</span>
                    <form method="POST" action="/logout"  style="display: inline;">
                        @csrf
                        <button type="submit"
                            style="background: none; border: none; color: inherit; cursor: pointer; text-decoration: underline;">Logout</button>
                    </form>
                @else
                    <a href="/login">login</a>
                @endauth
            </div>
        </div>
    </nav>
    <main class="content-wrapper">
        <div class="content"></div>

        <h2 style="text-align: center; margin: 50px 0;"> Top 10 Movies </h2>
        <iframe src="/topten_slider.html" width="100%" height="600" style="border:none;"></iframe>

        <!-- BROWSE GRID -->
        <section class="section" aria-labelledby="browse-title">
        <div id="pageHeader">
            <a href="/index.html">Home</a>
            <h1 id="browse-title" style="text-align: center;">Browse</h1>
        </div>

        <div class="movie-grid">
            @foreach($movies as $movie)
            <div class="movie-card" data-title="{{ $movie->title }}">
                <img src="https://image.tmdb.org/t/p/original{{ $movie->poster_path }}" alt="{{ $movie->title }} poster">
                <span class="heart" aria-label="Add {{ $movie->title }} to watchlist">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                    d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z"/>
                </svg>
                </span>
            </div>
            @endforeach
        </div>
        </section>

        <!-- WATCHLIST SECTION -->
        <section class="section" aria-labelledby="watchlist-title">
        <h1 id="watchlist-title">Watchlist</h1>
        <div id="watchList">
            <p id="emptyMsg">No movies yet</p>
        </div>
        </section>
  </main>
@endsection

@push('scripts')
    <script src="/js/script.js" defer></script>
@endpush
