@extends('layouts.base')

@section('title','Top 10 Movies')

@push('styles')
    <link rel="stylesheet" href="/css/topten.css">
@endpush

@section('body')
	<div class="menu">
		@foreach($movies->take(10) as $movie)
			<div class="menu-item">
				<img src="https://image.tmdb.org/t/p/original{{ $movie->poster_path }}" alt="{{ $movie->title }} - #{{ $loop->iteration }}">
			</div>
		@endforeach
	</div>
@endsection

@push('scripts')
    <script src="/js/topten.js"></script>
@endpush
