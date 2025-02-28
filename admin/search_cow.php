<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

require '../connect.php';

if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';
    
    $sql = "SELECT 
                cows.id AS cow_id, 
                cows.ear_tag, 
                cows.gender, 
                cows.mother_ear_tag, 
                cows.father_ear_tag, 
                colors.colors AS color, 
                cows.birthdate,
                cows.picture
            FROM cows
            LEFT JOIN colors ON cows.color_id = colors.id
            WHERE cows.ear_tag LIKE ?
            ORDER BY cows.id";

    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param('s', $search);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $cows = [];
    while ($row = $result->fetch_assoc()) {
        $row['gender'] = $row['gender'] == 1 ? 'Hím' : 'Nőstény';
        $row['picture'] = !empty($row['picture']) ? $row['picture'] : '../cowPicture/nopicture.jpg';
        $cows[] = $row;
    }
    
    header('Content-Type: application/json');
    echo json_encode($cows);
    
    $stmt->close();
}

$dbconn->close();
?> 