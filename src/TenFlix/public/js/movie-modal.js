// runs this code afte rthe
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("movieModal");
    if (!modal) return;

    // finds all the <div> in base.blade.php, matches the first element with that name
    const titleEl = modal.querySelector("[data-modal-title]");
    const posterEl = modal.querySelector("[data-modal-poster]");
    const releaseEl = modal.querySelector("[data-modal-release]");
    const genreEl = modal.querySelector("[data-modal-genre]");
    const ratingEl = modal.querySelector("[data-modal-rating]");
    const votesEl = modal.querySelector("[data-modal-votes]");
    const overviewEl = modal.querySelector("[data-modal-overview]");
    const watchlistBtn = modal.querySelector("[data-modal-watchlist]");

    let activeCard = null;
    let currentMovieId = null;
    let isInWatchlist = false;

    // get the heart of the activeCard
    const getSourceHeart = () => activeCard?.querySelector(".heart") || null;

    // helper method to toggle the 'Remove / Add to Watchlist' funcitonality
    const syncWatchlistButton = () => {
        // prevents crashing if it does not exist
        if (!watchlistBtn) return;
        const sourceHeart = getSourceHeart();
        const isActive = sourceHeart
            ? sourceHeart.classList.contains("active")
            : isInWatchlist;
        // if its active toggle the button
        watchlistBtn.classList.toggle("is-active", isActive);
        // change the text
        watchlistBtn.textContent = isActive
            ? "Remove from Watchlist"
            : "Add to Watchlist";
    };

    // helper method to populate the Modal Box
    const populateModal = (data = {}) => {
        const {
            title,
            overview,
            releaseDate,
            rating,
            voteCount,
            poster,
            genre,
        } = data;
        titleEl.textContent = title || "Untitled";

        // poster may already be a full URL or a TMDB path
        posterEl.src = poster
            ? poster.startsWith("http")
                ? poster
                : `https://image.tmdb.org/t/p/original${poster}`
            : "";
        posterEl.alt = `${title || "Movie"} poster`;
        posterEl.style.display = "block";

        releaseEl.textContent = releaseDate
            ? `Released: ${releaseDate}`
            : "Release date unavailable";
        genreEl.textContent = genre ? `Genres: ${genre}` : "Genres unavailable";
        ratingEl.textContent = rating
            ? `Rating: ${Number(rating).toFixed(1)}/10`
            : "Rating unavailable";
        votesEl.textContent = voteCount
            ? `Votes: ${Number(voteCount).toLocaleString()}`
            : "Votes unavailable";
        overviewEl.textContent = overview || "No overview available.";
    };

    // Helper methods to help with opening / closing the model

    // edits the css to show
    const showModal = () => {
        modal.classList.add("is-visible");
        syncWatchlistButton();
    };

    // edits the css to close and clear active card
    const closeModal = () => {
        modal.classList.remove("is-visible");
        activeCard = null;
        currentMovieId = null;
        isInWatchlist = false;
        syncWatchlistButton();
    };

    // match clicked card to active card
    const openModalFromCard = (card) => {
        activeCard = card;
        populateModal({ ...card.dataset });
        showModal();
    };

    // create an event listener for close button
    modal.querySelectorAll("[data-modal-close]").forEach((trigger) => {
        trigger.addEventListener("click", closeModal);
    });

    // toggle activeCard by calling .click() function
    if (watchlistBtn) {
        watchlistBtn.addEventListener("click", async () => {
            if (activeCard) {
                const sourceHeart = getSourceHeart();
                if (sourceHeart) {
                    sourceHeart.click();
                    syncWatchlistButton();
                }
                return;
            }

            if (!currentMovieId) return;

            try {
                const response = await fetch("/watchlist", {
                    body: JSON.stringify({ id: currentMovieId }),
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                });

                if (response.ok) {
                    isInWatchlist = !isInWatchlist;
                    syncWatchlistButton();

                    const matchingHearts = document.querySelectorAll(
                        `[data-id="${currentMovieId}"]`
                    );
                    matchingHearts.forEach((heart) => {
                        if (isInWatchlist) {
                            heart.classList.add("active");
                            const card = heart.closest(".movie-card");
                            if (card) {
                                const title = card.getAttribute("data-title");
                                const watchList =
                                    document.getElementById("watchList");
                                if (
                                    watchList &&
                                    !watchList.querySelector(
                                        `[data-title="${title}"]`
                                    )
                                ) {
                                    const clone = card.cloneNode(true);
                                    clone.querySelector(".heart")?.remove();
                                    clone.classList.remove("menu-item");
                                    watchList.appendChild(clone);
                                }
                            }
                        } else {
                            heart.classList.remove("active");
                            const card = heart.closest(".movie-card");
                            if (card) {
                                const title = card.getAttribute("data-title");
                                const watchList =
                                    document.getElementById("watchList");
                                const removedMovie = watchList?.querySelector(
                                    `[data-title="${title}"]`
                                );
                                if (removedMovie) removedMovie.remove();
                            }
                        }
                    });

                    const emptyMsg = document.getElementById("emptyMsg");
                    if (emptyMsg) {
                        const watchList = document.getElementById("watchList");
                        const hasMovies =
                            watchList?.querySelector(".movie-card");
                        emptyMsg.style.display = hasMovies ? "none" : "block";
                    }
                }
            } catch (error) {
                console.error("Error toggling watchlist:", error);
            }
        });
    }

    // opens a model check if its either movie card
    document.addEventListener("click", (event) => {
        const card = event.target.closest(".movie-card");
        // if its the heart it does nothing / does not open model
        if (
            !card ||
            event.target.closest(".heart") ||
            event.target.closest(".tick")
        )
            return;
        openModalFromCard(card);
    });

    window.openMovieModal = async (movieData) => {
        currentMovieId = movieData.id || null;
        const data = {
            title: movieData.title,
            poster: movieData.poster,
            releaseDate: movieData.releaseDate || movieData.release,
            genre: movieData.genre,
            overview: movieData.overview,
            rating: movieData.rating,
            voteCount: movieData.voteCount,
        };
        populateModal(data);

        if (currentMovieId) {
            try {
                const response = await fetch(
                    "/api/watchlist-status?id=" + currentMovieId
                );
                if (response.ok) {
                    const result = await response.json();
                    isInWatchlist = result.inWatchlist || false;
                } else {
                    isInWatchlist = false;
                }
            } catch (error) {
                console.error("Error checking watchlist status:", error);
                isInWatchlist = false;
            }
        } else {
            isInWatchlist = false;
        }

        showModal();
    };
});
