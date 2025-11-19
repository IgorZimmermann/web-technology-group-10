@extends('layouts.base')

@section('title', 'Admin - TenFlix')

@push('styles')
    <link rel="stylesheet" href="/css/admin.css" />
@endpush

@section('body')
    <nav class="navbar">
      <div class="navbar-wrapper">
        <div class="navbar-link-wrapper">
          <a href="{{ route('home') }}">home</a>
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
      <h1>Admin Panel</h1>

      <section class="section">
        <h2>Manage Top 10 Movies</h2>
        <div id="top-ten-management">
          <!-- Top 10 movies will be loaded here -->
        </div>
      </section>

      <section class="section">
        <h2>Manage All Movies</h2>
        <div id="movie-management">
          <div class="add-movie-form">
            <h3>Add New Movie</h3>
            <input type="text" id="new-movie-title" placeholder="Movie Title" />
            <input type="text" id="new-movie-poster" placeholder="Poster URL" />
            <button id="add-movie-btn">Add Movie</button>
          </div>
          <div class="movie-grid" id="all-movies-grid">
            <!-- All movies will be loaded here -->
          </div>
        </div>
      </section>
    </main>
@endsection

@push('scripts')
    <script>
        window.moviesData = @json($movies);
        window.topTenMoviesData = @json($topTenMovies);
    </script>
    <script src="{{ asset('js/admin.js') }}"></script>
@endpush
