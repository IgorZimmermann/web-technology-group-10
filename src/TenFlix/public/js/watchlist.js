const watchlistButtons = document.querySelectorAll(".watchlist-button");

watchlistButtons.forEach((button, i) => {
    if (button.hasAttribute("data-id")) {
        button.addEventListener("click", async () => {
            await fetch("/watchlist", {
                body: {
                    id: button.getAttribute("data-id"),
                },
                method: "POST",
                credentials: "include",
            });
        });
    }
});
