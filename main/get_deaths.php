<?php
$servername = "localhost";  // Change if needed
$username = "root";         // Change your DB username
$password = "";             // Change your DB password
$dbname = "gazdanaplo";     // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get death counts per month
$sql = "SELECT DATE_FORMAT(death_date, '%Y-%m') AS month, COUNT(*) AS count 
        FROM cows 
        WHERE death_date IS NOT NULL 
        GROUP BY month 
        ORDER BY month";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
