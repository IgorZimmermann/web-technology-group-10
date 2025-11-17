document.addEventListener("DOMContentLoaded", () => {
  const topTenContainer = document.getElementById("top-ten-management");
  const allMoviesContainer = document.getElementById("all-movies-grid");
  const addMovieBtn = document.getElementById("add-movie-btn");
  const newMovieTitleInput = document.getElementById("new-movie-title");
  const newMoviePosterInput = document.getElementById("new-movie-poster");

  let movies = [];
  let topTen = [];

  // Fetch data from db.json
  async function fetchData() {
    try {
      const response = await fetch("db.json");
      const data = await response.json();
      movies = data.movies;
      topTen = data.top_ten;
      renderTopTen();
      renderAllMovies();
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  function renderTopTen() {
    topTenContainer.innerHTML = "";
    topTen.forEach((title, index) => {
      const movie = movies.find((m) => m.title === title);
      if (movie) {
        const movieEl = document.createElement("div");
        movieEl.classList.add("movie-card");
        movieEl.innerHTML = `
          <img src="${movie.posterUrl}" alt="${movie.title}">
          <span>${index + 1}. ${movie.title}</span>
          <div class="order-buttons">
            <button onclick="moveTopTen(${index}, -1)" ${
          index === 0 ? "disabled" : ""
        }>▲</button>
            <button onclick="moveTopTen(${index}, 1)" ${
          index === topTen.length - 1 ? "disabled" : ""
        }>▼</button>
            <button class="remove-from-top-ten" onclick="toggleTopTen('${
              movie.title
            }')">Remove</button>
          </div>
        `;
        topTenContainer.appendChild(movieEl);
      }
    });
    renderAllMovies(); // Re-render all movies to update their top-ten status
  }

  function renderAllMovies() {
    allMoviesContainer.innerHTML = "";
    movies.forEach((movie) => {
      const movieEl = document.createElement("div");
      movieEl.classList.add("movie-card");
      movieEl.dataset.title = movie.title;

      const isTopTen = topTen.includes(movie.title);
      const canAdd = topTen.length < 10;

      let topTenButton = "";
      if (isTopTen) {
        topTenButton = `<button class="toggle-top-ten-btn" onclick="toggleTopTen('${movie.title}')">Remove from Top 10</button>`;
      } else if (canAdd) {
        topTenButton = `<button class="toggle-top-ten-btn" onclick="toggleTopTen('${movie.title}')">Add to Top 10</button>`;
      } else {
        topTenButton = `<button class="toggle-top-ten-btn" disabled>Top 10 Full</button>`;
      }

      movieEl.innerHTML = `
        <img src="${movie.posterUrl}" alt="${movie.title}">
        <button class="remove-btn" onclick="removeMovie('${movie.title}')">X</button>
        <div class="movie-card-btns">
          ${topTenButton}
        </div>
      `;
      allMoviesContainer.appendChild(movieEl);
    });
  }

  window.toggleTopTen = function (title) {
    const index = topTen.indexOf(title);
    if (index > -1) {
      // remove from top ten
      topTen.splice(index, 1);
    } else {
      // add to top ten
      if (topTen.length < 10) {
        topTen.push(title);
      } else {
        alert(
          "The Top 10 list is full. Please remove a movie before adding a new one."
        );
      }
    }
    renderTopTen();
    updateDB();
  };

  window.moveTopTen = function (index, direction) {
    if (index + direction < 0 || index + direction >= topTen.length) return;
    const [item] = topTen.splice(index, 1);
    topTen.splice(index + direction, 0, item);
    renderTopTen();
    updateDB();
  };

  window.removeMovie = function (title) {
    movies = movies.filter((movie) => movie.title !== title);
    topTen = topTen.filter((t) => t !== title);
    renderAllMovies();
    renderTopTen();
    updateDB();
  };

  addMovieBtn.addEventListener("click", () => {
    const title = newMovieTitleInput.value.trim();
    const posterUrl = newMoviePosterInput.value.trim();
    if (title && posterUrl && !movies.some((m) => m.title === title)) {
      movies.push({ title, posterUrl });
      renderAllMovies();
      updateDB();
      newMovieTitleInput.value = "";
      newMoviePosterInput.value = "";
    } else {
      alert("Please provide a unique title and a poster URL.");
    }
  });

  function updateDB() {
  }

  fetchData();
});
