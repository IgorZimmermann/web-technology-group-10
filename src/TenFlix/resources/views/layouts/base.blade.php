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
    @include('layouts._navbar')
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
