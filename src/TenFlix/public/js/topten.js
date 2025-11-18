const menu = document.querySelector('.menu');

if (menu) {
  menu.addEventListener('wheel', (e) => {
    e.preventDefault();
    menu.scrollBy({ left: e.deltaY, behavior: 'smooth' });
  }, { passive: false });
}

const isEmbedded = window.self !== window.top;

if (isEmbedded && window.parent) {
  document.addEventListener('click', (event) => {
    const card = event.target.closest('.movie-card');
    // checks if the heart icon is clicked
    if (!card || event.target.closest('.heart')) return;

    // helps with framing issues
    event.preventDefault();
    event.stopPropagation();

    // convert html data-* attribute into js data
    const payload = { ...card.dataset };

    // this sends back the payload to the main page where the modal is
    window.parent.postMessage({ 
      // opens the modal in the main page with the payload
      type: 'movie-modal:open', payload 
      },
      window.location.origin
    );
  });
}
