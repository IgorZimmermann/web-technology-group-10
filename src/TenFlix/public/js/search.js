// Simple Search Implementation
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('searchInput');
  const searchResults = document.getElementById('searchResults');
  let searchTimeout;

  if (!searchInput) return;

  const performSearch = async (query) => {
    if (query.length < 2) {
      searchResults.style.display = 'none';
      return;
    }

    try {
      const response = await fetch(`/api/search?q=${encodeURIComponent(query)}`);
      const movies = await response.json();

      if (movies.length === 0) {
        searchResults.innerHTML = '<div style="padding: 15px; text-align: center; color: #999;">No movies found</div>';
        searchResults.style.display = 'block';
        return;
      }


      searchResults.innerHTML = movies.map(movie => {
        const poster = movie.poster_path ? `https://image.tmdb.org/t/p/w92${movie.poster_path}` : 'https://via.placeholder.com/92x138?text=No+Image';
        return `
        <div class="search-result-item"
          data-id="${movie.tmdb_id}"
          data-title="${movie.title}"
          data-poster="${movie.poster_path || ''}"
          data-release="${movie.release_date || 'N/A'}"
          data-genre="${movie.genre || 'N/A'}"
          data-overview="${(movie.overview || 'No overview available').replace(/"/g, '&quot;')}"
          data-rating="${movie.vote_average || 'N/A'}"
          data-votes="${movie.vote_count || '0'}"
          style="padding: 12px 15px; border-bottom: 1px solid #eee; cursor: pointer; display: flex; align-items: flex-start; gap: 12px; transition: background-color 0.15s; color: #333;">
          <img src="${poster}"
            alt="${movie.title}"
            style="width: 46px; height: 70px; object-fit: cover; border-radius: 4px; flex: 0 0 auto;">
          <div style="flex: 1; min-width: 0; margin-top: 2px;">
            <div style="font-weight: 600; font-size: 14px; line-height: 1.3; color: #1a1a1a; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; word-wrap: break-word;">${movie.title}</div>
            <div style="font-size: 12px; color: #777; margin-top: 4px;">${movie.release_date || 'N/A'}</div>
          </div>
        </div>
      `;
      }).join('');

      searchResults.style.display = 'block';

      document.querySelectorAll('.search-result-item').forEach(item => {
        item.addEventListener('click', () => {
          const movieData = {
                        id: item.dataset.id,
            title: item.dataset.title,
            poster: item.dataset.poster,
            releaseDate: item.dataset.release,
            genre: item.dataset.genre,
            overview: item.dataset.overview,
            rating: item.dataset.rating,
            voteCount: item.dataset.votes,
          };
          if (window.openMovieModal) {
            window.openMovieModal(movieData);
          } else {
            console.warn('openMovieModal not available. Make sure movie-modal.js is loaded first.');
          }
          searchResults.style.display = 'none';
          searchInput.value = '';
        });
        item.addEventListener('mouseover', () => { item.style.backgroundColor = '#f5f5f5'; });
        item.addEventListener('mouseout', () => { item.style.backgroundColor = 'transparent'; });
      });
    } catch (error) {
      console.error('Search error:', error);
      searchResults.innerHTML = '<div style="padding: 15px; text-align: center; color: #999;">Error searching movies</div>';
      searchResults.style.display = 'block';
    }
  };

  searchInput.addEventListener('input', (e) => {
    clearTimeout(searchTimeout);
    const query = e.target.value.trim();
    searchTimeout = setTimeout(() => performSearch(query), 300);
  });

  // Close search results when clicking outside
  document.addEventListener('click', (e) => {
    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
      searchResults.style.display = 'none';
    }
  });

  // Allow keyboard navigation in search results
  searchInput.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      searchResults.style.display = 'none';
      searchInput.value = '';
    }
  });
});
