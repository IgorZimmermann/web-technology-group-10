<nav class="navbar">
    <div class="navbar-wrapper">
        @if (Request::is('*login*') || Request::is('*signup*'))
            <div class="navbar-center-only">
                <a class="navbar-logo" href="/">
                    <img src="/img/logo.png" class="logo">
                </a>
            </div>
        @else
            <div class="navbar-link-wrapper">
                <a class="navbar-logo" href="/">
                    <img src="/img/logo.png" class="logo">
                </a>
                @auth
                    @if (Auth::user()->is_admin)
                        <a class="navbar-oval-btn" href="/admin">admin</a>
                    @endif
                @endauth
            </div>

            {{-- search bar only on home --}}
            @if (Request::is('/') || Request::routeIs('home'))
                <div class="navbar-link-wrapper navbar-center">
                    <input type="text" id="searchInput" placeholder="Search movies...">
                    <div id="searchResults" class="searchResult"></div>
                </div>
            @endif

            <div class="navbar-link-wrapper">
                <a href="/watchlist" class="navbar-oval-btn">Watchlist</a>
                <a href="/watched" class="navbar-oval-btn">Seen</a>

                @auth
                    <span class="navbar-username">{{ Auth::user()->name }}</span>
                    <form method="POST" action="/logout" class="navbar-oval-btn navbar-logout-form">
                        @csrf
                        <button type="submit">logout</button>
                    </form>
                @else
                    <a href="/login" class="navbar-oval-btn">login</a>
                @endauth
            </div>
        @endif
    </div>
</nav>
