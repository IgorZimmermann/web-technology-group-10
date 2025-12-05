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
            <x-movie-section :title="$listTitle" id="top-ten-title" :movies="$movies" wrapperClass="menu"/>

    </main>
@endsection

@push('scripts')
    <script src="/js/watchlist.js" defer></script>
    <script src="/js/movie-modal.js" defer></script>
    <script src="/js/topten.js" defer></script>
@endpush
