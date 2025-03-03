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
$success = false;

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
  // Azonosítók ellenőrzése
  if ($ear_tag === $mother_ear_tag) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Hiba',
            text: 'Az állat és az anyja nem lehet azonos azonosítóval!',
        }).then(() => {
            window.history.back();
        });
    </script>";
    exit;
}
    // Adatbázisba mentés
    $stmt = $dbconn->prepare("INSERT INTO cows (ear_tag, gender, mother_ear_tag, father_ear_tag, color_id, birthdate, picture) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssiss', $ear_tag, $gender, $mother_ear_tag, $father_ear_tag, $color_id, $birthdate, $picture);
    
    if ($stmt->execute()) {
        $success = true;
    } else {
        echo "<p>Hiba történt: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
$dbconn->close();
?>

<!DOCTYPE html>
<html>

 <!-- <head> része-->
<?php 
    $page_title = "Új szarvasmarha"; 
    $custom_css = ["../css/pages/editcow.css", "../css/pages/newcow.css"]; // Több CSS fájl hozzáadása
    $custom_js = ["../js/translate2.js", "../js/formTest.js"]; 
    include '../main/head.php'; 
?>
<!-- </head> rész vége-->

<body>
    <?php if ($success): ?>
        <script src="../js/newCowAlert.js"></script>
    
    <?php endif; ?>
    <header>
        <?php include "../main/nav.php";?>
    </header>
    
    <div id="success-message" class="success">
        <div class="success__icon">
        <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="m12 1c-6.075 0-11 4.925-11 11s4.925 11 11 11 11-4.925 11-11-4.925-11-11-11zm4.768 9.14c.0878-.1004.1546-.21726.1966-.34383.0419-.12657.0581-.26026.0477-.39319-.0105-.13293-.0475-.26242-.1087-.38085-.0613-.11844-.1456-.22342-.2481-.30879-.1024-.08536-.2209-.14938-.3484-.18828s-.2616-.0519-.3942-.03823c-.1327.01366-.2612.05372-.3782.1178-.1169.06409-.2198.15091-.3027.25537l-4.3 5.159-2.225-2.226c-.1886-.1822-.4412-.283-.7034-.2807s-.51301.1075-.69842.2929-.29058.4362-.29285.6984c-.00228.2622.09851.5148.28067.7034l3 3c.0983.0982.2159.1748.3454.2251.1295.0502.2681.0729.4069.0665.1387-.0063.2747-.0414.3991-.1032.1244-.0617.2347-.1487.3236-.2554z" fill="#ffffff" fill-rule="evenodd"></path></svg>
        </div>
        <div class="success__title">Új szarvasmarha sikeresen hozzáadva!</div>
        <div class="success__close" onclick="document.getElementById('success-message').style.display='none'">
            <svg height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z" fill="#ffffff"></path></svg>
        </div>
    </div>

    <main>    
        <h1>Új szarvasmarha hozzáadása</h1>
        <form method="POST" enctype="multipart/form-data">
            <label for="ear_tag">Füljelző:</label>
            <input type="text" id="ear_tag" name="ear_tag" required maxlength="15">
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
    
            <button class="button" type="submit">Hozzáadás</button>
            <button class="button"><a href="contents_list.html">Vissza</a></button>
        </form>
    </main>

    
    <footer>
        <?php include '../main/footer.php'; ?>
    </footer>
</body>
</html>
