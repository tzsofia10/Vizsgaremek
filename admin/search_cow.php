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
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 5; // Elemek száma oldalanként
    $offset = ($page - 1) * $limit;
    
    // Összes találat számának lekérése
    $count_sql = "SELECT COUNT(*) as total FROM cows 
                  LEFT JOIN colors ON cows.color_id = colors.id 
                  WHERE cows.ear_tag LIKE ?";
    $count_stmt = $dbconn->prepare($count_sql);
    $count_stmt->bind_param('s', $search);
    $count_stmt->execute();
    $total_result = $count_stmt->get_result();
    $total_rows = $total_result->fetch_assoc()['total'];
    $total_pages = ceil($total_rows / $limit);
    
    // Keresési eredmények lekérése lapozással
    $sql = "SELECT 
                cows.id AS cow_id, 
                cows.ear_tag, 
                cows.gender, 
                cows.mother_ear_tag, 
                colors.colors AS color, 
                cows.birthdate,
                cows.picture
            FROM cows
            LEFT JOIN colors ON cows.color_id = colors.id
            WHERE cows.ear_tag LIKE ?
            ORDER BY cows.id
            LIMIT ? OFFSET ?";

    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param('sii', $search, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $cows = [];
    while ($row = $result->fetch_assoc()) {
        $row['gender'] = $row['gender'] == 1 ? 'Hím' : 'Nőstény';
        $row['picture'] = !empty($row['picture']) ? $row['picture'] : '../cowPicture/nopicture.jpg';
        $cows[] = $row;
    }
    
    $response = [
        'cows' => $cows,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $total_pages,
            'total_rows' => $total_rows
        ]
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
    
    $stmt->close();
    $count_stmt->close();
}

$dbconn->close();

?> 