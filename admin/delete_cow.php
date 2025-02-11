<?php
require '../connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM cows WHERE id = $id";
    if ($dbconn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
