<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gazdanaplo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, sales_date, customer_id, price, cows_id FROM sales";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szarvasmarhák eladása</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/selling.css">
    <style>
        .fizetes {
            display: none; /* Alapból elrejtve */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background: rgb(255, 250, 235);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
<?php include '../main/nav.php'; ?>
    <h1>Szarvasmarhák eladása</h1>
    <div class="table-wrapper">
    <table>
        <tr>
            <th>ID</th>
            <th>Eladási Dátum</th>
            <th>Ár (HUF)</th>
            <th>Művelet</th>
        </tr>

        <?php if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["sales_date"] . "</td>
                        <td>" . number_format($row["price"]) . " HUF</td>
                        <td>
                             <button class='purchase-button' data-price='" . $row["price"] . "'>
                                    Vásárlás
                                </button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nincs elérhető adat</td></tr>";
        } ?>
    </table>
</div>

<!-- Checkout Container -->
<div class="fizetes" id="checkout-container">
    <button class="close-btn" id="close-checkout">×</button>
    <div class="card cart">
        <div class="details">
            <label for="name">Név:</label>
            <input type="text" id="name" placeholder="Név megadása" required>
            <label for="address">Lakcím:</label>
            <input type="text" id="address" placeholder="Lakcím megadása" required>
            <label for="phone">Telefonszám:</label>
            <input type="tel" id="phone" placeholder="Telefonszám megadása" required>
            <span>Ár:</span> <span id="checkout-price">0 HUF</span>
        </div>
    </div>
    <div class="card checkout">
        <button class="checkout-btn">Foglalás</button>
    </div>
</div>

<!-- Confirmation Message -->
<div class="confirmation" id="confirmation-box">
    <button class="dismiss" id="close-confirmation">×</button>
    <div class="header">
        <div class="image">
            <svg viewBox="0 0 24 24" fill="none"><path d="M20 7L9.00004 18L3.99994 13" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </div>
    </div>
    <div class="content">
        <span class="title">Foglalás megerősítve</span>
    </div>
</div>

<footer>
    <?php include '../main/footer.php'; ?>
</footer>

<script>
    document.querySelectorAll('.purchase-button').forEach(button => {
        button.addEventListener('click', function() {
            let price = this.getAttribute('data-price');
            document.getElementById('checkout-price').innerText = parseInt(price).toLocaleString('hu-HU') + " HUF";
            document.getElementById('checkout-container').style.display = 'block';
        });
    });

    document.getElementById("close-checkout").addEventListener("click", function() {
        document.getElementById("checkout-container").style.display = "none";
    });

    document.querySelector(".checkout-btn").addEventListener("click", function() {
        document.getElementById("checkout-container").style.display = "none";
        document.getElementById("confirmation-box").style.display = "block";
    });

    document.getElementById("close-confirmation").addEventListener("click", function() {
        document.getElementById("confirmation-box").style.display = "none";
    });
</script>
</body>
</html>

<?php
$conn->close();
?>
