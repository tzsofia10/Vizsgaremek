<?php
session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require "../connect.php";

$output = "";
$alias = "";
$ordering = 1;
$nav_name = "";
$content = "";
$description = "";
$keywords = "";
$state = 1;

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

    // Ellenőrizzük, hogy létezik-e már ugyanilyen nevű cikk
    $check_query = "SELECT id FROM news WHERE nav_name = ?";
    $check_stmt = mysqli_prepare($dbconn, $check_query);
    if ($check_stmt) {
        mysqli_stmt_bind_param($check_stmt, "s", $nav_name);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);
        
        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $_SESSION['swal_message'] = [
                'type' => 'error',
                'title' => 'Hiba!',
                'text' => 'Már létezik ilyen nevű cikk!'
            ];
            header("Location: content_management.php");
            exit();
        }
        mysqli_stmt_close($check_stmt);
    }

    // Alapvető validációk
    if (empty($alias)) {
        $errors[] = "Az alias mező nem lehet üres!";
    }
    if (!preg_match("/^[a-z-_]+$/", $alias)) {
        $errors[] = "Az alias csak kisbetűket, kötőjelet és alulvonást tartalmazhat!";
    }
    if (empty($nav_name)) {
        $errors[] = "A navigációs név megadása kötelező!";
    }

    // Kép feltöltés kezelése
    $targetFile = null;
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
        $query = "INSERT INTO news (alias, ordering, nav_name, content, description, keywords, states, img, creation) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($dbconn, $query);

        if ($stmt) {
            $imgPath = $targetFile ? basename($targetFile) : null;
            mysqli_stmt_bind_param($stmt, "sissssis", $alias, $ordering, $nav_name, $content, $description, $keywords, $state, $imgPath);
            
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['swal_message'] = [
                    'type' => 'success',
                    'title' => 'Sikeres feltöltés!',
                    'text' => 'A cikk sikeresen feltöltve!'
                ];
                header("Location: list.php");
                exit();
            } else {
                $_SESSION['swal_message'] = [
                    'type' => 'error',
                    'title' => 'Hiba!',
                    'text' => 'A cikk feltöltése sikertelen!'
                ];
            }
            mysqli_stmt_close($stmt);
        } else {
            $errors[] = "Hiba történt az adatbázis előkészítésekor: " . mysqli_error($dbconn);
        }
    }

    if (!empty($errors)) {
        $_SESSION['swal_message'] = [
            'type' => 'error',
            'title' => 'Hiba!',
            'text' => implode("\n", $errors)
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<?php 
    $page_title = "Új cikk"; 
    $custom_css = ["../css/pages/edit.css"]; 
    $custom_js = []; 
    $additional_head = "
        <script src='https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    "; 
    include '../main/head.php'; 
?>
<body>
    <div class="container">
        <header>
            <h1>Új cikk létrehozása</h1>
        </header>

        <section class="form-container">
            <?= $output ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="alias">Alias:* <input type="text" id="alias" name="alias" required pattern="^[a-z-_]+$" value="<?= htmlspecialchars($alias) ?>"></label>
                </div>
                <div class="form-group">
                    <label for="ordering">Sorrend: <input type="number" id="ordering" name="ordering" min="1" value="<?= $ordering ?>"></label>
                </div>
                <div class="form-group">
                    <label for="nav_name">Navigációs név:* <input type="text" id="nav_name" name="nav_name" required value="<?= htmlspecialchars($nav_name) ?>"></label>
                </div>
                <div class="form-group">
                    <label for="content">Tartalom: <textarea id="content" name="content"><?= htmlspecialchars($content) ?></textarea></label>
                </div>
                <div class="form-group">
                    <label for="description">Leírás: <textarea id="description" name="description"><?= htmlspecialchars($description) ?></textarea></label>
                </div>
                <div class="form-group">
                    <label for="keywords">Kulcsszavak: <textarea id="keywords" name="keywords"><?= htmlspecialchars($keywords) ?></textarea></label>
                </div>
                <div class="form-group">
                    <label for="image">Kép: <input type="file" id="image" name="image" accept="image/*"></label>
                </div>
                <div class="form-group">
                    <label for="state">Állapot:
                        <select id="state" name="state">
                            <option value="1" <?= $state === 1 ? "selected" : "" ?>>Aktív</option>
                            <option value="0" <?= $state === 0 ? "selected" : "" ?>>Inaktív</option>
                        </select>
                    </label>
                </div>
                <div class="actions">
                    <input type="submit" name="submit" value="Mentés" class="btn btn-primary">
                    <input type="reset" value="Mégse" class="btn btn-secondary">
                    <a href="list.php" class="btn btn-link">Vissza a listához</a>
                </div>
            </form>
        </section>
    </div>

    <?php
    if (isset($_SESSION['swal_message'])) {
        $message = $_SESSION['swal_message'];
        echo "<script>
            Swal.fire({
                icon: '" . $message['type'] . "',
                title: '" . $message['title'] . "',
                text: '" . $message['text'] . "',
                confirmButtonColor: '" . ($message['type'] == 'success' ? '#28a745' : '#dc3545') . "'
            }).then((result) => {
                if (result.isConfirmed && '" . $message['type'] . "' === 'success') {
                    window.location.href = 'list.php';
                }
            });
        </script>";
        unset($_SESSION['swal_message']);
    }
    ?>

    <script>
        CKEDITOR.replace('content');
    </script>
</body>
</html>
