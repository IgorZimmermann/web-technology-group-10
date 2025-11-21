// runs this code after the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('movieModal');
  if (!modal) return;

  // finds all the <div> in base.blade.php, matches the first element with that name
  const titleEl = modal.querySelector('[data-modal-title]');
  const posterEl = modal.querySelector('[data-modal-poster]');
  const releaseEl = modal.querySelector('[data-modal-release]');
  const genreEl = modal.querySelector('[data-modal-genre]');
  const ratingEl = modal.querySelector('[data-modal-rating]');
  const votesEl = modal.querySelector('[data-modal-votes]');
  const overviewEl = modal.querySelector('[data-modal-overview]');
  const watchlistBtn = modal.querySelector('[data-modal-watchlist]');

  let activeCard = null;

  // get the heart of the activeCard
  const getSourceHeart = () => activeCard?.querySelector('.heart') || null;

  // helper method to toggle the 'Remove / Add to Watchlist' functionality
  const syncWatchlistButton = () => {
    // prevents crashing if it does not exist
    if (!watchlistBtn) return;
    const sourceHeart = getSourceHeart();
    const isActive = !!sourceHeart?.classList.contains('active');
    // if its active toggle the button
    watchlistBtn.classList.toggle('is-active', isActive);
    // change the text
    watchlistBtn.textContent = isActive ? 'Remove from Watchlist' : 'Add to Watchlist';
  };

  // helper method to populate the Modal Box
  const populateModal = (data = {}) => {
    const { title, overview, releaseDate, rating, voteCount, poster, genre } = data;
    titleEl.textContent = title || 'Untitled';

    // poster may already be a full URL or a TMDB path
    posterEl.src = poster ? (poster.startsWith('http') ? poster : `https://image.tmdb.org/t/p/original${poster}`) : '';
    posterEl.alt = `${title || 'Movie'} poster`;
    posterEl.style.display = 'block';

    releaseEl.textContent = releaseDate ? `Released: ${releaseDate}` : 'Release date unavailable';
    genreEl.textContent = genre ? `Genres: ${genre}` : 'Genres unavailable';
    ratingEl.textContent = rating ? `Rating: ${Number(rating).toFixed(1)}/10` : 'Rating unavailable';
    votesEl.textContent = voteCount ? `Votes: ${Number(voteCount).toLocaleString()}` : 'Votes unavailable';
    overviewEl.textContent = overview || 'No overview available.';
  };

  // Helper methods to help with opening / closing the modal

  // edits the css to show
  const showModal = () => {
    modal.classList.add('is-visible');
    syncWatchlistButton();
  };

  // edits the css to close and clear active card
  const closeModal = () => {
    modal.classList.remove('is-visible');
    activeCard = null;
    syncWatchlistButton();
  };

  // match clicked card to active card
  const openModalFromCard = (card) => {
    activeCard = card;
    populateModal({ ...card.dataset });
    showModal();
  };

  // expose a simple global helper so other scripts (search) can open the modal
  // without creating DOM movie-card elements. Accepts the same fields as
  // populateModal: { title, overview, releaseDate, rating, voteCount, poster, genre }
  window.openMovieModal = (data = {}) => {
    // ensure activeCard is null so watchlist sync doesn't rely on a card
    activeCard = null;
    populateModal(data);
    showModal();
  };

  // create an event listener for close button
  modal.querySelectorAll('[data-modal-close]').forEach((trigger) => {
    trigger.addEventListener('click', closeModal);
  });

  // toggle activeCard by calling .click() function
  if (watchlistBtn) {
    watchlistBtn.addEventListener('click', () => {
      if (!activeCard) return;
      const sourceHeart = getSourceHeart();
      if (sourceHeart) {
        sourceHeart.click();
        syncWatchlistButton();
      }
    });
  }

  // opens a modal check if its either movie card
  document.addEventListener('click', (event) => {
    const card = event.target.closest('.movie-card');
    // if its the heart it does nothing / does not open modal
    if (!card || event.target.closest('.heart')) return;
    openModalFromCard(card);
  });

});
