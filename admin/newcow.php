<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require '../connect.php'; 

// Színek lekérdezése az adatbázisból
$colorsResult = $dbconn->query("SELECT id, colors AS color FROM colors");
$colors = [];
if ($colorsResult->num_rows > 0) {
    while ($row = $colorsResult->fetch_assoc()) {
        $colors[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ear_tag = mysqli_real_escape_string($dbconn, $_POST['ear_tag'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $mother_ear_tag = $_POST['mother_ear_tag'] ?? '';
    $father_ear_tag = $_POST['father_ear_tag'] ?? '';
    $color_id = $_POST['color_id'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';
    $picture = NULL;

    // Kép feltöltés kezelése
    if (!empty($_FILES['picture']['name']) && $_FILES['picture']['error'] === 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES['picture']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_formats = ['jpg', 'jpeg', 'png'];

        if (in_array($imageFileType, $allowed_formats)) {
            if (move_uploaded_file($_FILES['picture']['tmp_name'], $target_file)) {
                $picture = $target_file;
            } else {
                echo "<p>Hiba történt a kép feltöltésekor.</p>";
            }
        } else {
            echo "<p>Csak JPG, JPEG, vagy PNG fájlok tölthetők fel.</p>";
        }
    }

    // Adatbázisba mentés
    $stmt = $dbconn->prepare("INSERT INTO cows (ear_tag, gender, mother_ear_tag, father_ear_tag, color_id, birthdate, picture) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssiss', $ear_tag, $gender, $mother_ear_tag, $father_ear_tag, $color_id, $birthdate, $picture);
    
    if ($stmt->execute()) {
        echo "<p>Új tehén sikeresen hozzáadva!</p>";
    } else {
        echo "<p>Hiba történt: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
$dbconn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <script src="../js/translate2.js"></script>
    <link rel="stylesheet" href="../css/newcow.css">
    <title>Új tehén hozzáadása</title>
</head>
<body>
    <h1>Új tehén hozzáadása</h1>
    <div class="container">
        <form method="POST" enctype="multipart/form-data">
            <label for="ear_tag">Füljelző:</label>
            <input type="text" id="ear_tag" name="ear_tag" required maxlength="13">
            <br>
    
            <label for="gender">Nem:</label>
            <select id="gender" name="gender" required>
                <option value="">Válassz nemet</option>
                <option value="1">Hím</option>
                <option value="0">Nőstény</option>
            </select>
            <br>
    
            <label for="mother_ear_tag">Anya füljelzője:</label>
            <input type="text" id="mother_ear_tag" name="mother_ear_tag" maxlength="13">
            <br>
    
            <label for="father_ear_tag">Apa füljelzője:</label>
            <input type="text" id="father_ear_tag" name="father_ear_tag" maxlength="13">
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
    
            <label for="birthdate">Születési dátum:</label>
            <input type="date" id="birthdate" name="birthdate" required>
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
