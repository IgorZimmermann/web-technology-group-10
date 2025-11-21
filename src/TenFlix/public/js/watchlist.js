const watchlistButtons = document.querySelectorAll(".watchlist-button");

watchlistButtons.forEach((button, i) => {
    if (button.hasAttribute("data-id")) {
        button.addEventListener("click", async () => {
            await fetch("/watchlist", {
                body: JSON.stringify({
                    id: button.getAttribute("data-id"),
                }),
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            });
        });
    }
});

const watchedButtons = document.querySelectorAll(".watched-button");

watchedButtons.forEach((button, i) => {
    if (button.hasAttribute("data-id")) {
        button.addEventListener("click", async () => {
            await fetch("/watched", {
                body: JSON.stringify({
                    id: button.getAttribute("data-id"),
                }),
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            });
        });
    }
});
