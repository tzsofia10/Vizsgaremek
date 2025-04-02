    <?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");

    require_once "../connect.php";
    $sql = "SELECT id, sales_date, customer_id, price, cows_id, sale_status FROM sales WHERE sale_status = 'available'";
    $result = $dbconn->query($sql);

    // Ha a foglalás gombot megnyomták, frissítjük a státuszt
    if (isset($_POST['sale_id'])) {
        $sale_id = $_POST['sale_id'];
        $update_sql = "UPDATE sales SET sale_status = 'sold' WHERE id = ?";
        $stmt = $dbconn->prepare($update_sql);
        $stmt->bind_param("i", $sale_id);
        $stmt->execute();
        $stmt->close();
        // Redirect, hogy ne küldjön el több kérést
        header("Location: sell.php");
        exit;
    }

    ?>

    <!DOCTYPE html>
    <html lang="hu">
    <?php
        $page_title = "Szarvasmarhák foglalása";
        $custom_js = ["https://cdn.jsdelivr.net/npm/chart.js"];
        $custom_css = ["../css/selling.css"];
        include 'head.php';
    ?>
    <body>
    <?php include '../main/nav.php'; ?>
        <h1>Szarvasmarhák foglalása</h1>
        <div class="table-wrapper">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Meghirdetési Dátum</th>
                    <th>Ár (HUF)</th>
                    <th>Művelet</th>
                </tr>

                <?php if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr id='row-" . $row["id"] . "'>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["sales_date"] . "</td>
                            <td>" . number_format($row["price"]) . " HUF</td>
                            <td>
                                <button class='purchase-button' data-price='" . $row["price"] . "' data-sale-id='" . $row["id"] . "'>
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
    <form method="POST" action="update_sale_status.php">
    <button class="dismiss" id="close-confirmation">×</button>
    <div class="fizetes" id="checkout-container">
        <button class="close-btn" id="close-checkout">×</button>
        <div class="card cart">
            <div class="details">
            <label for="name">Név:</label>
        <input type="text" id="name" placeholder="Név megadása" required>

        <label for="city">Város:</label>
        <input type="text" id="city" placeholder="Város megadása" required>

        <label for="address">Utca:</label>
        <input type="text" id="address" placeholder="Utca megadása" required>

        <label for="house_number">Házszám:</label>
        <input type="text" id="house_number" placeholder="Házszám megadása" required>

        <label for="phone">Telefonszám:</label>
        <input type="tel" id="phone" placeholder="Telefonszám megadása" maxlength="11" pattern="\d{11}" required>


                <span>Ár:</span> <span id="checkout-price">0 HUF</span>
            </div>
        </div>
       <div class="card checkout">
  <form id="checkout-form"> 
    <input type="hidden" id="sale-id" name="sale_id">
    <button class="checkout-btn" type="submit" disabled>Foglalás</button>
  </form>
</div>
    </div>

    <!-- Confirmation Message -->
    <div class="confirmation" id="confirmation-box">
  <div class="header">
    <div class="image">
      <svg viewBox="0 0 24 24" fill="none">
        <circle cx="12" cy="12" r="8" fill="#c8e6c9" />
        <path d="M6 12l3 3l9-9" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </div>
  </div>
  <div class="content">
    <span class="title">Foglalás megerősítve</span>
  </div>
</div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const purchaseButtons = document.querySelectorAll(".purchase-button");
        const checkoutBtn = document.querySelector(".checkout-btn");
        const confirmationBox = document.getElementById("confirmation-box");
        const nameInput = document.getElementById("name");
        const addressInput = document.getElementById("address");
        const cityInput = document.getElementById("city");
        const housenumberInput = document.getElementById("house_number");
        const phoneInput = document.getElementById("phone");
        const saleIdInput = document.getElementById("sale-id");
        console.log("city:",cityInput,"telefon:", phoneInput)
        
        //kitöltés teszt adatokkal
        nameInput.value = "Kovács István";
        addressInput.value = "Rákóczi út";
        cityInput.value = "Egyházasgerge";
        housenumberInput.value = 55;
        phoneInput.value = 10612345678;
    

        /* A user kizárólag csak számot tudjon beírni a telefonszá mezőbe ezért az értékeket \D = minden olyan karakter, ami nem számjegy (0-9 kivételével minden más karakter).
    g = globális mód, vagyis az összes találatot lecseréli, nemcsak az elsőt.
    '' (üres string) – A talált nem számjegy karaktereket törli. 
    phoneInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^\d\+]/g, ''); // Csak számokat és a "+" karaktert engedélyezi
    });
    */

        function validateForm() {
        /* console.log("ValidateForm függvény ezeket az adatokat kapja meg ellenőrzésre: ", nameInput.value, addressInput.value, phoneInput.value, cityInput.value, housenumberInput.value)*/
            if (nameInput.value.trim() !== "" && addressInput.value.trim() !== "" && phoneInput.value.trim().length >= 3 && cityInput.value.trim()!=="" && housenumberInput.value.trim()!=="") {
                checkoutBtn.disabled = false;
            } else {
                checkoutBtn.disabled = true;
            }
        }
    //ha kitöltésre kerülnek az input mezők akkor meghívásra kerül a validáló függvény
        [nameInput, addressInput, phoneInput, cityInput, housenumberInput].forEach(input => {
            input.addEventListener("input", validateForm);
        }); 

        //
        purchaseButtons.forEach(button => {
            button.addEventListener("click", function () {
                let price = this.getAttribute("data-price");
                let saleId = this.getAttribute("data-sale-id");

                document.getElementById("checkout-price").innerText = parseInt(price).toLocaleString("hu-HU") + " HUF";
                document.getElementById("checkout-container").style.display = "block";

                saleIdInput.value = saleId;
                saleIdInput.dataset.rowId = "row-" + saleId;

                validateForm();
            });
        });

        //ha elküldésre kerül a form:
        checkoutBtn.addEventListener("click", function (event) {
        event.preventDefault();
        if (checkoutBtn.disabled) return;

        let saleId = saleIdInput.value;
        let formData = new FormData();
        formData.append("sale_id", saleId);
        formData.append("name", nameInput.value.trim());
        formData.append("address", addressInput.value.trim());
        formData.append("house_number", housenumberInput.value.trim());
        formData.append("phone", phoneInput.value);
        console.log(phoneInput.value.trim())
        formData.append("city", cityInput.value.trim());

        // Adatok kiírása a konzolba
        console.log("Elküldött adatok:", Object.fromEntries(formData.entries()));

        fetch("update_sale_status.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            if (result.trim() === "success") {
                // Sikeres frissítés
                document.getElementById("checkout-container").style.display = "none";
                confirmationBox.style.display = "block";
                confirmationBox.style.opacity = "1";

                // Azonnali megjelenítés, csak az eltűnés legyen animált
                setTimeout(() => {
                    confirmationBox.style.transition = "opacity 1.5s ease-in-out";
                    confirmationBox.style.opacity = "0";
                }, 3000);

                setTimeout(() => {
                    confirmationBox.style.display = "none";
                    let row = document.getElementById(`row-${saleId}`);
                    if (row) {
                        row.classList.add("fade-out");
                        setTimeout(() => { row.remove(); }, 1500);
                    }
                }, 4500);
            } else {
                // ... (hiba kezelése)
            }
        })
        .catch(error => console.error("Hiba:", error));
    });
    })
    document.getElementById("close-checkout").addEventListener("click", function (event) {
        event.preventDefault(); // Megakadályozza az esetleges form submit eseményt
    document.getElementById("checkout-container").style.display = "none";
    });
    phoneInput.addEventListener("input", function () {
    // Csak számokat engedélyez és levágja a felesleget, ha több mint 11 karakter
    this.value = this.value.replace(/\D/g, '').slice(0, 11);
});
setTimeout(function() {
  document.getElementById('confirmation-box').style.display = 'none';
}, 3000); // Disappears after 3 seconds


    </script>

    <footer>
        <?php include '../main/footer.php'; ?>
    </footer>
    </body>
    </html>

    <?php
    $dbconn->close();
    ?>
