<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require '../connect.php';
require 'pdf/fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Szarvasmarha adatok', 0, 1, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);

// Ha egy konkrét ID van megadva
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
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
} else {
    // Szűrés: all, alive, dead
    $filter = $_GET['filter'] ?? 'all';
    if ($filter === 'alive') {
        $where = "WHERE cows.death_date IS NULL";
    } elseif ($filter === 'dead') {
        $where = "WHERE cows.death_date IS NOT NULL";
    } else {
        $where = "";
    }

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
            $where
            ORDER BY cows.id";
}

$result = $dbconn->query($sql);

if ($result->num_rows === 0) {
    die("Nem található adat.");
}

// Több adat esetén mindegyiket belerakjuk
while ($row = $result->fetch_assoc()) {
    $gender_raw = $row['gender'] == 1 ? "Hím" : "Nőstény";
    $gender = utf8_decode($gender_raw);
    
    $birthdate = $row['birthdate'] ?? 'N/A';
    $deathdate = $row['death_date'] ?? 'Nincs adat';
    $color = $row['color'] ?? 'Nincs adat';

    $pdf->Cell(50, 10, utf8_decode('Fülszám:'), 0, 0);
    $pdf->Cell(100, 10, utf8_decode($row['ear_tag']), 0, 1);
    $pdf->Cell(50, 10, 'Nem:', 0, 0);
    $pdf->Cell(100, 10, $gender, 0, 1);
    $pdf->Cell(50, 10, utf8_decode('Anya fülszám:'), 0, 0);
    $pdf->Cell(100, 10, $row['mother_ear_tag'], 0, 1);
    $pdf->Cell(50, 10, utf8_decode('Szín:'), 0, 0);
    $pdf->Cell(100, 10, $color, 0, 1);
    $pdf->Cell(50, 10, utf8_decode('Születési dátum:'), 0, 0);
    $pdf->Cell(100, 10, $birthdate, 0, 1);

    // Csak akkor jelenjen meg, ha nem élő szűrés van
    if (!isset($filter) || $filter !== 'alive') {
        $pdf->Cell(50, 10, utf8_decode('Elhullás dátuma:'), 0, 0);
        $pdf->Cell(100, 10, $deathdate, 0, 1);
    }

    $pdf->Ln(10); // Szóköz a tehenek között
}

// Dinamikus fájlnév a szűrő alapján
$filename = 'szarvasmarha_lista' . ($filter ?? '_egyedi') . '.pdf';
$pdf->Output('D', $filename);
exit();
?>
