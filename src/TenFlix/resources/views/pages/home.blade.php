@extends('layouts.base')

@section('title', 'TenFlix')

@push('styles')
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="/css/watchlist.css">
    <link rel="stylesheet" href="/css/modal.css">
@endpush

@section('body')
    <nav class="navbar">
        <div class="navbar-wrapper">
            <div class="navbar-link-wrapper">
                <a href="">home</a>
            </div>
            <!-- SEARCH BAR IN NAVBAR -->
            <div style="position: relative; flex: 1; max-width: 300px;">
                <input type="text" id="searchInput" placeholder="Search movies..."
                    style="width: 100%; padding: 8px 12px; font-size: 14px; border: 1px solid #ddd; border-radius: 6px; outline: none; transition: border-color 0.3s;">
                <div id="searchResults" style="position: absolute; width: 100%; top: 100%; left: 0; margin-top: 5px; background: white; border: 1px solid #ddd; border-radius: 6px; max-height: 400px; overflow-y: auto; display: none; z-index: 100; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"></div>
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

  <!-- MOVIE MODAL -->
  <div id="movieModal" class="modal">
    <div class="modal-backdrop"></div>
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" data-modal-title>Movie Title</h2>
        <button class="modal-close" data-modal-close>×</button>
      </div>
      <img class="modal-poster" data-modal-poster src="" alt="Movie poster">
      <div class="modal-meta">
        <div data-modal-release>Release date</div>
        <div data-modal-genre>Genre</div>
        <div data-modal-rating>Rating</div>
        <div data-modal-votes>Votes</div>
      </div>
      <p class="modal-overview" data-modal-overview>Overview text</p>
      <button class="modal-watchlist" data-modal-watchlist>Add to Watchlist</button>
    </div>
  </div>
@endsection

@push('scripts')
    <script src="/js/script.js" defer></script>
    <script src="/js/movie-modal.js" defer></script>
    <script src="/js/search.js" defer></script>
@endpush
