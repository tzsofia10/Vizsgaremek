<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require '../connect.php';

$records_per_page = 5;

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

$total_records_query = "SELECT COUNT(*) AS total FROM cows";
$total_result = $dbconn->query($total_records_query);
$total_records = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

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
        ORDER BY cows.id
        LIMIT $records_per_page OFFSET $offset";


$result = $dbconn->query($sql);
?>
<!DOCTYPE html>
<html lang="hu">
 <!-- <head> része-->
 <?php 
    $page_title = "Lista"; 
    $custom_css = ["../css/pages/farmSate.css", "../css/delete.css", "../css/table.css"]; // egyedi css fájl hozzáadása
    $custom_js = ["../js/translate.js", "../js/delete.js", "https://cdn.jsdelivr.net/npm/sweetalert2@11"]; // egyedi js fájlok
    include '../main/head.php'; 
?>
<!-- </head> rész vége-->

<body>
    <header>
        <?php include '../main/nav.php'; ?>
    </header>
    
    <main>
        <h1>Szarvasmarha lista</h1>
        <?php
        if ($result->num_rows > 0) {
            echo "<table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kép</th>
                            <th>Fülszám</th>
                            <th>Nem</th>
                            <th>Anya fülszám</th>
                            <th>Apa fülszám</th>
                            <th>Szín</th>
                            <th>Születési dátum</th>
                            <th colspan='2'>Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>";
    
            while ($row = $result->fetch_assoc()) {
                $color = $row['color'] ?? 'N/A';
                if ($row['gender'] == 1) {
                    $gender = "Hím";
                } else {
                    $gender = "Nőstény";
                }

                $picture = !empty($row['picture']) ? htmlspecialchars($row['picture']) : '../cowPicture/nopicture.jpg';
    
                echo "<tr>
                        <td>" . htmlspecialchars($row['cow_id']) . "</td>
                        <td><img src='" . $picture . "' alt='Tehén Kép'></td>
                        <td>" . htmlspecialchars($row['ear_tag']) . "</td>
                        <td>" . htmlspecialchars($gender) . "</td>
                        <td>" . htmlspecialchars($row['mother_ear_tag']) . "</td>
                        <td>" . htmlspecialchars($row['father_ear_tag']) . "</td>
                        <td class='color'>" . htmlspecialchars($color) . "</td>
                        <td>" . htmlspecialchars($row['birthdate']) . "</td>

                        </td>
                        <td class='btn-update borderRight'>
                            <a href='edit_cow.php?id=" . urlencode($row['cow_id']) . "'>
                                <button class='edit-button'>
                                        <svg class='edit-svgIcon' viewBox='0 0 512 512'>
                                        <path d='M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z'></path>
                                    </svg>
                                </button>
                            </a>
                
                    </td>
                    
                    <td class='btn-update borderRight'>
                    <a href='delete_cow.php?id=" . urlencode($row['cow_id']) . "'>
                    <button class='deleteButton'>
                                <svg viewBox='0 0 448 512' class='svgIcon'><path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z'></path></svg>
                                </button>
                                </a>
                        </td>

                    </tr>";
            }
    
            echo "</tbody></table>";

            // Lapozó gombok
            echo "<div class='pagination'>";
            if ($page > 1) {
                echo "<a href='?page=" . ($page - 1) . "'>&laquo; Előző</a>";
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='?page=$i'" . ($i === $page ? " class='active'" : "") . ">$i</a>";
            }
            if ($page < $total_pages) {
                echo "<a href='?page=" . ($page + 1) . "'>Következő &raquo;</a>";
            }
            echo "</div>";
        } else {
            echo "<p>Nincs adat a táblázatban.</p>";
        }

        $dbconn->close();
        ?>

        <div id="confirmOverlay">
            <div>
                <h3>Biztosan törölni szeretnéd ezt a tehenet?</h3>
                <button id="confirmYes" class="btn btn-success">Igen, törlöm!</button>
                <button id="confirmNo" class="btn btn-danger">Nem, visszavonom</button>
            </div>
        </div>

    </main>
    <footer>
        <?php include '../main/footer.php'; ?>
    </footer>
</body>
</html>