<?php
// Betöltjük a kapcsolódási fájlt
require_once __DIR__ . '/connect.php';

try {
    // A $dbconn változó már elérhető a connect.php-ból
    if (!$dbconn) {
        throw new Exception("Adatbázis kapcsolódási hiba");
    }

    // Cikkek lekérése az adatbázisból
    $sql = "SELECT * FROM news ORDER BY creation DESC";
    $result = mysqli_query($dbconn, $sql);
    
    if (!$result) {
        throw new Exception("Hiba a lekérdezés során: " . mysqli_error($dbconn));
    }
    
    $articles = mysqli_fetch_all($result, MYSQLI_ASSOC);

} catch(Exception $e) {
    echo "Hiba: " . $e->getMessage();
    exit();
}
// ... a többi kód változatlan marad ... 