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
    <button class="close-btn" id="close-checkout">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
    <div class="card cart">
        <label class="title">CHECKOUT</label>
        <div class="steps">
            <div class="step">
                <span>Szállítás</span>
                <hr>
                    <div class="details">
                        <label for="name">Név:</label>
                        <input type="text" id="name" placeholder="Név megadása" required>
                            <br>
                        <label for="address">Lakcím:</label>
                        <input type="text" id="address" placeholder="Lakcím megadása" required>
                            <br>
                        <label for="phone">Telefonszám:</label>
                        <input type="tel" id="phone" placeholder="Telefonszám megadása" required>

                    <span>Ár:</span> <span id="checkout-price">0 HUF</span>
            </div>
            </div>
        </div>
    </div>

    <div class="card checkout">
        <div class="footer">
            <button class="checkout-btn">Checkout</button>
        </div>
    </div>
</div>

<footer>
    <?php include '../main/footer.php'; ?>
</footer>

<script>
    // Összes vásárlás gombra eseményfigyelő
    document.querySelectorAll('.purchase-button').forEach(button => {
        button.addEventListener('click', function() {
            let price = this.getAttribute('data-price');
            document.getElementById('checkout-price').innerText = price + " HUF";

            // Fizetési rész megjelenítése
            document.getElementById('checkout-container').style.display = 'block';
        });
        // Bezárás függvény
        document.getElementById("close-checkout").addEventListener("click", function() {
    document.getElementById("checkout-container").style.display = "none";

        });
    });
    document.querySelectorAll('.purchase-button').forEach(button => {
    button.addEventListener('click', function() {
        let price = this.getAttribute('data-price');

        // Tizedesjegyek levágása, ha nincs szükség rá
        let formattedPrice = parseInt(price).toLocaleString('hu-HU') + " HUF";
        
        document.getElementById('checkout-price').innerText = formattedPrice;

        // Fizetési rész megjelenítése
        document.getElementById('checkout-container').style.display = 'block';
    });
});



</script>

</body>
</html>

<?php
$conn->close();
?>
