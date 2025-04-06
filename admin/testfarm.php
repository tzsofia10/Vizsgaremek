<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require '../connect.php';

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';  // Alapértelmezett szűrő: 'all'

$records_per_page = 5;  // Oldalanként megjelenő rekordok száma

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Szűrési feltétel
if ($filter === 'alive') {
    $total_records_query = "SELECT COUNT(*) AS total FROM cows WHERE death_date IS NULL";
    $sql = "SELECT cows.id AS cow_id, cows.ear_tag, cows.gender, cows.mother_ear_tag, colors.colors AS color, cows.birthdate, cows.picture, cows.death_date
            FROM cows
            LEFT JOIN colors ON cows.color_id = colors.id
            WHERE cows.death_date IS NULL
            ORDER BY cows.id
            LIMIT $records_per_page OFFSET $offset";
} elseif ($filter === 'dead') {
    $total_records_query = "SELECT COUNT(*) AS total FROM cows WHERE death_date IS NOT NULL";
    $sql = "SELECT cows.id AS cow_id, cows.ear_tag, cows.gender, cows.mother_ear_tag, colors.colors AS color, cows.birthdate, cows.picture, cows.death_date
            FROM cows
            LEFT JOIN colors ON cows.color_id = colors.id
            WHERE cows.death_date IS NOT NULL
            ORDER BY cows.id
            LIMIT $records_per_page OFFSET $offset";
} else {
    // Minden tehén
    $total_records_query = "SELECT COUNT(*) AS total FROM cows";
    $sql = "SELECT cows.id AS cow_id, cows.ear_tag, cows.gender, cows.mother_ear_tag, colors.colors AS color, cows.birthdate, cows.picture, cows.death_date
            FROM cows
            LEFT JOIN colors ON cows.color_id = colors.id
            ORDER BY cows.id
            LIMIT $records_per_page OFFSET $offset";
}

$total_result = $dbconn->query($total_records_query);
$total_records = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

$result = $dbconn->query($sql);
?>
<!DOCTYPE html>
<html lang="hu">
<?php 
    $page_title = "Lista"; 
    $custom_css = ["../css/pages/farmSate.css", "../css/delete.css", "../css/table.css"]; 
    $custom_js = ["../js/search.js", "../js/delete.js", "../js/translate2.js", "../js/pagination.js"]; 
    $additional_head = "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>"; 
    include '../main/head.php'; 
?>
<body>
    <?php include '../main/nav.php'; ?>

    <main>
        <h1>Szarvasmarha lista</h1>

        <!-- Kereső mező hozzáadása -->
        <div class="search-box">
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Fülszám keresése...">
        </div>

        <div class="filter-buttons">
            <a href="?filter=all&page=1" class="<?php echo $filter === 'all' ? 'active' : ''; ?>">Összes</a>
            <a href="?filter=alive&page=1" class="<?php echo $filter === 'alive' ? 'active' : ''; ?>">Élők</a>
            <a href="?filter=dead&page=1" class="<?php echo $filter === 'dead' ? 'active' : ''; ?>">Elhullottak</a>
        </div>

        <?php
        if ($result->num_rows > 0) {
            echo "<table id='myTable'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kép</th>
                            <th>Fülszám</th>
                            <th>Nem</th>
                            <th>Anya fülszám</th>
                            <th>Szín</th>
                            <th>Születési dátum</th>";

            // Ha nem az "alive" szűrőt választották, akkor jelenjen meg a "Halálozási dátum" oszlop
            if ($filter !== 'alive') {
                echo "<th>Halálozási dátum</th>";
            }

            echo "</tr>
                    </thead>
                    <tbody>";
            while ($row = $result->fetch_assoc()) {
                $gender = $row['gender'] == 1 ? "Hím" : "Nőstény";
                $color = $row['color'] ?? 'N/A';
                $picture = !empty($row['picture']) ? htmlspecialchars($row['picture']) : '../cowPicture/nopicture.jpg';
                $death_date = $row['death_date'] ? htmlspecialchars($row['death_date']) : 'N/A';

                echo "<tr>
                        <td>" . htmlspecialchars($row['cow_id']) . "</td>
                        <td><img src='" . $picture . "' alt='Tehén Kép'></td>
                        <td>" . htmlspecialchars($row['ear_tag']) . "</td>
                        <td>" . htmlspecialchars($gender) . "</td>
                        <td>" . htmlspecialchars($row['mother_ear_tag']) . "</td>
                        <td>" . htmlspecialchars($color) . "</td>
                        <td>" . htmlspecialchars($row['birthdate']) . "</td>";

                // Ha az "Összes" szűrőt választották és nincs halálozási dátum, akkor írd ki, hogy "Nem elhullott"
                if ($filter === 'all') {
                    $death_date_display = empty($row['death_date']) ? 'Nem elhullott' : $death_date;
                    echo "<td>" . $death_date_display . "</td>";
                } elseif ($filter !== 'alive') {
                    // Ha nem az "alive" szűrő, akkor egyszerűen a halálozási dátumot jelenítsd meg
                    echo "<td>" . $death_date . "</td>";
                }

                echo "</tr>";
            }
            echo "</tbody></table>";

            // Lapozó gombok
            echo "<div class='pagination'>";
            if ($page > 1) {
                echo "<a href='?filter=$filter&page=" . ($page - 1) . "'>&laquo; Előző</a>";
            }
            if ($page > 3) {
                echo "<a href='?filter=$filter&page=1'>1</a>";
                if ($page > 4) {
                    echo "<span class='dots'>...</span>";
                }
            }
            for ($i = max(1, $page - 1); $i <= min($total_pages, $page + 1); $i++) {
                echo "<a href='?filter=$filter&page=$i'" . ($i == $page ? " class='active'" : "") . ">$i</a>";
            }
            if ($page < $total_pages - 2) {
                if ($page < $total_pages - 3) {
                    echo "<span class='dots'>...</span>";
                }
                echo "<a href='?filter=$filter&page=$total_pages'>$total_pages</a>";
            }
            if ($page < $total_pages) {
                echo "<a href='?filter=$filter&page=" . ($page + 1) . "'>Következő &raquo;</a>";
            }
            echo "</div>";
        } else {
            echo "<p>Nincs adat a táblázatban.</p>";
        }

        $dbconn->close();
        ?>
    </main>

    <footer>
        <?php include '../main/footer.php'; ?>
    </footer>

    <script>
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2]; // Fülszám oszlop indexe (3. oszlop)
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>