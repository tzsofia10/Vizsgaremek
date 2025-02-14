function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    const main = document.querySelector('main');

    // Ha a menü már látszik, elrejtjük
    if (navLinks.style.display === 'flex') {
        navLinks.style.display = 'none';
        main.classList.remove('menu-open'); // Visszahúzza a <main>-t
    } else {
        navLinks.style.display = 'flex';
        main.classList.add('menu-open'); // Letolja a <main>-t
    }
}


window.addEventListener('resize', () => {
    const navLinks = document.querySelector('.nav-links');
    const main = document.querySelector('main');
    if (window.innerWidth > 768) {
        navLinks.style.display = 'flex'; 
        main.classList.remove('menu-open');
    } else {
        navLinks.style.display = 'none'; 
    }
});


window.addEventListener('load', () => {
    if (window.innerWidth <= 768) {
        // Alapértelmezetten telefonos nézetben rejtve legyen a menü
        document.querySelector('.nav-links').style.display = 'none';
    }
});