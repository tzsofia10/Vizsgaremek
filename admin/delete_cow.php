<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require "../connect.php";

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Törlés végrehajtása
    $delete_sql = "DELETE FROM cows WHERE id = ?";
    $stmt = $dbconn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    
    $response = array();
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "A tehén sikeresen törölve!";
    } else {
        $_SESSION['error_message'] = "Hiba történt a törlés során!";
    }
    
    $stmt->close();
    $dbconn->close();
    
    header("Location: farm_states.php");
    exit();
}

$_SESSION['error_message'] = "Érvénytelen kérés!";
header("Location: farm_states.php");
exit();
?>
