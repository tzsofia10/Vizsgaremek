<nav>
    <div class="logo-container">
        <img src="../cowPicture/logo.png" alt="Logo">
    </div>
    <div class="nav-links">
        <div class="links">
            <?php
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === false) {
                // Ha nincs bejelentkezve, jelenjenek meg a linkek
                echo '<a href="../main/index.php">Főoldal</a>';
                echo '<a href="../index.php">Napi bejegyzések</a>';
                echo '<a href="#statisztikak">Statisztikák</a>';
            }
            else {
                echo '<a href="list.php">Cikkek listája</a>';
                echo '<a href="farm_states.php">Farm állománya</a>';
                echo '<a href="newcow.php">Új tehén hozzáadása</a>';
            }
            ?>
        </div>
        
        <div class="button-container" id="buttonContainer">
            <?php
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                // Ha be van jelentkezve, csak az admin linkek jelenjenek meg
                echo '<button><a href="logout.php">Kijelentkezés</a></button>';
            } else {
                // Ha nincs bejelentkezve, jelenjen meg a "Bejelentkezés" gomb
                echo '<button><a href="../admin/index.php">Bejelentkezés</a>
                    <div class="arrow-wrapper">
                        <div class="arrow"></div>
                    </div>
                </button>';
            }
            ?>
        </div>
    </div>
    <div class="hamburger" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>
</nav>
