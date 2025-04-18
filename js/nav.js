function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    const main = document.querySelector('main');
    const hamburger = document.querySelector('.hamburger');
    
    console.log('Menu toggled');  // Debug üzenet
    
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
