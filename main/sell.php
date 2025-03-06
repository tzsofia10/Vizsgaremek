<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gazdanaplo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, sales_date, customer_id, price, cow_id FROM sales";
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
    <link rel="stylesheet" href="../css/selling.css">
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .button-wrapper { display: flex; align-items: center; cursor: pointer; background-color: #4CAF50; color: white; padding: 5px 10px; border-radius: 5px; }
        .button-wrapper:hover { background-color: #45a049; }
        .icon { margin-left: 5px; }
    </style>
</head>
<body>
<?php include '../main/nav.php'; ?>
    <h1>Szarvasmarhák eladása</h1>
    <table>
    <tr>
        <th>ID</th>
        <th>Eladási Dátum</th>
        <th>Ár (HUF)</th>
        <th>Művelet</th>
    </tr>

    <?php if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["sales_date"] . "</td>
                    <td>" . number_format($row["price"], 2, ',', ' ') . " HUF</td>
                    <td>
                        <div class='button' data-tooltip='Ár: " . number_format($row["price"], 0, ',', ' ') . " HUF'>
                            <div class='button-wrapper'>
                                <div class='text'>Buy Now</div>
                            </div>
                        </div>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Nincs elérhető adat</td></tr>";
    } ?>
</table>

    <footer>
        <?php include '../main/footer.php'; ?>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
