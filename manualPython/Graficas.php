<?php require 'proteger.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gráficas</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>
<body>
    <?php include 'menuPython.html'; ?>
    <section>
        <h3><?php include 'saludo.php'; ?></h3>
        <h1>Gráficas</h1>
        <p>Según el referente de BI: <em>primero la pregunta, después el gráfico</em>.</p>

        <h3>Comparación (barras)</h3>
        <canvas id="graficoBarras" height="120"></canvas>

        <h3>Evolución (líneas)</h3>
        <canvas id="graficoLineas" height="120"></canvas>

        <h3>Composición (dona)</h3>
        <canvas id="graficoDona" height="120"></canvas>
    </section>

    <script>
        // Comparación
        new Chart(document.getElementById('graficoBarras'), {
            type: 'bar',
            data: {
                labels: ['Centro', 'Norte', 'Sur', 'Oriente', 'Occidente'],
                datasets: [{
                    label: 'Ventas vs meta (millones)',
                    data: [128, 112, 97, 84, 71],
                    backgroundColor: '#0a4b8c'
                }]
            },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });

        // Evolución
        new Chart(document.getElementById('graficoLineas'), {
            type: 'line',
            data: {
                labels: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
                datasets: [{
                    label: 'Ventas 2026',
                    data: [62,60,68,72,76,74,80,82,86,92,110,128],
                    borderColor: '#ff8c00',
                    backgroundColor: 'rgba(255,140,0,0.15)',
                    tension: 0.3,
                    fill: true
                }]
            }
        });

        // Composición
        new Chart(document.getElementById('graficoDona'), {
            type: 'doughnut',
            data: {
                labels: ['Ropa', 'Calzado', 'Accesorios'],
                datasets: [{
                    data: [60, 34, 26],
                    backgroundColor: ['#0a4b8c', '#00a8ff', '#ff8c00']
                }]
            }
        });
    </script>
</body>
</html>