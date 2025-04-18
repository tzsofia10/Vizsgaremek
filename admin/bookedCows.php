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
$sql = "SELECT cows.*, 
               customer.name AS customer_name, 
               customer.phone_number AS customer_phone, 
               customer.street AS customer_street, 
               customer.house_number AS customer_house_number, 
               settlements.postal_code AS customer_postal_code, 
               settlements.town AS customer_town, 
               colors.colors AS color_name
        FROM sales
        JOIN cows ON sales.cows_id = cows.id
        JOIN customer ON sales.customer_id = customer.id
        JOIN settlements ON customer.settlements_id = settlements.id
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

</head>
<?php 
    $page_title = "Foglalások"; 
    $custom_css = ["../css/pages/bookedCow.css"];
    $additional_head = "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>"; 
    include '../main/head.php'; 
?>
<body >
<div class="wrapper">
    <?php include '../main/nav.php'; ?>
    <h1>Foglalások</h1>
    <main>
        <div class="card-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="cards">
                    <p><strong>Foglaló neve:</strong> <?php echo htmlspecialchars($row['customer_name'] ?? 'Ismeretlen'); ?></p>
                    <p><strong>Telefonszám:</strong> <?php echo htmlspecialchars($row['customer_phone'] ?? 'Nincs megadva'); ?></p>
                    <p><strong>Cím:</strong> 
                    <?php 
                        echo htmlspecialchars($row['customer_postal_code'] ?? ''); 
                        echo ' ';
                        echo htmlspecialchars($row['customer_town'] ?? 'Nincs megadva'); 
                        echo ', <br>';
                        echo htmlspecialchars($row['customer_street'] ?? 'Nincs megadva'); 
                        echo ' ';
                        echo htmlspecialchars($row['customer_house_number'] ?? '');
                    ?>
                </p>


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
    </main>
    <footer>
        <?php include '../main/footer.php'; ?>
    </footer>
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
