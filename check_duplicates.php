<?php
require_once("connect.php");

// Duplikált bejegyzések keresése
$sql = "SELECT id, ear_tag, COUNT(*) as count 
        FROM cows 
        GROUP BY ear_tag 
        HAVING COUNT(*) > 1 
        ORDER BY id";

$result = mysqli_query($dbconn, $sql);

if ($result === false) {
    echo "<h2>Hiba a lekérdezés során:</h2>";
    echo "SQL hiba: " . mysqli_error($dbconn);
} else {
    echo "<h2>Duplikált bejegyzések:</h2>";
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Fülszám</th><th>Előfordulások száma</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['ear_tag'] . "</td>";
            echo "<td>" . $row['count'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Törlés a duplikált bejegyzésekről
        $sql = "DELETE t1 FROM cows t1
                INNER JOIN cows t2
                WHERE t1.id > t2.id
                AND t1.ear_tag = t2.ear_tag";

        if (mysqli_query($dbconn, $sql)) {
            echo "<h2>Duplikált bejegyzések törölve.</h2>";
        } else {
            echo "<h2>Hiba történt a törlés során:</h2>";
            echo "SQL hiba: " . mysqli_error($dbconn);
        }
    } else {
        echo "Nincsenek duplikált bejegyzések.";
    }
}

mysqli_close($dbconn);
?> 