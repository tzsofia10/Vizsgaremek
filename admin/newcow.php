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
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ear_tag = mysqli_real_escape_string($dbconn, $_POST['ear_tag'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $mother_ear_tag = $_POST['mother_ear_tag'] ?? '';
    $father_ear_tag = $_POST['father_ear_tag'] ?? '';
    $color_id = $_POST['color_id'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';
    $picture = NULL;
    
    // Ellenőrizzük, hogy létezik-e már ilyen füljelző
    $check_query = "SELECT ear_tag FROM cows WHERE ear_tag = ?";
    $check_stmt = $dbconn->prepare($check_query);
    $check_stmt->bind_param('s', $ear_tag);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $error_message = 'Ez a füljelző már létezik az adatbázisban!';
    }
    $check_stmt->close();

    if (empty($error_message)) {
        // Azonosítók ellenőrzése
        if ($ear_tag === $mother_ear_tag) {
            $error_message = 'Az állat és az anyja nem lehet azonos azonosítóval!';
        } else {
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
                        $error_message = 'Hiba történt a kép feltöltésekor.';
                    }
                } else {
                    $error_message = 'Csak JPG, JPEG, vagy PNG fájlok tölthetők fel.';
                }
            }

            if (empty($error_message)) {
                // Adatbázisba mentés
                $stmt = $dbconn->prepare("INSERT INTO cows (ear_tag, gender, mother_ear_tag, father_ear_tag, color_id, birthdate, picture) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param('ssssiss', $ear_tag, $gender, $mother_ear_tag, $father_ear_tag, $color_id, $birthdate, $picture);
                
                if ($stmt->execute()) {
                    $success = true;
                } else {
                    $error_message = 'Hiba történt az adatok mentésekor.';
                }
                $stmt->close();
            }
        }
    }
}
$dbconn->close();
?>

<?php 
    $page_title = "Új szarvasmarha"; 
    $custom_css = ["../css/pages/editcow.css", "../css/pages/newcow.css"]; // Több CSS fájl hozzáadása
    $custom_js = ["../js/translate2.js", "../js/formTest.js", "../js/newCowAlert.js"]; 
    include '../main/head.php'; 
?>


<?php include '../main/head.php'; ?>

<body>
    <?php if ($success): ?>
        <script src="../js/newCowAlert.js"></script>
    
    <?php endif; ?>

    <header>
        <?php include "../main/nav.php";?>
    </header>
    
    <?php if (!empty($error_message)): ?>
    <div class="error" id="error-message">
        <div class="error__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" height="24" fill="none">
                <path fill="#fff" d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132 0-2.61358.25866-3.82683.7612-1.21326.50255-2.31565 1.23915-3.24424 2.16773-1.87536 1.87537-2.92893 4.41891-2.92893 7.07107 0 2.6522 1.05357 5.1957 2.92893 7.0711.92859.9286 2.03098 1.6651 3.24424 2.1677 1.21325.5025 2.51363.7612 3.82683.7612 2.6522 0 5.1957-1.0536 7.0711-2.9289 1.8753-1.8754 2.9289-4.4189 2.9289-7.0711 0-1.3132-.2587-2.61358-.7612-3.82683-.5026-1.21326-1.2391-2.31565-2.1677-3.24424-.9286-.92858-2.031-1.66518-3.2443-2.16773-1.2132-.50254-2.5136-.7612-3.8268-.7612z"></path>
            </svg>
        </div>
        <div class="error__title"><?php echo htmlspecialchars($error_message); ?></div>
        <div class="error__close" onclick="document.getElementById('error-message').style.display='none'">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" height="20">
                <path fill="#fff" d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z"></path>
            </svg>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($success === true): ?>

        <div class="success">
            <div class="success__icon">
            <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="m12 1c-6.075 0-11 4.925-11 11s4.925 11 11 11 11-4.925 11-11-4.925-11-11-11zm4.768 9.14c.0878-.1004.1546-.21726.1966-.34383.0419-.12657.0581-.26026.0477-.39319-.0105-.13293-.0475-.26242-.1087-.38085-.0613-.11844-.1456-.22342-.2481-.30879-.1024-.08536-.2209-.14938-.3484-.18828s-.2616-.0519-.3942-.03823c-.1327.01366-.2612.05372-.3782.1178-.1169.06409-.2198.15091-.3027.25537l-4.3 5.159-2.225-2.226c-.1886-.1822-.4412-.283-.7034-.2807s-.51301.1075-.69842.2929-.29058.4362-.29285.6984c-.00228.2622.09851.5148.28067.7034l3 3c.0983.0982.2159.1748.3454.2251.1295.0502.2681.0729.4069.0665.1387-.0063.2747-.0414.3991-.1032.1244-.0617.2347-.1487.3236-.2554z" fill="#393a37" fill-rule="evenodd"></path></svg>
            </div>
            <div class="success__title">Sikeresen hozzáadva!</div>
            <div class="success__close"><svg height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z" fill="#393a37"></path></svg></div>
        </div>
    <?php endif; ?>

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
    
            <label for="birthdate">Születési Dátum:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($cow['birthdate']); ?>" max="<?php echo date('Y-m-d'); ?>" required>
            <br>
    
            <label for="picture">Kép feltöltése (nem kötelező):</label>
            <input type="file" id="picture" name="picture">
            <br>
    
            <button class="button" type="submit">Hozzáadás</button>
            <button class="button"><a href="main.php">Vissza</a></button>
        </form>
    </main>

    
    <footer>
        <?php include '../main/footer.php'; ?>
    </footer>
</body>
</html>
