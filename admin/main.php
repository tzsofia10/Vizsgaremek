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
$colors_count_query = "SELECT COUNT(*) as total FROM colors";
$colors_count_result = $dbconn->query($colors_count_query);
$colors_count = $colors_count_result->fetch_assoc()['total'];

// Utolsó 5 hozzáadott szarvasmarha
$latest_cows_query = "SELECT ear_tag, birthdate, colors.colors as color 
                     FROM cows 
                     LEFT JOIN colors ON cows.color_id = colors.id 
                     ORDER BY cows.id DESC 
                     LIMIT 5";
$latest_cows_result = $dbconn->query($latest_cows_query);

$page_title = "Főoldal";
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                        <path d="M480 48c0-26.5-21.5-48-48-48H336c-26.5 0-48 21.5-48 48V96H224V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V96H112V24c0-13.3-10.7-24-24-24S64 10.7 64 24V96H48C21.5 96 0 117.5 0 144v96V464c0 26.5 21.5 48 48 48H96h64H432h64h48c26.5 0 48-21.5 48-48V240 144c0-26.5-21.5-48-48-48H480V48zM176 192H464V432H176V192zM96 432H48V240H96V432zM592 432H544V240h48V432z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h3>Összes szarvasmarha</h3>
                    <p><?php echo $cows_count; ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M204.3 5C104.9 24.4 24.8 104.3 5.2 203.4c-37 187 131.7 326.4 258.8 306.7C372.9 496.5 504 411.4 504 288c0-123.7-100.3-224-224-224zm101.5 277.8c-4.5 4.5-10.6 7-17 7s-12.5-2.5-17-7L256 209.3l-5.5 5.5c-4.5 4.5-10.6 7-17 7s-12.5-2.5-17-7c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h3>Elérhető színek</h3>
                    <p><?php echo $colors_count; ?></p>
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
            </div>
        </div>

        <div class="latest-additions">
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

    <footer>
        <?php include '../main/footer.php'; ?>
    </footer>
</body>
</html> 