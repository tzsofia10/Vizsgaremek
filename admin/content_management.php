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
    $ordering = (int)($_POST['ordering'] ?? 1);
    $nav_name = filter_var($_POST['nav_name'], FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $keywords = filter_var($_POST['keywords'], FILTER_SANITIZE_STRING);
    $state = (int)($_POST['state'] ?? 1);
    $errors = [];

    if (empty($alias)) {
        $errors[] = "Az alias mező nem lehet üres!";
    } elseif (!preg_match("/^[a-z-_]+$/", $alias)) {
        $errors[] = "Az alias csak kisbetűket, kötőjelet és alulvonást tartalmazhat!";
    }

    if (empty($nav_name)) {
        $errors[] = "A navigációs név megadása kötelező!";
    }

    $targetFile = null;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $errors[] = "Csak JPG, JPEG, PNG és GIF fájlok engedélyezettek!";
        } elseif (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $errors[] = "Hiba történt a kép feltöltésekor!";
        }
    }

    if ($errors) {
        $output = '<ul>' . implode('', array_map(fn($e) => "<li>{$e}</li>", $errors)) . '</ul>';
    } else {
        $stmt = mysqli_prepare($dbconn, "INSERT INTO news (alias, ordering, nav_name, content, creation, description, keywords, states, img) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?)");
        $imgPath = $targetFile ? basename($targetFile) : null;
        mysqli_stmt_bind_param($stmt, "sissssis", $alias, $ordering, $nav_name, $content, $description, $keywords, $state, $imgPath);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: list.php");
            exit();
        } else {
            $output = "<p>Adatbázis hiba: " . htmlspecialchars(mysqli_stmt_error($stmt), ENT_QUOTES, 'UTF-8') . "</p>";
        }

        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Új tartalom létrehozása</title>
    <link rel="stylesheet" href="../css/pages/content.css">
    <style>
        .form-container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background: #f9f9f9; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, textarea, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .actions { margin-top: 15px; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        .btn-link { color: #007bff; text-decoration: none; }
        ul { color: red; }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Új Tartalom Létrehozása</h2>
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
</div>
<script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
<script>CKEDITOR.replace('content');</script>
</body>
</html>
