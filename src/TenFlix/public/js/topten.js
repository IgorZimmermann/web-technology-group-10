document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".scroll-container").forEach(container => {
    const leftBtn = container.querySelector(".scroll-btn-left");
    const rightBtn = container.querySelector(".scroll-btn-right");
    const grid = container.querySelector(".movie-grid, .menu");

    if (leftBtn && grid) {
      leftBtn.addEventListener("click", () => {
        grid.scrollBy({ left: -300, behavior: "smooth" });
      });
    }

    if (rightBtn && grid) {
      rightBtn.addEventListener("click", () => {
        grid.scrollBy({ left: 300, behavior: "smooth" });
      });
    }
  });
});
