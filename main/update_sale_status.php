<?php


require "../connect.php";

$method = $_SERVER["REQUEST_METHOD"];
print_r($method);
$sale_id = intval($_GET["sale_id"]);
if (isset($_POST["sale_id"], $_POST["name"], $_POST["address"], $_POST["house_number"], $_POST["phone"], $_POST["city"])) {

    print_r($sale_id);
    $name = trim($_POST["name"]);
    $address = trim($_POST["address"]);
    $house_number = trim($_POST["house_number"]);
    $phone = trim($_POST["phone"]);
    $city = trim($_POST["city"]);

    // Ellenőrzés: Üres mezők vagy nem numerikus sale_id
    if (empty($name) || empty($address) || empty($house_number) || empty($phone) || empty($city) || !is_numeric($sale_id)) {
        error_log("HIBA: Hiányzó vagy érvénytelen adat!");
        echo "invalid_data";
        exit;
    }

    // Telefonszám ellenőrzés
    if (!preg_match('/^\d{10,11}$/', $phone)) {
        error_log("HIBA: Érvénytelen telefonszám: " . $phone);
        echo "invalid_phone";
        exit;
    }

    // Város keresése vagy beszúrása
    $settlement_id = null;
    $check_city_sql = "SELECT id FROM settlement WHERE name = ?";
    $stmt = $dbconn->prepare($check_city_sql);
    $stmt->bind_param("s", $city);
    $stmt->execute();
    $stmt->bind_result($settlement_id);
    $stmt->fetch();
    $stmt->close();

    if (!$settlement_id) {
        $insert_city_sql = "INSERT INTO settlement (name) VALUES (?)";
        $stmt = $dbconn->prepare($insert_city_sql);
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

    // Vásárló beszúrása customers táblába
    $customer_sql = "INSERT INTO customers (name, address, house_number, phone, settlement_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $dbconn->prepare($customer_sql);
    if (!$stmt) {
        error_log("HIBA: customers beszúrás előkészítés sikertelen - " . $dbconn->error);
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

    // sales frissítése
    $update_sql = "UPDATE sales SET sale_status = 1, customer_id = ? WHERE id = ?";
    $stmt = $dbconn->prepare($update_sql);
    if (!$stmt) {
        error_log("HIBA: sales frissítés előkészítés sikertelen - " . $dbconn->error);
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

$dbconn->close();
?>
