let slideIndex = 0;

function showSlides() {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    // Az összes kép elrejtése
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }

    // Index növelése, ha elérte a maximumot, újraindul
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1; }

    // Aktuális kép megjelenítése
    slides[slideIndex - 1].style.display = "block";  

    // Pontok aktív állapotának frissítése
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    dots[slideIndex - 1].className += " active";

    // Automatikus lapozás 3 másodpercenként
    setTimeout(showSlides, 3000);
}

// Indítsa el a diavetítést az oldal betöltésekor
document.addEventListener("DOMContentLoaded", showSlides);
