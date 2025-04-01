<?php
require_once '..\connect.php';

$sql = "SELECT * FROM vaccination_types";
$result = $dbconn->query($sql);
?>

<!DOCTYPE html>
<html lang="hu">
 <!-- <head> része-->
 <?php 
    $page_title = "Olt'sok"; 
    $custom_css = ["../css/vaccination.css"]; // egyedi css fájl hozzáadása
    include '../main/head.php'; 
?>
<!-- </head> rész vége-->

<body>
    <?php include '../main/nav.php'; ?>
    <h2>Oltástípusok</h2>
    <table>
        <tr><th>ID</th><th>Név</th></tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr onclick=\"toggleDescription({$row['id']})\" style='cursor: pointer;'><td>{$row['id']}</td><td>{$row['name']}</td></tr>";
                echo "<tr><td class='ajajj' colspan='2'><div id='desc-{$row['id']}' class='description'>{$row['description']}</div></td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Nincs elérhető adat</td></tr>";
        }
        mysqli_close($dbconn);
        ?>
    </table>

    <script>
        function toggleDescription(id) {
            var desc = document.getElementById('desc-' + id);
            if (desc.classList.contains('show')) {
                desc.classList.remove('show');
            } else {
                desc.classList.add('show');
            }
        }
    </script>
    <footer>
        <?php include '../main/footer.php'; ?>
    </footer>
</body>
</html>
