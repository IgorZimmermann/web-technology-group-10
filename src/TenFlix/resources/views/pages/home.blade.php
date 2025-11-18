@extends('layouts.base')

@section('title','TenFlix')

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
        <a href="/login.html">login</a>
      </div>
    </div>
  </nav>

  <main class="content-wrapper">
    <!-- HERO / FEATURED -->
    <div class="content" style="background-image: url('/img/dune.jpg')">
      <div class="meta-gradient">
        <div class="meta-wrapper">
          <div
            class="meta-title"
            style="background-image: url('/img/dune_logo.png')"
          ></div>
          <p class="meta-tagline">
            Feature adaptation of the novel about the son of a noble family
            entrusted with the protection of the most valuable.
          </p>
          <div class="meta-button-wrapper">
            <a class="meta-button">Add to Watchlist</a>
          </div>
        </div>
      </div>
    </div>

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
          <div
            class="movie-card"
            {{-- data elements are stored to be able to use for js for the modal box / pop up --}}
            data-tmdb-id="{{ $movie->tmdb_id }}"
            data-title="{{ $movie->title }}"
            data-overview="{{ e($movie->overview) }}"
            data-release-date="{{ $movie->release_date }}"
            data-rating="{{ $movie->vote_average }}"
            data-vote-count="{{ $movie->vote_count }}"
            data-poster="{{ $movie->poster_path ? 'https://image.tmdb.org/t/p/original'.$movie->poster_path : '' }}"
          >
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
  <script src="/js/movie-modal.js" defer></script>
@endpush
