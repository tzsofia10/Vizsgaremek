function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    const main = document.querySelector('main');
    const hamburger = document.querySelector('.hamburger');

    // Ha a menü már látszik, elrejtjük
    if (navLinks.classList.contains('show')) {
        navLinks.classList.remove('show');
        main.classList.remove('menu-open');
        hamburger.classList.remove('active');
    } else {
        navLinks.classList.add('show');
        main.classList.add('menu-open');
        hamburger.classList.add('active');
    }
}

window.addEventListener('resize', () => {
    const navLinks = document.querySelector('.nav-links');
    const main = document.querySelector('main');
    const hamburger = document.querySelector('.hamburger');
    
    if (window.innerWidth > 768) {
        navLinks.classList.remove('show');
        main.classList.remove('menu-open');
        hamburger.classList.remove('active');
    } else {
        navLinks.classList.remove('show');
        main.classList.remove('menu-open');
        hamburger.classList.remove('active');
    }
});

window.addEventListener('load', () => {
    if (window.innerWidth <= 768) {
        const navLinks = document.querySelector('.nav-links');
        const main = document.querySelector('main');
        const hamburger = document.querySelector('.hamburger');
        
        navLinks.classList.remove('show');
        main.classList.remove('menu-open');
        hamburger.classList.remove('active');
    }
});