<?php
session_start();

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}
require "../connect.php";

// Lekérdezzük a foglalt teheneket
$sql = "SELECT * FROM cows WHERE status = 'booked'";
$result = $dbconn->query($sql);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foglalások</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            width: 250px;
            text-align: center;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <h1>Foglalások</h1>
    <div class="container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                    <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                    <p><strong>Kora:</strong> <?php echo htmlspecialchars($row['age']); ?> év</p>
                    <p><strong>Fajta:</strong> <?php echo htmlspecialchars($row['breed']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nincsenek foglalt tehenek.</p>
        <?php endif; ?>
    </div>
</body>
</html>
