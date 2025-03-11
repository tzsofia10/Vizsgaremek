<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gazdanaplo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sale_id"])) {
    $sale_id = $_POST["sale_id"];

    $sql = "UPDATE sales SET sale_status = 'sold' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sale_id);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
}

$conn->close();
?>
