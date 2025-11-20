<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title','TenFlix')</title>

  <!-- Fonts (moved here so every page has it) -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />

  <!-- Page-level CSS slots -->
  @stack('styles')

  @yield('head')
</head>
<body>
  @yield('body')

  <!-- Page-level JS slots -->
  @stack('scripts')
</body>
</html>
