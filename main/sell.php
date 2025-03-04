<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gazdanaplo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, sales_date, sellers_id, price,cow_id FROM sales";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szarvasmarhák eladása</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/footer.css">
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<?php include '../main/nav.php'; 
    
    ?>
    <h1>Szarvasmarhák eladása</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Eladási Dátum</th>
            <th>Ár (HUF)</th>
            <th>Vevő</th>
        </tr>
        <?php if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["sale_date"] . "</td>
                        <td>" . $row["price"] . "</td>
                        <td>" . $row["sellers_id"] . "</td>
                        <td>" . $row["cow_id"] . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nincs elérhető adat</td></tr>";
        } ?>
    </table>
    <footer>
   <?php include '../main/footer.php';?>
</footer>
</body>
</html>

<?php
$conn->close();
?>
