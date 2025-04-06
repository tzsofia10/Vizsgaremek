<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tehenek Halálozási Dátuma</title>
</head>
<body>
    <form method="post">
        <button type="submit" name="getDeceasedCows">Elhunyt Tehenek</button>
        <button type="submit" name="getLivingCows">Élő Tehenek</button>
    </form>
    
    <?php
    if (isset($_POST['getDeceasedCows'])) {
        // Csatlakozás az adatbázishoz
        $servername = "localhost"; // Az adatbázis kiszolgálója
        $username = "root";        // Az adatbázis felhasználónév
        $password = "";            // Az adatbázis jelszó
        $dbname = "gazdanaplo";       // Az adatbázis neve

        // Kapcsolódás az adatbázishoz
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Kapcsolódás ellenőrzése
        if ($conn->connect_error) {
            die("Kapcsolódás sikertelen: " . $conn->connect_error);
        }

        // Lekérdezés a halálozási dátummal rendelkező tehenekre
        $sql = "SELECT * FROM cows WHERE death_date IS NOT NULL";
        $result = $conn->query($sql);

        // Ha van eredmény, megjeleníti
        if ($result->num_rows > 0) {
            echo "<h2>Elhunyt Tehenek:</h2>";
            echo "<table border='1'><tr><th>ID</th><th>Fül címke</th><th>Születési dátum</th><th>Halálozási dátum</th><th>Anyatehén fül címke</th><th>Apatehén fül címke</th></tr>";
            
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["ear_tag"] . "</td>
                        <td>" . $row["birthdate"] . "</td>
                        <td>" . $row["death_date"] . "</td>
                        <td>" . $row["mother_ear_tag"] . "</td>
                        <td>" . $row["father_ear_tag"] . "</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "Nincsenek elhunyt tehenek az adatbázisban.";
        }

        // Kapcsolat lezárása
        $conn->close();
    }

    if (isset($_POST['getLivingCows'])) {
        // Csatlakozás az adatbázishoz
        $servername = "localhost"; // Az adatbázis kiszolgálója
        $username = "root";        // Az adatbázis felhasználónév
        $password = "";            // Az adatbázis jelszó
        $dbname = "gazdanaplo";       // Az adatbázis neve

        // Kapcsolódás az adatbázishoz
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Kapcsolódás ellenőrzése
        if ($conn->connect_error) {
            die("Kapcsolódás sikertelen: " . $conn->connect_error);
        }

        // Lekérdezés az élő tehenekre (akiknek nincs megadva halálozási dátum)
        $sql = "SELECT * FROM cows WHERE death_date IS NULL";
        $result = $conn->query($sql);

        // Ha van eredmény, megjeleníti
        if ($result->num_rows > 0) {
            echo "<h2>Élő Tehenek:</h2>";
            echo "<table border='1'><tr><th>ID</th><th>Fül címke</th><th>Születési dátum</th><th>Anyatehén fül címke</th><th>Apatehén fül címke</th></tr>";
            
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["ear_tag"] . "</td>
                        <td>" . $row["birthdate"] . "</td>
                        <td>" . $row["mother_ear_tag"] . "</td>
                        <td>" . $row["father_ear_tag"] . "</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "Nincsenek élő tehenek az adatbázisban.";
        }

        // Kapcsolat lezárása
        $conn->close();
    }
    ?>
</body>
</html>
