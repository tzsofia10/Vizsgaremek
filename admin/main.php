<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require '../connect.php';

// Szarvasmarhák számának lekérdezése
$cows_count_query = "SELECT COUNT(*) as total FROM cows";
$cows_count_result = $dbconn->query($cows_count_query);
$cows_count = $cows_count_result->fetch_assoc()['total'];

// Színek számának lekérdezése
$articles_count_query = "SELECT COUNT(*) as total FROM news";
$articles_count_result = $dbconn->query($articles_count_query);
$articles_count = $articles_count_result->fetch_assoc()['total'];

// Utolsó 5 hozzáadott szarvasmarha
$latest_cows_query = "SELECT ear_tag, birthdate, colors.colors as color 
                     FROM cows 
                     LEFT JOIN colors ON cows.color_id = colors.id 
                     ORDER BY cows.id DESC 
                     LIMIT 5";
$latest_cows_result = $dbconn->query($latest_cows_query);

$page_title = "Főoldal";
$custom_js = ["../js/translate.js"];
$custom_css = ["../css/pages/main.css"];
include '../main/head.php';
?>

<body>
    <?php include '../main/nav.php'; ?>
    
    <main>
        <div class="welcome-section">
            <h1>Üdvözöljük!</h1>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <img src="../cowPicture/cow-face-front.svg" alt="">
              
                </div>
                <div class="stat-info">
                    <h3>Összes szarvasmarha</h3>
                    <p><?php echo $cows_count; ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                  <img src="../cowPicture/article.svg" alt="">
                </div>
                <div class="stat-info">
                    <h3>Cikkek</h3>
                    <p><?php echo $articles_count; ?></p>
                </div>
            </div>
        </div>

        <div class="quick-actions">
            <h2>Gyors műveletek</h2>
            <div class="action-buttons">
                <a href="newcow.php" class="action-button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                    </svg>
                    <span>Új szarvasmarha</span>
                </a>

                <a href="farm_states.php" class="action-button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z"/>
                    </svg>
                    <span>Teljes lista</span>
                </a>

                <a href="farm_states.php" class="action-button">
                    <img src="..\cowPicture\\cow-silhouette-icon-character-free-png.png" width="55px" id alt="">
                    <span>Lefoglalt szarvasmarhák</span>
                </a>
            </div>
        </div>

        <div class="latest-additions fade-in">
            <h2>Utolsó hozzáadott szarvasmarhák</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Fülszám</th>
                            <th>Szín</th>
                            <th>Születési dátum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($cow = $latest_cows_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cow['ear_tag']); ?></td>
                            <td class="color"><?php echo htmlspecialchars($cow['color']); ?></td>
                            <td><?php echo htmlspecialchars($cow['birthdate']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <button id="backToTop">⬆ Fel az elejére</button>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const backToTopButton = document.getElementById("backToTop");

    window.addEventListener("scroll", function () {
        if (window.scrollY > 300) {
            backToTopButton.style.display = "block";
        } else {
            backToTopButton.style.display = "none";
        }
    });

    backToTopButton.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
});

    </script>
    <footer>
        <?php include '../main/footer.php'; ?>
    </footer>
</body>
</html> 