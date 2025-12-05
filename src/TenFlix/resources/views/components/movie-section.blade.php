@props([
    'title',
    'movies',
    'id' => null,            // e.g. 'browse-title'
    'wrapperClass' => 'movie-grid', // or 'menu'
])

<section class="section" {{ $id ? "aria-labelledby=$id" : '' }}>
    <h2 id="{{ $id }}" class="section-title">{{ $title }}</h2>

    <div class="scroll-container">
        <button class="scroll-btn scroll-btn-left">&lt;</button>
        <div class="{{ $wrapperClass }}">
            @foreach ($movies as $movie)
                <x-movie-card :movie="$movie"
                              :wrapper-class="$wrapperClass === 'menu' ? 'menu-item movie-card' : 'movie-card'" />
            @endforeach
        </div>
        <button class="scroll-btn scroll-btn-right">&gt;</button>
    </div>
</section>
