<?php
session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Ha nincs bejelentkezve, irányítsuk át a bejelentkezési oldalra
    header("Location: index.php");
    exit();
}

require '../connect.php'; // Az adatbázis kapcsolat betöltése

// SQL lekérdezés, amely egyesíti a szükséges adatokat a különböző táblákból
$sql = "SELECT 
            cows.id AS cow_id, 
            cows.ear_tag, 
            cows.gender, 
            cows.mother_ear_tag, 
            cows.father_ear_tag, 
            colors.black, 
            colors.brown, 
            colors.white, 
            colors.spotted, 
            cows.birth_date 
        FROM cows
        LEFT JOIN colors ON cows.color_id = colors.id
        ORDER BY cows.id";

$result = $dbconn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ear Tag</th>
                    <th>Gender</th>
                    <th>Mother Ear Tag</th>
                    <th>Father Ear Tag</th>
                    <th>Color</th>
                    <th>Birth Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>";

    // Adatok feldolgozása és táblázatba írása
    while ($row = $result->fetch_assoc()) {
        $color = $row['black'] ?: ($row['brown'] ?: ($row['white'] ?: $row['spotted']));
        echo "<tr>
                <td>" . htmlspecialchars($row['cow_id']) . "</td>
                <td>" . htmlspecialchars($row['ear_tag']) . "</td>
                <td>" . htmlspecialchars($row['gender']) . "</td>
                <td>" . htmlspecialchars($row['mother_ear_tag']) . "</td>
                <td>" . htmlspecialchars($row['father_ear_tag']) . "</td>
                <td>" . htmlspecialchars($color) . "</td>
                <td>" . htmlspecialchars($row['birth_date']) . "</td>
                <td>
                    <a href='delete_cow.php?id=" . $row['cow_id'] . "'>Törlés</a> |
                    <a href='edit_cow.php?id=" . $row['cow_id'] . "'>Módosítás</a>
                </td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p>Nincs adat a táblázatban.</p>";
}

$dbconn->close();