const watchList = document.getElementById('watchList');
const emptyMsg = document.getElementById('emptyMsg');

// gets all the hear and loops over each one of them in an array
document.querySelectorAll('.heart').forEach(heart => {
    heart.addEventListener('click', e => {
        const card = heart.closest('.movie-card');
        const title = card.getAttribute('data-title');

        // If clicked for the second time
        if (heart.classList.contains('active')) {
        // Remove from watchlist
        heart.classList.remove('active');
        const removedMovie = watchList.querySelector(`[data-title="${title}"]`);
        if (removedMovie) removedMovie.remove();
        } else {
        // Add to watchlist
        heart.classList.add('active');
        //Clones it in the script called clone
        const clone = card.cloneNode(true);
        clone.querySelector('.heart').remove();
        // Appends to watch list
        watchList.appendChild(clone);
        }

        updateEmptyMsg(); // check state after each action
    });
});

updateEmptyMsg();


function updateEmptyMsg() {
    const hasMovies = watchList.querySelector('.movie-card');
    // changes <p> display based if there is movies
    emptyMsg.style.display = hasMovies ? 'none' : 'block';
}
