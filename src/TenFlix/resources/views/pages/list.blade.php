@extends('layouts.base')

@section('title', 'TenFlix')

@push('styles')
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="/css/watchlist.css">
    <link rel="stylesheet" href="/css/topten.css">
@endpush

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('body')
    <nav class="navbar">
        <div class="navbar-wrapper">
            <div class="navbar-link-wrapper">
                <a href="">home</a>
                @auth
                    @if (Auth::user()->is_admin)
                        <a href="/admin">admin</a>
                    @endif
                @endauth
            </div>
            <div>
                <img src="/img/logo.png" class="logo">
            </div>
            <div class="navbar-link-wrapper">
                @auth
                    <span>{{ Auth::user()->name }}</span>
                    <form method="POST" action="/logout" style="display: inline; margin: 0;">
                        @csrf
                        <button type="submit">logout</button>
                    </form>
                @else
                    <a href="/login">login</a>
                @endauth
            </div>
        </div>
    </nav>
    <main class="content-wrapper">
        <section class="section" aria-labelledby="top-ten-title">
            <h2 id="top-ten-title" style="text-align: center; margin: 50px 0;">{{$listTitle}}</h2>
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
                </div>
                @endforeach
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="/js/watchlist.js" defer></script>
@endpush
