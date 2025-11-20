document.addEventListener("DOMContentLoaded", () => {
  const topTenContainer = document.getElementById("top-ten-management");
  const allMoviesContainer = document.getElementById("all-movies-grid");
  const addMovieBtn = document.getElementById("add-movie-btn");
  const newMovieTitleInput = document.getElementById("new-movie-title");
  const newMoviePosterInput = document.getElementById("new-movie-poster");

  let movies = [];
  let topTen = [];

  function fetchData() {
    try {
      movies = window.moviesData || [];
      
      const topTenMovies = window.topTenMoviesData || [];
      topTen = topTenMovies.map(movie => movie.id);
      
      renderTopTen();
      renderAllMovies();
    } catch (error) {
      console.error("Error loading data:", error);
    }
  }

  function renderTopTen() {
    topTenContainer.innerHTML = "";
    topTen.forEach((movieId, index) => {
      const movie = movies.find((m) => m.id === movieId);
      if (movie) {
        const movieEl = document.createElement("div");
        movieEl.classList.add("movie-card");
        const posterUrl = movie.poster_path ? `https://image.tmdb.org/t/p/w500${movie.poster_path}` : movie.posterUrl || '';
        movieEl.innerHTML = `
          <img src="${posterUrl}" alt="${movie.title}">
          <span>${index + 1}. ${movie.title}</span>
          <div class="order-buttons">
            <button onclick="moveTopTen(${index}, -1)" ${
          index === 0 ? "disabled" : ""
        }>▲</button>
            <button onclick="moveTopTen(${index}, 1)" ${
          index === topTen.length - 1 ? "disabled" : ""
        }>▼</button>
            <button class="remove-from-top-ten" onclick="toggleTopTen(${movie.id})">Remove</button>
          </div>
        `;
        topTenContainer.appendChild(movieEl);
      }
    });
    renderAllMovies();
  }

  function renderAllMovies() {
    allMoviesContainer.innerHTML = "";
    movies.forEach((movie) => {
      const movieEl = document.createElement("div");
      movieEl.classList.add("movie-card");
      movieEl.dataset.title = movie.title;
      movieEl.dataset.id = movie.id;

      const isTopTen = topTen.includes(movie.id);
      const canAdd = topTen.length < 10;

      let topTenButton = "";
      if (isTopTen) {
        topTenButton = `<button class="toggle-top-ten-btn" onclick="toggleTopTen(${movie.id})">Remove from Top 10</button>`;
      } else if (canAdd) {
        topTenButton = `<button class="toggle-top-ten-btn" onclick="toggleTopTen(${movie.id})">Add to Top 10</button>`;
      } else {
        topTenButton = `<button class="toggle-top-ten-btn" disabled>Top 10 Full</button>`;
      }

      const posterUrl = movie.poster_path ? `https://image.tmdb.org/t/p/w500${movie.poster_path}` : movie.posterUrl || '';
      movieEl.innerHTML = `
        <img src="${posterUrl}" alt="${movie.title}">
        <button class="remove-btn" onclick="removeMovie(${movie.id})">X</button>
        <div class="movie-card-btns">
          ${topTenButton}
        </div>
      `;
      allMoviesContainer.appendChild(movieEl);
    });
  }

  window.toggleTopTen = function (movieId) {
    const index = topTen.indexOf(movieId);
    if (index > -1) {
      topTen.splice(index, 1);
    } else {
      if (topTen.length < 10) {
        topTen.push(movieId);
      } else {
        alert(
          "The Top 10 list is full. Please remove a movie before adding a new one."
        );
        return;
      }
    }
    renderTopTen();
    saveTopTenToDatabase();
  };

  window.moveTopTen = function (index, direction) {
    if (index + direction < 0 || index + direction >= topTen.length) return;
    const [item] = topTen.splice(index, 1);
    topTen.splice(index + direction, 0, item);
    renderTopTen();
    saveTopTenToDatabase();
  };

  window.removeMovie = async function (movieId) {
    if (confirm('Are you sure you want to remove this movie?')) {
      try {
        const response = await fetch(`/api/movies/${movieId}`, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
          }
        });
        
        const data = await response.json();
        
        if (data.success) {
          movies = movies.filter((movie) => movie.id !== movieId);
          topTen = topTen.filter((id) => id !== movieId);
          renderAllMovies();
          renderTopTen();
          if (topTen.length > 0) {
            await saveTopTenToDatabase();
          }
          console.log('Movie deleted successfully');
        } else {
          alert('Failed to delete movie: ' + data.message);
        }
      } catch (error) {
        console.error('Error deleting movie:', error);
        alert('Error deleting movie. Please try again.');
      }
    }
  };

  addMovieBtn.addEventListener("click", async () => {
    const title = newMovieTitleInput.value.trim();
    const posterUrl = newMoviePosterInput.value.trim();
    
    if (title && posterUrl && !movies.some((m) => m.title === title)) {
      try {
        const response = await fetch('/api/movies', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
          },
          body: JSON.stringify({
            title: title,
            poster_path: posterUrl,
            overview: '',
            release_date: new Date().toISOString().split('T')[0],
            vote_average: 0,
            vote_count: 0
          })
        });
        
        const data = await response.json();
        
        if (data.success) {
          movies.push(data.data);
          renderAllMovies();
          newMovieTitleInput.value = "";
          newMoviePosterInput.value = "";
          console.log('Movie added successfully');
        } else {
          alert('Failed to add movie: ' + data.message);
        }
      } catch (error) {
        console.error('Error adding movie:', error);
        alert('Error adding movie. Please try again.');
      }
    } else {
      alert("Please provide a unique title and a poster URL.");
    }
  });

  async function saveTopTenToDatabase() {
    try {
      const response = await fetch('/api/top-ten', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({ movieIds: topTen })
      });
      
      const data = await response.json();
      
      if (!data.success) {
        console.error('Failed to save top 10:', data.message);
        alert('Failed to save changes: ' + data.message);
      } else {
        console.log('Top 10 saved successfully');
      }
    } catch (error) {
      console.error('Error saving top 10:', error);
      alert('Error saving changes. Please try again.');
    }
  }

  fetchData();
});
