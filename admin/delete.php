<?php
require "../connect.php";

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Cikk törlése az adatbázisból
    $query = "DELETE FROM cms_news WHERE id = ?";
    $stmt = mysqli_prepare($dbconn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: list.php?message=Sikeres törlés!");
            exit();
        } else {
            echo "Hiba történt a törlés során: " . htmlspecialchars(mysqli_stmt_error($stmt), ENT_QUOTES, 'UTF-8');
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Hiba az adatbázis előkészítése során: " . htmlspecialchars(mysqli_error($dbconn), ENT_QUOTES, 'UTF-8');
    }
} else {
    echo "Hiba: érvénytelen ID.";
}
