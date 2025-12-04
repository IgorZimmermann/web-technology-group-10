const watchlistButtons = document.querySelectorAll(".watchlist-button");

watchlistButtons.forEach((button, i) => {
    if (button.hasAttribute("data-id")) {
        button.addEventListener("click", async () => {
            const response = await fetch("/watchlist", {
                body: JSON.stringify({
                    id: button.getAttribute("data-id"),
                }),
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            });

            try {
                const result = await response.json();
                if (result.status === "added") {
                    button.classList.add("active");
                } else if (result.status === "removed") {
                    button.classList.remove("active");
                }
            } catch (error) {
                console.error("Failed to toggle watchlist:", error);
            }
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
