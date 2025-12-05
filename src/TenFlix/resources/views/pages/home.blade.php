@extends('layouts.base')

@section('title', 'TenFlix')

@push('styles')
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="/css/watchlist.css">
    <link rel="stylesheet" href="/css/modal.css">
    <link rel="stylesheet" href="/css/topten.css">
@endpush

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('body')
    <main class="content-wrapper">
      
        <div class="content" style="background-image: url('{{ $bannerMovie->poster_path ? 'https://image.tmdb.org/t/p/original'.$bannerMovie->poster_path : '' }}')">
            <div class="meta-wrapper">
                <h2 class="meta-title-text">{{ $bannerMovie->title }}</h2>
                <p class="meta-tagline">{{ $bannerMovie->overview }}</p>
            </div>
            <div class="meta-gradient"></div>
        </div>

        {{-- TOP 10 --}}
        <x-movie-section title="Top 10 Movies" id="top-ten-title" :movies="$topMovies" wrapperClass="menu"/>

        {{-- BROWSE --}}
        <x-movie-section title="Browse" id="browse-title" :movies="$movies" wrapperClass="movie-grid"/>

        {{-- ACTION --}}
        <x-movie-section title="Action" id="action-title" :movies="$actionMovies" wrapperClass="movie-grid"/>

        {{-- THRILLER --}}
        <x-movie-section title="Thriller" id="thriller-title" :movies="$thrillerMovies" wrapperClass="movie-grid"/>

        {{-- CRIME --}}
        <x-movie-section title="Crime" id="crime-title" :movies="$crimeMovies" wrapperClass="movie-grid"/>
    </main>
@endsection

@push('scripts')
    <script src="/js/script.js" defer></script>
    <script src="/js/movie-modal.js" defer></script>
    <script src="/js/search.js" defer></script>
    <script src="/js/watchlist.js" defer></script>
    <script src="/js/topten.js" defer></script>
@endpush
