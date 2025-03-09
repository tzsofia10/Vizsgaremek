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
<div class="container" id="checkout-container">
        <div class="card cart">
            <label class="title">CHECKOUT</label>
            <div class="steps">
                <div class="step">
                    <span>SHIPPING</span>
                    <hr>
                    <span>PAYMENT</span>
                    <div class="details">
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
        });
    </script>

</body>
</html>

<?php
$conn->close();
?>
