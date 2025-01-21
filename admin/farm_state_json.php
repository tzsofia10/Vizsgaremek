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

$data = [];

if ($result->num_rows > 0) {
    // Adatok feldolgozása JSON tömbbe
    while ($row = $result->fetch_assoc()) {
        $color = $row['black'] ?: ($row['brown'] ?: ($row['white'] ?: $row['spotted']));
        $data[] = [
            'id' => $row['cow_id'],
            'ear_tag' => $row['ear_tag'],
            'gender' => $row['gender'],
            'mother_ear_tag' => $row['mother_ear_tag'],
            'father_ear_tag' => $row['father_ear_tag'],
            'color' => $color,
            'birth_date' => $row['birth_date']
        ];
    }

    // JSON kimenet
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(['message' => 'Nincs adat a táblázatban.']);
}

$dbconn->close();