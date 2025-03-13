<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gazdanaplo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["sale_id"], $_POST["name"], $_POST["address"], $_POST["house_number"], $_POST["phone"], $_POST["city"])) {
    $sale_id = $_POST["sale_id"];
    $name = trim($_POST["name"]);
    $address = trim($_POST["address"]);
    $house_number = trim($_POST["house_number"]);
    $phone = trim($_POST["phone"]);
    $city = trim($_POST["city"]);

    if (empty($name) || empty($address) || empty($house_number) || empty($phone) || empty($city) || !is_numeric($sale_id)) {
        error_log("HIBA: Hiányzó vagy érvénytelen adat!");
        echo "invalid_data";
        exit;
    }

    if (!preg_match('/^\d{10,11}$/', $phone)) {
        error_log("HIBA: Érvénytelen telefonszám: " . $phone);
        echo "invalid_phone";
        exit;
    }

    // ✅ 1. Város ellenőrzése és beszúrása, ha nem létezik
    $settlement_id = null;
    $check_city_sql = "SELECT id FROM settlement WHERE name = ?";
    $stmt = $conn->prepare($check_city_sql);
    $stmt->bind_param("s", $city);
    $stmt->execute();
    $stmt->bind_result($settlement_id);
    $stmt->fetch();
    $stmt->close();

    if (!$settlement_id) {
        $insert_city_sql = "INSERT INTO settlement (name) VALUES (?)";
        $stmt = $conn->prepare($insert_city_sql);
        $stmt->bind_param("s", $city);
        if ($stmt->execute()) {
            $settlement_id = $stmt->insert_id;
        } else {
            error_log("HIBA: Város beszúrás sikertelen - " . $stmt->error);
            echo "db_error";
            exit;
        }
        $stmt->close();
    }

    // ✅ 2. Vásárló beszúrása `customers` táblába
    $customer_sql = "INSERT INTO customers (name, address, house_number, phone, settlement_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($customer_sql);
    if (!$stmt) {
        error_log("HIBA: customers beszúrás előkészítés sikertelen - " . $conn->error);
        echo "db_error";
        exit;
    }

    $stmt->bind_param("sssii", $name, $address, $house_number, $phone, $settlement_id);
    if (!$stmt->execute()) {
        error_log("HIBA: customers beszúrás sikertelen - " . $stmt->error);
        echo "db_error";
        exit;
    }
    $customer_id = $stmt->insert_id;
    $stmt->close();

    // ✅ 3. `sales` frissítése
    $update_sql = "UPDATE sales SET sale_status = 1, customer_id = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    if (!$stmt) {
        error_log("HIBA: sales frissítés előkészítés sikertelen - " . $conn->error);
        echo "db_error";
        exit;
    }

    $stmt->bind_param("ii", $customer_id, $sale_id);
    if ($stmt->execute()) {
        echo "success";
    } else {
        error_log("HIBA: sales frissítés sikertelen - " . $stmt->error);
        echo "db_error";
    }
    $stmt->close();
} else {
    error_log("HIBA: Hiányzó POST adatok!");
    echo "missing_data";
}

$conn->close();
?>
