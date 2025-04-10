<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Érvénytelen vagy hiányzó ID.");
}

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require '../connect.php';
require 'pdf/fpdf.php';

$id = (int)$_GET['id'];

// Lekérdezés a tehén adatainak lekéréséhez
$sql = "SELECT 
            cows.id AS cow_id, 
            cows.ear_tag, 
            cows.gender, 
            cows.mother_ear_tag, 
            colors.colors AS color, 
            cows.birthdate,
            cows.picture,
            cows.death_date
        FROM cows
        LEFT JOIN colors ON cows.color_id = colors.id
        WHERE cows.id = $id";

$result = $dbconn->query($sql);

if ($result->num_rows === 0) {
    die("Nem található adat a megadott ID-val.");
}

$row = $result->fetch_assoc();

$gender = $row['gender'] == 1 ? "Hím" : "Nőstény";
$birthdate = $row['birthdate'] ?? 'N/A';
$deathdate = $row['death_date'] ?? 'Nincs adat';
$color = $row['color'] ?? 'Nincs adat';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Tehén adatai', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Azonosító:', 0, 0);
$pdf->Cell(100, 10, $row['cow_id'], 0, 1);
$pdf->Cell(50, 10, 'Fülszám:', 0, 0);
$pdf->Cell(100, 10, $row['ear_tag'], 0, 1);
$pdf->Cell(50, 10, 'Nem:', 0, 0);
$pdf->Cell(100, 10, $gender, 0, 1);
$pdf->Cell(50, 10, 'Anya fülszáma:', 0, 0);
$pdf->Cell(100, 10, $row['mother_ear_tag'], 0, 1);
$pdf->Cell(50, 10, 'Szín:', 0, 0);
$pdf->Cell(100, 10, $color, 0, 1);
$pdf->Cell(50, 10, 'Születési dátum:', 0, 0);
$pdf->Cell(100, 10, $birthdate, 0, 1);
$pdf->Cell(50, 10, 'Elhullás dátuma:', 0, 0);
$pdf->Cell(100, 10, $deathdate, 0, 1);

// PDF mentése a felhasználónak letöltésre
$pdf->Output('D', 'tehen_'.$row['ear_tag'].'.pdf');
exit();
