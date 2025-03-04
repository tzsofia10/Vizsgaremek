<?php
$host = 'localhost';
$dbname = 'gazdanaplo';
$username = 'felhasznalo';
$password = 'ferkotanya';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT halalozasi_datum FROM tehenek WHERE halalozasi_datum IS NOT NULL";
    $stmt = $pdo->query($query);

    $cowDeaths = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $year = date('Y', strtotime($row['halalozasi_datum']));
        if (!isset($cowDeaths[$year])) {
            $cowDeaths[$year] = 0;
        }
        $cowDeaths[$year]++;
    }

    header('Content-Type: application/json');
    echo json_encode($cowDeaths);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tehenek Halálozási Aránya</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<h2>Tehenek Halálozási Aránya Évek Szerint</h2>
<canvas id="cowDeathChart" width="600" height="400"></canvas>
<script>
        $(document).ready(function () {
        $.ajax({
            url: 'test.php', // Módosítsd a helyes PHP fájl elérési útjára!
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.error) {
                    console.error("Hiba:", response.error);
                    return;
                }

                const labels = Object.keys(response);
                const data = Object.values(response);

                new Chart(document.getElementById('cowDeathChart'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Halálozások száma',
                            data: data,
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error("AJAX hiba:", error);
            }
        });
    });

</script>
</body>
</html>
