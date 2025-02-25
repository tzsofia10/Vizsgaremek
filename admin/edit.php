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
// Készítsük elő a lekérdezést a megadott SQL utasítással
$stmt = mysqli_prepare($dbconn, $query);
if ($stmt) {
     // Ha a lekérdezés előkészítése sikeres, kössük hozzá a változókat
     //Az "i" jelzi, hogy a megadott paraméter ($id) integer típusú.
    mysqli_stmt_bind_param($stmt, "i", $id);
     // Futtassuk az előkészített lekérdezést
    mysqli_stmt_execute($stmt);
    // Szerezzük meg az eredményhalmazt a futtatott lekérdezésből
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $alias = htmlspecialchars($row['alias'], ENT_QUOTES, 'UTF-8');
        $ordering = $row['ordering'];
        $nav_name = htmlspecialchars($row['nav_name'], ENT_QUOTES, 'UTF-8');
        $content = $row['content']; // CKEditor tartalom
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
    $content = $_POST['content']; // CKEditor tartalom
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $keywords = filter_var($_POST['keywords'], FILTER_SANITIZE_STRING);
    $state = isset($_POST['state']) ? (int)$_POST['state'] : 1;
    $errors = [];

    // Validáció
    if (empty($alias)) {
        $errors[] = "Az alias mező nem lehet üres!";
    }
    if (!preg_match("/^[a-z-_]+$/", $alias)) {
        $errors[] = "Az alias csak kisbetűket, kötőjelet és alulvonást tartalmazhat!";
    }
    if (empty($nav_name)) {
        $errors[] = "A navigációs név megadása kötelező!";
    }

    // Fájl kezelése
    $targetFile = $img; // Meglévő kép alapértelmezésként
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Kép típusának ellenőrzése
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            $errors[] = "Csak JPG, JPEG, PNG és GIF fájlok engedélyezettek!";
        }

        // Feltöltés végrehajtása
        if (empty($errors) && !move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $errors[] = "Hiba történt a kép feltöltésekor!";
        }
    }

    // Hibák kezelése
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

/* HTML űrlap */
$output = $output ?? "";
$form = <<<FORM
<form method="post" action="" enctype="multipart/form-data">
    {$output}
    <p><label for="alias">Alias:*</label><br>
    <input type="text" id="alias" name="alias" required pattern="^[a-z-_]+$" value="{$alias}"></p>

    <p><label for="ordering">Sorrend:</label><br>
    <input type="number" id="ordering" name="ordering" min="1" value="{$ordering}"></p>

    <p><label for="nav_name">Navigációs név:*</label><br>
    <input type="text" id="nav_name" name="nav_name" required value="{$nav_name}"></p>

    <p><label for="content">Tartalom:</label><br>
    <textarea id="content" name="content" rows="10" cols="80">{$content}</textarea></p>

    <p><label for="description">Leírás:</label><br>
    <textarea id="description" name="description">{$description}</textarea></p>

    <p><label for="keywords">Kulcsszavak:</label><br>
    <textarea id="keywords" name="keywords">{$keywords}</textarea></p>

    <p><label for="image">Kép:</label><br>
    <input type="file" id="image" name="image" accept="image/*">
    <br><small>Jelenlegi kép: {$img}</small></p>

    <p><label for="state">Állapot:</label><br>
    <select id="state" name="state">
        <option value="1" " . ($state == 1 ? "selected" : "") . ">Aktív</option>
        <option value="0" " . ($state == 0 ? "selected" : "") . ">Inaktív</option>
    </select></p>

    <p><em>A *-gal jelölt mezők kitöltése kötelező!</em></p>
    <input type="submit" id="submit" name="submit" value="Mentés">
    <input type="reset" value="Mégse">
    <p><a href="list.php">Vissza a listához</a></p>
</form>

<script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
</script>
FORM;

/* Sablon megjelenítése */
$template = file_get_contents("../template.html");
$template = str_replace("{{menu}}", "", $template);
$template = str_replace("{{nav_name}}", "Cikk módosítása", $template);
$template = str_replace("{{content}}", $form, $template);
$template = str_replace("{{sidebar}}", "", $template);
print $template;

