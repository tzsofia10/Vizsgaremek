<?php
session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Ha nincs bejelentkezve, irányítsuk át a bejelentkezési oldalra
    header("Location: ../login.php");
    exit();
}

require "../connect.php";
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Hiba: érvénytelen vagy hiányzó cikkazonosító!");
}

$id = (int)$_GET['id']; // Az id értékének beolvasása és számként kezelése

// Cikk lekérdezése az adatbázisból
$query = "SELECT alias, ordering, nav_name, content, description, keywords, states, img FROM news WHERE id = ?";
$stmt = mysqli_prepare($dbconn, $query);
if ($stmt) {
     mysqli_stmt_bind_param($stmt, "i", $id);
     mysqli_stmt_execute($stmt);
     $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $alias = htmlspecialchars($row['alias'], ENT_QUOTES, 'UTF-8');
        $ordering = $row['ordering'];
        $nav_name = htmlspecialchars($row['nav_name'], ENT_QUOTES, 'UTF-8');
        $content = $row['content'];
        $description = htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8');
        $keywords = htmlspecialchars($row['keywords'], ENT_QUOTES, 'UTF-8');
        $state = $row['states'];
        $img = $row['img'];
    } else {
        die("Hiba: A cikk nem található.");
    }
    mysqli_stmt_close($stmt);
} else {
    die("Hiba: Az adatbázis lekérdezése sikertelen.");
}

// Frissítés kezelése
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $_POST = array_map("trim", $_POST);
    $alias = strtolower(filter_var($_POST['alias'], FILTER_SANITIZE_STRING));
    $ordering = isset($_POST['ordering']) ? (int)$_POST['ordering'] : 1;
    $nav_name = filter_var($_POST['nav_name'], FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $keywords = filter_var($_POST['keywords'], FILTER_SANITIZE_STRING);
    $state = isset($_POST['state']) ? (int)$_POST['state'] : 1;
    $errors = [];

    if (empty($alias)) {
        $errors[] = "Az alias mező nem lehet üres!";
    }
    if (!preg_match("/^[a-z-_]+$/", $alias)) {
        $errors[] = "Az alias csak kisbetűket, kötőjelet és alulvonást tartalmazhat!";
    }
    if (empty($nav_name)) {
        $errors[] = "A navigációs név megadása kötelező!";
    }

    // Ellenőrizzük, hogy létezik-e már ugyanilyen nevű cikk
    $check_query = "SELECT id FROM news WHERE nav_name = ? AND id != ?";
    $check_stmt = mysqli_prepare($dbconn, $check_query);
    if ($check_stmt) {
        mysqli_stmt_bind_param($check_stmt, "si", $nav_name, $id);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);
        
        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $errors[] = "Már létezik cikk ezzel a névvel: " . htmlspecialchars($nav_name);
        }
        mysqli_stmt_close($check_stmt);
    }

    $targetFile = $img; // Meglévő kép alapértelmezésként
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            $errors[] = "Csak JPG, JPEG, PNG és GIF fájlok engedélyezettek!";
        }

        if (empty($errors) && !move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $errors[] = "Hiba történt a kép feltöltésekor!";
        }
    }

    if (empty($errors)) {
        $query = "UPDATE news SET alias = ?, ordering = ?, nav_name = ?, content = ?, description = ?, keywords = ?, states = ?, img = ? WHERE id = ?";
        $stmt = mysqli_prepare($dbconn, $query);

        if ($stmt) {
            $imgPath = $targetFile ? basename($targetFile) : null;
            mysqli_stmt_bind_param($stmt, "sissssisi", $alias, $ordering, $nav_name, $content, $description, $keywords, $state, $imgPath, $id);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: list.php?message=Sikeres módosítás!");
                exit();
            } else {
                $output = "<p>Hiba történt az adatbázis művelet során: " . htmlspecialchars(mysqli_stmt_error($stmt), ENT_QUOTES, 'UTF-8') . "</p>";
            }
            mysqli_stmt_close($stmt);
        } else {
            $output = "<p>Hiba történt az adatbázis előkészítésekor: " . htmlspecialchars(mysqli_error($dbconn), ENT_QUOTES, 'UTF-8') . "</p>";
        }
    } else {
        $output = "<ul>\n";
        foreach ($errors as $error) {
            $output .= "<li>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</li>\n";
        }
        $output .= "</ul>\n";
    }
}

$output = $output ?? "";
?>

<!DOCTYPE html>
<html lang="hu">
<?php 
    $page_title = "Cikk szerkesztése"; 
    $custom_css = ["../css/pages/edit.css"]; 
    $custom_js = ["https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"
    ]; 

    include '../main/head.php'; 
?>
<body>

<div class="edit-container">
    <header>
        <h1>Cikk módosítása</h1>
    </header>

    <section class="form-container">
        <?php if (!empty($output)) echo "<div class='error-messages'>{$output}</div>"; ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="alias">Alias:*</label>
                <input type="text" id="alias" name="alias" required pattern="^[a-z_\-]+$" value="<?= $alias ?>">


            </div>

            <div class="form-group">
                <label for="ordering">Sorrend:</label>
                <input type="number" id="ordering" name="ordering" min="1" value="<?= $ordering ?>">
            </div>

            <div class="form-group">
                <label for="nav_name">Navigációs név:*</label>
                <input type="text" id="nav_name" name="nav_name" required value="<?= $nav_name ?>">
            </div>

            <div class="form-group">
                <label for="content">Tartalom:</label>
                <textarea id="content" name="content" rows="10" cols="80"><?= $content ?></textarea>
            </div>

            <div class="form-group">
                <label for="description">Leírás:</label>
                <textarea id="description" name="description"><?= $description ?></textarea>
            </div>

            <div class="form-group">
                <label for="keywords">Kulcsszavak:</label>
                <textarea id="keywords" name="keywords"><?= $keywords ?></textarea>
            </div>

            <div class="form-group form-group-grid">
                <label for="image">Kép feltöltése:</label>
                <div class="container">
                    <div class="header">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 10V9C7 6.23858 9.23858 4 12 4C14.7614 4 17 6.23858 17 9V10C19.2091 10 21 11.7909 21 14C21 15.4806 20.1956 16.8084 19 17.5M7 10C4.79086 10 3 11.7909 3 14C3 15.4806 3.8044 16.8084 5 17.5M7 10C7.43285 10 7.84965 10.0688 8.24006 10.1959M12 12V21M12 12L15 15M12 12L9 15" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <p>Keress képet a feltöltésre!</p>
                    </div>
                    <label for="image" class="footer">
                        <svg fill="#000000" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.331 6H8.5v20h15V14.154h-8.169z"></path>
                            <path d="M18.153 6h-.009v5.342H23.5v-.002z"></path>
                        </svg>
                        <p id="file-name">Nincs kiválasztott kép</p>
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.16565 10.1534C5.07629 8.99181 5.99473 8 7.15975 8H16.8402C18.0053 8 18.9237 8.9918 18.8344 10.1534L18.142 19.1534C18.0619 20.1954 17.193 21 16.1479 21H7.85206C6.80699 21 5.93811 20.1954 5.85795 19.1534L5.16565 10.1534Z" stroke="#000000" stroke-width="2"></path>
                            <path d="M19.5 5H4.5" stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                            <path d="M10 3C10 2.44772 10.4477 2 11 2H13C13.5523 2 14 2.44772 14 3V5H10V3Z" stroke="#000000" stroke-width="2"></path>
                        </svg>
                    </label>
                    <input id="image" name="image" type="file" accept="image/*" onchange="previewImage(this);">
                </div>
                
                <div class="form-group state-container">
                    <label for="state">Állapot:</label>
                    <select id="state" name="state">
                        <option value="1" <?= $state == 1 ? 'selected' : '' ?>>Aktív</option>
                        <option value="0" <?= $state == 0 ? 'selected' : '' ?>>Inaktív</option>
                    </select>
                </div>
            </div>       
 

            <div class="form-actions">
                <input type="submit" id="submit" name="submit" value="Mentés">
                <input type="reset" value="Mégse" onclick="window.location.href='list.php';">
            </div>
        </form>
    </section>
</div>
<script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>

<script>
  function previewImage(input) {
        const fileName = input.files.length > 0 ? input.files[0].name : "Nincs kiválasztott kép";
        document.getElementById('file-name').textContent = fileName;
    }

    // CKEditor példányosítása a tartalomhoz és leíráshoz
    CKEDITOR.replace('content');
    CKEDITOR.replace('description'); 
</script>


</body>
</html>
