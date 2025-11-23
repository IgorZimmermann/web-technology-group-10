@extends('layouts.base')

@section('title', 'TenFlix')

@push('styles')
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="/css/watchlist.css">
    <link rel="stylesheet" href="/css/topten.css">
    <link rel="stylesheet" href="/css/modal.css">
@endpush

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('body')
    <main class="content-wrapper">
        <section class="section" aria-labelledby="top-ten-title">
            <h1 id="top-ten-title" style="text-align: center; margin: 50px 0;">{{$listTitle}}</h1>
            <div class="scroll-container">
            <button class="scroll-btn scroll-btn-left">&lt;</button>
                <div class="menu">
                    @foreach($movies as $movie)
                    <div
                        class="menu-item movie-card"
                        {{-- data elements are stored to be able to use for js for the modal box / pop up --}}
                        data-tmdb-id="{{ $movie->tmdb_id }}"
                        data-title="{{ $movie->title }}"
                        data-overview="{{ e($movie->overview) }}"
                        data-release-date="{{ $movie->release_date }}"
                        data-rating="{{ $movie->vote_average }}"
                        data-vote-count="{{ $movie->vote_count }}"
                        data-genre="{{ e($movie->genre) }}"
                        data-poster="{{ $movie->poster_path ? 'https://image.tmdb.org/t/p/original'.$movie->poster_path : '' }}"
                    >
                        <img src="https://image.tmdb.org/t/p/original{{ $movie->poster_path }}" alt="{{ $movie->title }} - #{{ $loop->iteration }}">
                        <span class="heart watchlist-button" aria-label="Add {{ $movie->title }} to watchlist" data-id="{{ $movie->tmdb_id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z"/>
                            </svg>
                        </span>
                        <span class="tick watched-button" aria-label="Add {{ $movie->title }} to watchlist" data-id="{{ $movie->tmdb_id }}">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.89163 13.2687L9.16582 17.5427L18.7085 8" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    @endforeach
                </div>
                <button class="scroll-btn scroll-btn-right">&gt;</button>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="/js/watchlist.js" defer></script>
    <script src="/js/movie-modal.js" defer></script>
    <script src="/js/topten.js" defer></script>
@endpush
