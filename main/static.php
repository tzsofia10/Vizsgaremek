<!DOCTYPE html>
<html lang="hu">

<?php
    $page_title = "Elhullás Diagram";
    $custom_js = ["https://cdn.jsdelivr.net/npm/chart.js"];
    $custom_css = ["../css/staticcss.css"];
    include 'head.php';
?>
<body>
    <?php include '../main/nav.php'; ?>
    
    <h2>Szarvasmarhák Elhullási Diagram</h2>
    <main>
        <div class="chart-container">
            <canvas id="deathChart"></canvas>
        </div>
    </main>
    <script>
        fetch('get_deaths.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.month);
                const counts = data.map(item => item.count);

                new Chart(document.getElementById('deathChart'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Elhullások száma',
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
