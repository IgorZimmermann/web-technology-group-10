<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <!-- allows for dynamic viewing -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title','TenFlix')</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap">
  <link rel="stylesheet" href="/css/modal.css">
  @stack('styles')

  @yield('head')
</head>

<body>
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
                @if (Request::is('/'))
                    <div class="navbar-link-wrapper navbar-center">
                        <input type="text" id="searchInput" placeholder="Search movies...">
                        <div id="searchResults" class="searchResult"></div>
                    </div>
                @endif
                <div class="navbar-link-wrapper">
                    <a href="/watchlist" class="navbar-oval-btn">Watchlist</a>
                <div class="navbar-link-wrapper">
                <div class="navbar-link-wrapper">
                    <a href="/watched" class="navbar-oval-btn">Seen</a>
                <div class="navbar-link-wrapper">
                    @auth
                        <span style="color:#c95360">{{ Auth::user()->name }}</span>
                        <form method="POST" action="/logout" class="navbar-oval-btn" style="display: inline; margin: 0;">
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
  @yield('body')
  <!-- modal class that covers the page -->
  <div class="modal" id="movieModal">
  <!-- overlay that darkens the rest of the screen -->
  <div class="modal-backdrop" data-modal-close></div>

  <!-- model box -->
  <section class="modal-content">
    <button class="modal-close" type="button" data-modal-close>&times;</button>
    <img data-modal-poster class="modal-poster" src="" alt="">
    <h2 data-modal-title class="modal-title"></h2>
      <p data-modal-release class="modal-meta"></p>
      <p data-modal-genre class="modal-meta"></p>
      <p data-modal-rating class="modal-meta"></p>
      <p data-modal-votes class="modal-meta"></p>
      <p data-modal-overview class="modal-overview"></p>
    <button data-modal-watchlist class="modal-watchlist" type="button">Add to Watchlist</button>
  </section>
</div>

  @stack('scripts')
</body>
</html>
