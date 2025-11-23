@extends('layouts.base')

@section('title', 'Admin - TenFlix')

@push('styles')
    <link rel="stylesheet" href="/css/admin.css" />
    <link rel="stylesheet" href="/css/modal.css">
@endpush

@section('body')
    <main class="content-wrapper">
      <h1>Admin Panel</h1>

      <section class="section">
        <div class="section-header">
          <h2>Manage Top 10 Movies</h2>
          <button id="reset-top-ten-btn" class="reset-btn">Reset to Default</button>
        </div>
        <div id="top-ten-management">
        </div>
      </section>

      <section class="section">
        <h2>Manage All Movies</h2>
        <div id="movie-management">
          <div class="add-movie-form">
            <h3>Add New Movie</h3>
            <input type="number" id="new-movie-tmdb-id" placeholder="TMDB ID" />
            <button id="add-movie-btn">Add Movie</button>
          </div>
          <div class="movie-grid" id="all-movies-grid">
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
