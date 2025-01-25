document.addEventListener("DOMContentLoaded", () => {
    const deleteLinks = document.querySelectorAll("a[href*='delete_cow.php']");
    const confirmOverlay = document.getElementById("confirmOverlay");
    const confirmYes = document.getElementById("confirmYes");
    const confirmNo = document.getElementById("confirmNo");

    let currentLink = null;

    deleteLinks.forEach(link => {
        link.addEventListener("click", (event) => {
            event.preventDefault(); // Megakadályozza az alapértelmezett viselkedést
            currentLink = link; // Elmentjük a linket
            confirmOverlay.style.display = "flex"; // Megjelenítjük a megerősítő ablakot
        });
    });

    confirmYes.addEventListener("click", () => {
        if (currentLink) {
            window.location.href = currentLink.href; // Követjük a linket
        }
    });

    confirmNo.addEventListener("click", () => {
        confirmOverlay.style.display = "none"; // Elrejtjük az ablakot
    });
});
