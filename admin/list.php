<?php

session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Ha nincs bejelentkezve, irányítsuk át a bejelentkezési oldalra
    header("Location: index.php");
    exit();
}
require "../connect.php";

// Cikkek lekérdezése az adatbázisból
$query = "SELECT id, alias, nav_name, creation, states FROM news ORDER BY creation DESC";
$result = mysqli_query($dbconn, $query);

if (!$result) {
    die("Hiba az adatbázis lekérdezése során: " . mysqli_error($dbconn));
}
?>

<!DOCTYPE html>
<html lang="hu">
<?php 
    $page_title = "Cikkek"; 
    $custom_css = ["../css/pages/editcow.css", "../css/pages/list.css", "../css/footer.css"]; 
    $custom_js = ["../js/translate2.js" ]; 
    $additional_head = "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    include '../main/head.php'; 
?>

<body>
    <div class="page-container">
        <?php include '../main/nav.php'; ?>
        
        <div class="content-wrapper">
            <h1>Cikkek listája</h1>
            <div class="table-container">
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Alias</th>
                            <th>Navigációs név</th>
                            <th>Létrehozás dátuma</th>
                            <th>Állapot</th>
                            <th>Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= htmlspecialchars($row['alias']) ?></td>
                                    <td><?= htmlspecialchars($row['nav_name']) ?></td>
                                    <td><?= htmlspecialchars($row['creation']) ?></td>
                                    <td><?= $row['states'] == 1 ? 'Aktív' : 'Inaktív' ?></td>
                                    <td>
                                        <a href="edit.php?id=<?= $row['id'] ?>">Módosítás</a> |
                                        <a href="javascript:void(0)" onclick="confirmDelete(<?= $row['id'] ?>, '<?= htmlspecialchars($row['nav_name'], ENT_QUOTES) ?>')">Törlés</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">Nincsenek elérhető cikkek.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <p><a id="article" href="content_management.php">Új cikk hozzáadása</a></p>
        </div>

        <footer>
            <?php include '../main/footer.php';?>
        </footer>
    </div>

    <script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Biztos törölni szeretnéd?',
            text: `"${name}" cikk törlése véglegesen megtörténik!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Igen, törlöm!',
            cancelButtonText: 'Mégse'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `delete.php?id=${id}`;
            }
        });
    }

    // Ha van URL paraméterben üzenet, azt is jelenítsük meg
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const message = urlParams.get('message');
        
        if (message) {
            Swal.fire({
                icon: 'success',
                title: 'Sikeres művelet!',
                text: message,
                confirmButtonColor: '#28a745'
            });
        }
    });
    </script>

    <?php
    if (isset($_SESSION['swal_message'])) {
        $message = $_SESSION['swal_message'];
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '" . $message['type'] . "',
                    title: '" . $message['title'] . "',
                    text: '" . $message['text'] . "',
                    confirmButtonColor: '" . ($message['type'] == 'success' ? '#28a745' : '#dc3545') . "'
                });
            });
        </script>";
        unset($_SESSION['swal_message']);
    }
    ?>
</body>
</html>

