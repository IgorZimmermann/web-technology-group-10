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
                @auth
                    @if (Auth::user()->is_admin)
                        <a href="/admin">admin</a>
                    @endif
                @endauth
            </div>
            <div>
                <span>logo here</span>
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
        <!-- HERO / FEATURED -->
        <div class="content" style="background-image: url('/img/dune.jpg')">
            <div class="meta-gradient">
                <div class="meta-wrapper">
                    <div class="meta-title" style="background-image: url('/img/dune_logo.png')"></div>
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
                <!-- Each movie has a "movie-card" class -->
                <div class="movie-card" data-title="Inception">
                    <img src="https://m.media-amazon.com/images/I/51zUbui+gbL._AC_.jpg" alt="Inception poster">
                    <!-- Heart class creates watchlist function / heart image -->
                    <span class="heart" aria-label="Add Inception to watchlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z" />
                        </svg>
                    </span>
                </div>

                <div class="movie-card" data-title="Interstellar">
                    <img src="https://image.tmdb.org/t/p/w440_and_h660_face/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg"
                        alt="Interstellar poster">
                    <span class="heart" aria-label="Add Interstellar to watchlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z" />
                        </svg>
                    </span>
                </div>

                <div class="movie-card" data-title="Revenge of the Sith">
                    <img src="https://www.themoviedb.org/t/p/w1280/xfSAoBEm9MNBjmlNcDYLvLSMlnq.jpg"
                        alt="Star Wars: Revenge of the Sith poster">
                    <span class="heart" aria-label="Add Revenge of the Sith to watchlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z" />
                        </svg>
                    </span>
                </div>

                <div class="movie-card" data-title="Monsters Inc">
                    <img src="https://www.themoviedb.org/t/p/w1280/wFSpyMsp7H0ttERbxY7Trlv8xry.jpg"
                        alt="Monsters Inc poster">
                    <span class="heart" aria-label="Add Monsters Inc to watchlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z" />
                        </svg>
                    </span>
                </div>

                <div class="movie-card" data-title="Demolition">
                    <img src="https://www.themoviedb.org/t/p/w1280/4t56LZ1KbOOxgKfqMKN6truBDVc.jpg" alt="Demolition poster">
                    <span class="heart" aria-label="Add Demolition to watchlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z" />
                        </svg>
                    </span>
                </div>

                <div class="movie-card" data-title="The Thing">
                    <img src="https://www.themoviedb.org/t/p/w1280/tzGY49kseSE9QAKk47uuDGwnSCu.jpg" alt="The Thing poster">
                    <span class="heart" aria-label="Add The Thing to watchlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z" />
                        </svg>
                    </span>
                </div>

                <div class="movie-card" data-title="Casino Royale">
                    <img src="https://www.themoviedb.org/t/p/w1280/lMrxYKKhd4lqRzwUHAy5gcx9PSO.jpg"
                        alt="Casino Royale poster">
                    <span class="heart" aria-label="Add Casino Royale to watchlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z" />
                        </svg>
                    </span>
                </div>

                <div class="movie-card" data-title="Batman Begins">
                    <img src="https://www.themoviedb.org/t/p/w1280/sPX89Td70IDDjVr85jdSBb4rWGr.jpg"
                        alt="Batman Begins poster">
                    <span class="heart" aria-label="Add Batman Begins to watchlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z" />
                        </svg>
                    </span>
                </div>

                <div class="movie-card" data-title="Dune Part II">
                    <img src="https://www.themoviedb.org/t/p/w1280/1pdfLvkbY9ohJlCjQH2CZjjYVvJ.jpg"
                        alt="Dune Part II poster">
                    <span class="heart" aria-label="Add Dune Part II to watchlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z" />
                        </svg>
                    </span>
                </div>

                <div class="movie-card" data-title="Heat">
                    <img src="https://www.themoviedb.org/t/p/w1280/umSVjVdbVwtx5ryCA2QXL44Durm.jpg" alt="Heat poster">
                    <span class="heart" aria-label="Add Heat to watchlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z" />
                        </svg>
                    </span>
                </div>

                <div class="movie-card" data-title="Trainspotting">
                    <img src="https://www.themoviedb.org/t/p/w1280/1jUC02qsqS2NxBMFarbIhcQtazV.jpg"
                        alt="Trainspotting poster">
                    <span class="heart" aria-label="Add Trainspotting to watchlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z" />
                        </svg>
                    </span>
                </div>

                <div class="movie-card" data-title="Shrek the Halls">
                    <img src="https://www.themoviedb.org/t/p/w1280/zeqUbXA0JPSlyAHdRTgxoYgK24n.jpg"
                        alt="Shrek the Halls poster">
                    <span class="heart" aria-label="Add Shrek the Halls to watchlist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.648 3.159c1.89-1.848 4.953-1.848 6.843 0 1.89 1.847 1.89 4.84 0 6.688l-7.07 6.908a.75.75 0 0 1-1.042 0l-7.07-6.908c-1.89-1.848-1.89-4.84 0-6.688 1.89-1.848 4.953-1.848 6.843 0l.748.731.748-.731z" />
                        </svg>
                    </span>
                </div>
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
