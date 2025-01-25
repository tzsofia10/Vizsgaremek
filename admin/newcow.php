<?php
session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Ha nincs bejelentkezve, irányítsuk át a bejelentkezési oldalra
    header("Location: index.php");
    exit();
}

require '../connect.php'; 
// Ha az űrlapot elküldték
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ear_tag = $_POST['ear_tag'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $mother_ear_tag = $_POST['mother_ear_tag'] ?? '';
    $father_ear_tag = $_POST['father_ear_tag'] ?? '';
    $color_id = $_POST['color_id'] ?? '';
    $birth_date = $_POST['birth_date'] ?? '';
    $picture_path = ''; // Alapértelmezett kép elérési út

    // Ha van kép feltöltve
    if (!empty($_FILES['picture']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['picture']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Bizonyos fájlformátumok engedélyezése
        $allowed_formats = ['jpg', 'jpeg', 'png'];
        if (in_array($imageFileType, $allowed_formats)) {
            if (move_uploaded_file($_FILES['picture']['tmp_name'], $target_file)) {
                $picture_path = $target_file; // Útvonal frissítése
            } else {
                echo "<p>Hiba történt a kép feltöltésekor.</p>";
            }
        } else {
            echo "<p>Csak JPG, JPEG, vagy PNG fájlok tölthetők fel.</p>";
        }
    }

    // Adatok beszúrása az adatbázisba
    if ($stmt = $dbconn->prepare("INSERT INTO cows (ear_tag, gender, mother_ear_tag, father_ear_tag, color_id, birth_date, picture) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
        $stmt->bind_param('ssssiss', $ear_tag, $gender, $mother_ear_tag, $father_ear_tag, $color_id, $birth_date, $picture_path);
        if ($stmt->execute()) {
            echo "<p>Új tehén sikeresen hozzáadva!</p>";
        } else {
            echo "<p>Hiba történt: " . $stmt->error . "</p>";
        }
        $stmt->close(); // Lekérdezés lezárása
    } else {
        echo "<p>SQL hiba: " . $dbconn->error . "</p>";
    }
}

// Színek lekérdezése az adatbázisból
$colorsResult = $dbconn->query("SELECT id, COALESCE(black, brown, white, spotted) AS color FROM colors");
$colors = [];
if ($colorsResult->num_rows > 0) {
    while ($row = $colorsResult->fetch_assoc()) {
        $colors[] = $row;
    }
}


$dbconn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <script src="../js/translate.js"></script>
    <link rel="stylesheet" href="../css/newcow.css">
    <title>Új tehén hozzáadása</title>
</head>
<body>
    <h1>Új tehén hozzáadása</h1>
    <div class="container">
        <form method="POST">
            <label for="ear_tag">Füljelző:</label>
            <input type="text" id="ear_tag" name="ear_tag" required>
            <br>
    
            <label for="gender">Nem:</label>
            <select id="gender" name="gender" required>
                <option value="">Válassz nemet</option>
                <option value="M">Hím</option>
                <option value="F">Nőstény</option>
            </select>
            <br>
    
            <label for="mother_ear_tag">Anya füljelzője:</label>
            <input type="text" id="mother_ear_tag" name="mother_ear_tag">
            <br>
    
            <label for="father_ear_tag">Apa füljelzője:</label>
            <input type="text" id="father_ear_tag" name="father_ear_tag">
            <br>
    
            <label for="color_id">Szín:</label>
            <select id="color_id" name="color_id" required>
                <option value="">Válassz színt</option>
                <?php foreach ($colors as $color): ?>
                    <option value="<?php echo $color['id']; ?>">
                        <?php echo htmlspecialchars($color['color']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>
    
            <label for="birth_date">Szuletési dátum:</label>
            <input type="date" id="birth_date" name="birth_date" required>
            <br>
    
            <label for="picture">Kép feltöltése (nem kötelező):</label>
            <input type="file" id="picture" name="picture">
            <br>
    
            <button type="submit">Hozzáadás</button>
            <button><a href="contents_list.html">Vissza</a></button>
        </form>
    </div>
</body>
</html>
