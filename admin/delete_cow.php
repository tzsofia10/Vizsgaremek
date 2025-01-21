<?php
session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Ha nincs bejelentkezve, irányítsuk át a bejelentkezési oldalra
    header("Location: index.php");
    exit();
}

require '../connect.php'; 

// Ha az URL-ben szerepel az id paraméter
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Tétel törlése az adatbázisból
    $stmt = $dbconn->prepare("DELETE FROM cows WHERE id = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "<p>Tehén sikeresen törölve!</p>";
    } else {
        echo "<p>Hiba történt a tehén törlése közben: " . $dbconn->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p>Érvénytelen vagy hiányzó ID paraméter.</p>";
}

$dbconn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tehén törlése</title>
</head>
<body>
    <h1>Tehén törlése</h1>
    <a href="farm_states.php">Vissza a tehenek listájához</a>
</body>
</html>
