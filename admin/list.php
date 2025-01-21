<?php

session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Ha nincs bejelentkezve, irányítsuk át a bejelentkezési oldalra
    header("Location: index.php");
    exit();
}
require "../connect.php";

// Cikkek lekérdezése az adatbázisból
$query = "SELECT id, alias, nav_name, creation, states FROM cms_news ORDER BY creation DESC";
$result = mysqli_query($dbconn, $query);

if (!$result) {
    die("Hiba az adatbázis lekérdezése során: " . mysqli_error($dbconn));
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cikkek listája</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Cikkek listája</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Alias</th>
                <th>Navigációs név</th>
                <th>Létrehozás dátuma</th>
                <th>Állapot</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['alias']) ?></td>
                        <td><?= htmlspecialchars($row['nav_name']) ?></td>
                        <td><?= htmlspecialchars($row['creation']) ?></td>
                        <td><?= $row['states'] == 1 ? 'Aktív' : 'Inaktív' ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>">Módosítás</a> |
                            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Biztosan törölni szeretnéd?');">Törlés</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Nincsenek elérhető cikkek.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <p><a href="content_management.php">Új cikk hozzáadása</a></p>
</body>
</html>

