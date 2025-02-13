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
        <div class="button-container">
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

<!-- hamburger element e -->
<script>
    function toggleMenu() {
        const navLinks = document.querySelector('.nav-links');
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
            }
</script>