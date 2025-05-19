<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

require "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' || isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Kép elérési útjának lekérése
    $sql_select = "SELECT picture FROM cows WHERE id = ?";
    $stmt_select = $dbconn->prepare($sql_select);
    $stmt_select->bind_param('i', $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $cow = $result->fetch_assoc();
    
    // Tehén törlése
    $sql_delete = "DELETE FROM cows WHERE id = ?";
    $stmt_delete = $dbconn->prepare($sql_delete);
    $stmt_delete->bind_param('i', $id);
    
    try {
        if ($stmt_delete->execute()) {
            // Ha van kép és nem az alapértelmezett, akkor töröljük
            if ($cow && $cow['picture'] && $cow['picture'] != '../cowPicture/nopicture.jpg') {
                if (file_exists($cow['picture'])) {
                    unlink($cow['picture']);
                }
            }
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Sikeres törlés']);
        }
    } catch (Exception $e)  {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Eladó szarvasmarhát nem lehet törölni!']);
    }
    
    $stmt_select->close();
    $stmt_delete->close();
}

$dbconn->close();
?>
