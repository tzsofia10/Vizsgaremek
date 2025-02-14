<nav>
    <div class="logo-container">
        <img src="../cowPicture/logo.png" alt="Logo">
    </div>
    <div class="nav-links">
        <div class="links">
            <a href="../main/index.php">Főoldal</a>
            <a href="../index.php">Napi bejegyzések</a>
            <a href="#statisztikak">Statisztikák</a>
        </div>
        
        <div class="button-container" id="buttonContainer">
            <button>
                <a href="../admin/index.php">Bejelentkezés</a>
                <div class="arrow-wrapper">
                    <div class="arrow"></div>
                </div>
            </button>
        </div>
    </div>
    <div class="hamburger" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>
</nav>

<script>
    function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    const main = document.querySelector('main');

    if (navLinks.style.display === 'flex') {
        navLinks.style.display = 'none';
        main.classList.remove('menu-open'); // Visszahúzza a <main>-t
    } else {
        navLinks.style.display = 'flex';
        main.classList.add('menu-open'); // Letolja a <main>-t
    }
}

// Ha az ablak mérete visszavált nagy képernyőre, visszaállítjuk a <main>-t
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        document.querySelector('.nav-links').style.display = 'flex';
        document.querySelector('main').classList.remove('menu-open');
    } else {
        document.querySelector('.nav-links').style.display = 'none';
    }
});

</script>
