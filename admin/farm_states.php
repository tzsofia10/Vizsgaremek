<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require '../connect.php';

$limit = 10; 
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1; 
$offset = ($page - 1) * $limit;


$total_sql = "SELECT COUNT(*) AS total FROM cows";
$total_result = $dbconn->query($total_sql);
$total_cows = $total_result->fetch_assoc()['total'];

// Oldalszám kiszámítása
$total_pages = ceil($total_cows / $limit);

// SQL lekérdezés lapozással
$sql = "SELECT 
            cows.id AS cow_id, 
            cows.ear_tag, 
            cows.gender, 
            cows.mother_ear_tag, 
            cows.father_ear_tag, 
            colors.black, 
            colors.brown, 
            colors.white, 
            colors.spotted, 
            cows.birth_date,
            cows.picture
        FROM cows
        LEFT JOIN colors ON cows.color_id = colors.id
        ORDER BY cows.id
        LIMIT $limit OFFSET $offset";

$result = $dbconn->query($sql);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tehén Lista</title>
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/delete.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/pages/farmSate.css">
    <link rel="stylesheet" href="../css/nav.css">
    <script src="../js/translate.js" defer></script>
    <script src="../js/delete.js" defer></script>
</head>
<body>
    <?php include '../main/nav.php'; ?>
    <main>
        <h1>Tehén Lista</h1>
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
                            <th>Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>";
    
            while ($row = $result->fetch_assoc()) {
                $color = $row['black'] ?: ($row['brown'] ?: ($row['white'] ?: ($row['spotted'] ?: 'N/A')));
                $picture = !empty($row['picture']) ? htmlspecialchars($row['picture']) : '../cowPicture/nopicture.jpg';
    
                echo "<tr>
                        <td>" . htmlspecialchars($row['cow_id']) . "</td>
                        <td><img src='" . $picture . "' alt='Tehén Kép'></td>
                        <td>" . htmlspecialchars($row['ear_tag']) . "</td>
                        <td>" . htmlspecialchars($row['gender']) . "</td>
                        <td>" . htmlspecialchars($row['mother_ear_tag']) . "</td>
                        <td>" . htmlspecialchars($row['father_ear_tag']) . "</td>
                        <td class='color'>" . htmlspecialchars($color) . "</td>
                        <td>" . htmlspecialchars($row['birth_date']) . "</td>
                        <td>
                            <button class='deleteButton'>
                                <a href='delete_cow.php?id=" . urlencode($row['cow_id']) . "'>Törlés</a>
                            </button>
                            <button class='editButton'>
                                <a href='edit_cow.php?id=" . urlencode($row['cow_id']) . "'>Módosítás</a>
                            </button>
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
        ?>

        <!-- Lapozó -->
        <div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>" class="prev">&laquo; Előző</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo $page + 1; ?>" class="next">Következő &raquo;</a>
    <?php endif; ?>
</div>

        
    </main>
    <footer>
        <?php 
            include '../main/footer.php';
        ?>
    </footer>
</body>
</html>
