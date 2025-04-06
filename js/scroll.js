document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM betöltve");
    const backToTopButton = document.getElementById("scrollTopBtn");

    window.addEventListener("scroll", function () {
        console.log("scroll js meghívva");
        if (window.scrollY > 300) {
            console.log("Gomb megjelenítése");
            backToTopButton.style.display = "inline-block";  // Használj inline-block-ot, ha block nem működik
            // A gomb megjelenítése
        } else {
            console.log("Gomb eltüntetése");
            backToTopButton.style.display = "none"; // A gomb eltüntetése
        }
    });

    backToTopButton.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
});
