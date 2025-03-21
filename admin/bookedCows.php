<?php
session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}
require "../connect.php";

// Ellenőrizzük az adatbáziskapcsolatot
if (!$dbconn) {
    die("Kapcsolódási hiba: " . mysqli_connect_error());
}

// SQL lekérdezés a foglalt (status = 1) tehenekre
$sql = "SELECT cows.*, customer.name AS customer_name, customer.phone_number AS customer_phone, colors.colors AS color_name
        FROM sales
        JOIN cows ON sales.cows_id = cows.id
        JOIN customer ON sales.customer_id = customer.id
        JOIN colors ON cows.color_id = colors.id
        WHERE sales.sale_status = 1";

$result = $dbconn->query($sql);

// Ha hiba van az SQL-ben, írjuk ki
if (!$result) {
    die("SQL hiba: " . $dbconn->error);
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foglalások</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            width: 250px;
            text-align: center;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <h1>Foglalások</h1>
    <div class="container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                <p><strong>Foglaló neve:</strong> <?php echo htmlspecialchars($row['customer_name'] ?? 'Ismeretlen'); ?></p>
                <p><strong>Telefonszám:</strong> <?php echo htmlspecialchars($row['customer_phone'] ?? 'Nincs megadva'); ?></p>
                    <h2><?php echo htmlspecialchars($row['ear_tag'] ?? 'Név nélküli tehén'); ?></h2>
                    
                    <?php 
                    // Életkor kiszámítása
                    if (!empty($row['birthdate'])) {
                        $birthDateObj = new DateTime($row['birthdate']);
                        $today = new DateTime();
                        $age = $today->diff($birthDateObj)->y;
                    } else {
                        $age = "Ismeretlen";
                    }
                    ?>
                    <p><strong>Kora:</strong> <?php echo $age; ?> év</p>
                    <p><strong>Szín:</strong> <span class="color-name"><?php echo htmlspecialchars($row['color_name'] ?? 'Ismeretlen szín'); ?></span></p>

                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nincsenek foglalt tehenek.</p>
        <?php endif; ?>
    </div>
<script>
    const colorTranslations = {
    'Black': 'Fekete',
    'Brown': 'Barna',
    'White': 'Fehér',
    'Spotted': 'Foltos'
};

function translateColors() {
    // Fordítás az összes <p> vagy más HTML elemben
    document.querySelectorAll('.color-name').forEach(element => {
        const englishColor = element.textContent.trim();
        if (colorTranslations[englishColor]) {
            element.textContent = colorTranslations[englishColor];
        }
    });

    // Fordítás <option> elemekben is (ha van select mező)
    document.querySelectorAll('option').forEach(option => {
        const englishColor = option.textContent.trim();
        if (colorTranslations[englishColor]) {
            option.textContent = colorTranslations[englishColor];
        }
    });
}

// Fordítás az oldal betöltésekor
window.addEventListener('DOMContentLoaded', translateColors);

</script>
</body>
</html>
