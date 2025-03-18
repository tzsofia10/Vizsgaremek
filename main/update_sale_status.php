<?php
require "../connect.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
/*error_log("DEBUG: Kapott POST adatok: " . print_r($_POST, true));
echo "<pre>";
print_r($_POST);
echo "</pre>";
exit;*/


// Ellenőrizzük, hogy valóban POST kérés érkezett-e
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    error_log("HIBA: Nem POST kérés érkezett! Érkezett: " . $_SERVER["REQUEST_METHOD"]);
    echo "Hibás kérés";
    echo $_SERVER["REQUEST_METHOD"];
    exit;
}

// Ellenőrizzük, hogy minden szükséges adat megérkezett-e
if (!isset($_POST["sale_id"], $_POST["name"], $_POST["address"], $_POST["house_number"], $_POST["phone"], $_POST["city"])) {
    error_log("HIBA: Hiányzó POST adatok! Érkezett adatok: " . print_r($_POST, true));
    echo "missing_data";
    echo $_POST["sale_id"], $_POST["name"], $_POST["address"], $_POST["house_number"], $_POST["phone"], $_POST["city"];
    exit;
}

// Adatok kinyerése
$sale_id = intval($_POST["sale_id"]);
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
/*if (!preg_match('/^\d{10,11}$/', $phone)) {
    error_log("HIBA: Érvénytelen telefonszám: " . $phone);
    echo "invalid_phone";
    exit;
}*/

// Város ellenőrzése vagy beszúrása
$settlements_id = null;
$check_city_sql = "SELECT id FROM settlements WHERE town = ?";
$stmt = $dbconn->prepare($check_city_sql);
if (!$stmt) {
    error_log("HIBA: Város ellenőrzése sikertelen - " . $dbconn->error);
    echo "db_error";
    exit;
}
$stmt->bind_param("s", $city);
$stmt->execute();
$stmt->bind_result($settlements_id);
$stmt->fetch();
$stmt->close();

// Ha a város nem létezik, beszúrjuk
if (!$settlements_id) {
    $insert_city_sql = "INSERT INTO settlements (town) VALUES (?)";
    $stmt = $dbconn->prepare($insert_city_sql);
    if (!$stmt) {
        error_log("HIBA: Város beszúrás előkészítése sikertelen - " . $dbconn->error);
        echo "db_error";
        exit;
    }
    $stmt->bind_param("s", $city);
    if ($stmt->execute()) {
        $settlements_id = $stmt->insert_id;
    } else {
        error_log("HIBA: Város beszúrás sikertelen - " . $stmt->error);
        echo "db_error";
        exit;
    }
    $stmt->close();
}

// Vásárló beszúrása a customers táblába
$customer_sql = "INSERT INTO customer (name, street, house_number, phone_number, settlements_id) VALUES (?, ?, ?, ?, ?)";



$stmt = $dbconn->prepare($customer_sql);
if (!$stmt) {
    error_log("HIBA: Vásárló beszúrás előkészítés sikertelen - " . $dbconn->error);
    echo "db_error";
    exit;
}

$stmt->bind_param("sssii", $name, $address, $house_number, $phone, $settlements_id);


if (!$stmt->execute()) {
    error_log("HIBA: Vásárló beszúrás sikertelen - " . $stmt->error);
    echo "db_error";
    exit;
}
$customer_id = $stmt->insert_id;
$stmt->close();

// Sales frissítése
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

$dbconn->close();
?>
