const watchlistButtons = document.querySelectorAll(".watchlist-button");

const sendToggle = async (url, tmdbId) => {
    const response = await fetch(url, {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name=\"csrf-token\"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ id: tmdbId }),
    });

    if (!response.ok) {
        throw new Error(`Request failed: ${response.status}`);
    }

    return response.json();
};

watchlistButtons.forEach((button) => {
    if (!button.hasAttribute("data-id")) return;

    button.addEventListener("click", async () => {
        try {
            const result = await sendToggle("/watchlist", button.getAttribute("data-id"));
            if (result.status === "added") {
                button.classList.add("active");
            } else if (result.status === "removed") {
                button.classList.remove("active");
            }
        } catch (error) {
            console.error("Failed to toggle watchlist:", error);
        }
    });
});

const watchedButtons = document.querySelectorAll(".watched-button");

watchedButtons.forEach((button) => {
    if (!button.hasAttribute("data-id")) return;

    button.addEventListener("click", async () => {
        try {
            await sendToggle("/watched", button.getAttribute("data-id"));
            button.classList.toggle("active");
        } catch (error) {
            console.error("Failed to toggle watched:", error);
        }
    });
});
