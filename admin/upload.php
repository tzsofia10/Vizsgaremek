<?php
$uploadDir = "../uploads/"; // Feltöltési mappa
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$uploadedFile = $uploadDir . basename($_FILES['upload']['name']);
$response = ['uploaded' => false];

if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadedFile)) {
    $response = [
        'uploaded' => true,
        'url' => $uploadDir . basename($_FILES['upload']['name'])
    ];
} else {
    $response['error'] = [
        'message' => 'A fájl feltöltése sikertelen volt.'
    ];
}

echo json_encode($response);
?>
