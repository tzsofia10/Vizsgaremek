<?php
require_once("../connect.php");

// Query to get death counts per month
$sql = "SELECT DATE_FORMAT(death_date, '%Y-%m') AS month, COUNT(*) AS count 
        FROM cows 
        WHERE death_date IS NOT NULL 
        GROUP BY month 
        ORDER BY month";
$result = $dbconn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$dbconn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
