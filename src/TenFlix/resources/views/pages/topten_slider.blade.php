@extends('layouts.base')

@section('title','Top 10 Movies')

@push('styles')
    <link rel="stylesheet" href="/css/topten.css">
@endpush

@section('body')
	<div class="menu">
		@foreach($movies->take(10) as $movie)
			<div
				class="menu-item movie-card"
				{{-- data elements are stored to be able to use for js for the modal box / pop up --}}
				data-tmdb-id="{{ $movie->tmdb_id }}"
				data-title="{{ $movie->title }}"
				data-overview="{{ e($movie->overview) }}"
				data-release-date="{{ $movie->release_date }}"
				data-rating="{{ $movie->vote_average }}"
				data-vote-count="{{ $movie->vote_count }}"
				data-poster="{{ $movie->poster_path ? 'https://image.tmdb.org/t/p/original'.$movie->poster_path : '' }}"
			>
				<img src="https://image.tmdb.org/t/p/original{{ $movie->poster_path }}" alt="{{ $movie->title }} - #{{ $loop->iteration }}">
			</div>
		@endforeach
	</div>
@endsection

@push('scripts')
    <script src="/js/topten.js"></script>
    <script src="/js/movie-modal.js" defer></script>
@endpush
