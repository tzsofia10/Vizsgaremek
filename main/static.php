<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szarvasmarhák Halálozási Diagram</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/staticcss.css">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            margin: 0; 
            padding: 20px; 
        }
        .chart-container {
            width: 90%; 
            max-width: 1200px; /* Nagyobb méret */
            margin: auto;
        }
        canvas { 
            width: 100% !important; 
            height: 500px !important; /* Magasság növelése */
        }
    </style>
</head>
<body>
    <?php include '../main/nav.php'; ?>
    
    <h2>Szarvasmarhák Halálozási Diagram</h2>
   
    <div class="chart-container">
        <canvas id="deathChart"></canvas>
    </div>

    <script>
        // Fetch death data from PHP
        fetch('get_deaths.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.month);
                const counts = data.map(item => item.count);

                // Create chart
                new Chart(document.getElementById('deathChart'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Halálesetek száma',
                            data: counts,
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                ticks: { font: { size: 16 } } // X tengely betűméret
                            },
                            y: { 
                                beginAtZero: true,
                                ticks: { font: { size: 16 } } // Y tengely betűméret
                            }
                        },
                        plugins: {
                            legend: {
                                labels: { font: { size: 18 } } // Jelmagyarázat mérete
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Hiba a lekérdezés során:', error));
    </script>

    <footer>
        <?php include '../main/footer.php'; ?>
    </footer>
</body>
</html>
