<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require '../connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Először lekérjük a tehén adatait
    $select_sql = "SELECT ear_tag FROM cows WHERE id = ?";
    $stmt = $dbconn->prepare($select_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cow = $result->fetch_assoc();
    
    // Törlés végrehajtása
    $delete_sql = "DELETE FROM cows WHERE id = ?";
    $stmt = $dbconn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "A(z) " . $cow['ear_tag'] . " fülszámú tehén sikeresen törölve!";
    } else {
        $_SESSION['error_message'] = "Hiba történt a törlés során!";
    }
    
    $stmt->close();
    $dbconn->close();
    
    header("Location: farm_states.php");
    exit();
}
?>
