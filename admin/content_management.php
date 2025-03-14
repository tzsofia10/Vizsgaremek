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
$img = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $_POST = array_map("trim", $_POST);
    $alias = strtolower(filter_var($_POST['alias'], FILTER_SANITIZE_STRING));
    $ordering = isset($_POST['ordering']) && ctype_digit($_POST['ordering']) ? (int)$_POST['ordering'] : 1;
    $nav_name = filter_var($_POST['nav_name'], FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $keywords = filter_var($_POST['keywords'], FILTER_SANITIZE_STRING);
    $state = isset($_POST['state']) ? (int)$_POST['state'] : 1;

    $errors = [];
    // Ellenőrizzük, hogy létezik-e már ugyanilyen nevű alias
    $check_alias = "SELECT id FROM news WHERE alias = ?";
    $check_stmt = mysqli_prepare($dbconn, $check_alias);
    if ($check_stmt) {
        mysqli_stmt_bind_param($check_stmt, "s", $alias);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);
        
        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $_SESSION['swal_message'] = [
                'type' => 'error',
                'title' => 'Hiba!',
                'text' => 'Már létezik ilyen nevű alias!'
            ];
            header("Location: content_management.php");
            exit();
        }
        mysqli_stmt_close($check_stmt);
    }
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
    $custom_css = ["../css/pages/newArticle.css"]; 
    $custom_js = []; 
    $additional_head = "
        <script src='https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    "; 
    include '../main/head.php'; 
?>
<body>
    <div class="edit-container">
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
                            <p>Nincs kiválasztott kép</p>
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.16565 10.1534C5.07629 8.99181 5.99473 8 7.15975 8H16.8402C18.0053 8 18.9237 8.9918 18.8344 10.1534L18.142 19.1534C18.0619 20.1954 17.193 21 16.1479 21H7.85206C6.80699 21 5.93811 20.1954 5.85795 19.1534L5.16565 10.1534Z" stroke="#000000" stroke-width="2"></path>
                                <path d="M19.5 5H4.5" stroke="#000000" stroke-width="2" stroke-linecap="round"></path>
                                <path d="M10 3C10 2.44772 10.4477 2 11 2H13C13.5523 2 14 2.44772 14 3V5H10V3Z" stroke="#000000" stroke-width="2"></path>
                            </svg>
                        </label>
                        <input id="image" name="image" type="file" accept="image/*" onchange="previewImage(this);">
                    </div>
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
                    <input type="reset" value="Mégse" onclick="window.location.href='list.php';">
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
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'uploaded-image';
                    preview.appendChild(img);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
