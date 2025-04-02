<?php
require_once '../connect.php';

$sql = "SELECT name, description FROM vaccination_types";
$result = $dbconn->query($sql);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <?php 
        $page_title = "Oltások"; 
        $custom_css = ["../css/vaccination.css"]; // Egyedi CSS fájl hozzáadása
        include '../main/head.php'; 
    ?>
</head>
<body>
    <?php include '../main/nav.php'; ?>
    <main>
        <h1>Oltások</h1>
        <div class="container">
            <div class="vaccination-list">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card" onclick="toggleDescription(this)">
                        <div>
                            <strong><?php echo htmlspecialchars($row['name']); ?></strong>
                            <div class="description">
                                <?php echo htmlspecialchars($row['description']); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
    <script>
        function toggleDescription(element) {
            let desc = element.querySelector(".description");
            if (desc.style.display === "none" || desc.style.display === "") {
                desc.style.display = "block";
                setTimeout(() => { desc.style.opacity = 1; }, 10);
            } else {
                desc.style.opacity = 0;
                setTimeout(() => { desc.style.display = "none"; }, 300);
            }
        }
    </script>
    <footer>
        <?php include '../main/footer.php'; ?>
    </footer>
</body>
</html>
