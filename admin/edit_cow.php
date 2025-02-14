<?php
session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require '../connect.php'; // Adatbázis kapcsolat betöltése

$cow_id = $_GET['id'] ?? null;
if (!$cow_id || !is_numeric($cow_id)) {
    echo "<p>Érvénytelen azonosító.</p>";
    exit();
}

// A tehén adatainak lekérdezése
$stmt = $dbconn->prepare("SELECT * FROM cows WHERE id = ?");
$stmt->bind_param('i', $cow_id);
$stmt->execute();
$result = $stmt->get_result();
$cow = $result->fetch_assoc();
$stmt->close();

if (!$cow) {
    echo "<p>A tehén nem található.</p>";
    exit();
}

// Színek lekérdezése
$colorsResult = $dbconn->query("SELECT id, colors AS color FROM colors");
$colors = [];
if ($colorsResult->num_rows > 0) {
    while ($row = $colorsResult->fetch_assoc()) {
        $colors[] = $row;
    }
}

// Módosítás kezelése
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ear_tag = $_POST['ear_tag'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $mother_ear_tag = $_POST['mother_ear_tag'] ?? '';
    $father_ear_tag = $_POST['father_ear_tag'] ?? '';
    $color_id = $_POST['color_id'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';

    $updateStmt = $dbconn->prepare(
        "UPDATE cows SET ear_tag = ?, gender = ?, mother_ear_tag = ?, father_ear_tag = ?, color_id = ?, birthdate = ? WHERE id = ?"
    );
    $updateStmt->bind_param('ssssisi', $ear_tag, $gender, $mother_ear_tag, $father_ear_tag, $color_id, $birthdate, $cow_id);

    if ($updateStmt->execute()) {
        echo "<p>A tehén adatai sikeresen frissítve!</p>";
    } else {
        echo "<p>Hiba történt a módosítás közben: " . $dbconn->error . "</p>";
    }

    $updateStmt->close();
    // Frissített adatok újratöltése
    header("Location: farm_states.php");
    exit();
}

$dbconn->close();
?>

<!DOCTYPE html>
<html lang="hu">
 <!-- <head> része-->
 <?php 
    $page_title = "Módosítás"; 
    $custom_css = ["../css/pages/editcow.css"]; // egyedi css fájl hozzáadása
    $custom_js = ["../js/translate2.js","https://cdn.jsdelivr.net/npm/sweetalert2@11"]; // egyedi js fájlok
    include '../main/head.php'; 
?>
<!-- </head> rész vége-->

<body>
    <header>
        <?php include "../main/nav.php";?>
    </header>
    
    <main>
        <h1>Szarvasmarha Módosítása</h1>
        <form method="POST">
            <label for="ear_tag">Füljelző:</label>
            <input type="text" id="ear_tag" name="ear_tag" value="<?php echo htmlspecialchars($cow['ear_tag']); ?>" required>
            <br>
    
            <label for="gender">Nem:</label>
            <select id="gender" name="gender" required>
                <option value="M" <?php echo $cow['gender'] === 'M' ? 'selected' : ''; ?>>Hím</option>
                <option value="F" <?php echo $cow['gender'] === 'F' ? 'selected' : ''; ?>>Nőstény</option>
            </select>
            <br>
    
            <label for="mother_ear_tag">Anya Füljelzője:</label>
            <input type="text" id="mother_ear_tag" name="mother_ear_tag" value="<?php echo htmlspecialchars($cow['mother_ear_tag']); ?>">
            <br>
    
            <label for="father_ear_tag">Apa Füljelzője:</label>
            <input type="text" id="father_ear_tag" name="father_ear_tag" value="<?php echo htmlspecialchars($cow['father_ear_tag']); ?>">
            <br>
    
            <label for="color_id">Szín:</label>
            <select id="color_id" name="color_id" required>
                <?php foreach ($colors as $color): ?>
                    <option value="<?php echo $color['id']; ?>" <?php echo $cow['color_id'] == $color['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($color['color']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>
    
            <label for="birthdate">Szuletési Dátum:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($cow['birthdate']); ?>" required>
            <br>
    
            <button class="button" type="submit">Módosítás</button>
            <button class="button" type="submit"><a href="farm_states.php">Vissza a listához</a></button>
        </form>
    </main>

    <footer>
        <?php include '../main/footer.php'; ?>
    </footer>
</body>
</html>
