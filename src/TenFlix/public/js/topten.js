const menu = document.querySelector('.menu');

if (menu) {
  menu.addEventListener('wheel', (e) => {
    e.preventDefault();
    menu.scrollBy({ left: e.deltaY, behavior: 'smooth' });
  }, { passive: false });
}
