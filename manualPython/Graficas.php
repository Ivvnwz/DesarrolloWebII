<?php require 'proteger.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficas</title>
    <link rel="shortcut icon" href="../imagenes/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../css/estilos.css?v=20261026">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>
<body>
    <?php include 'menuPython.html'; ?>
    <section>
        <?php include 'saludo.php'; ?>
        <h1>Gráficas</h1>
        <p>Según el referente de BI: <em>primero la pregunta, después el gráfico</em>.</p>

        <h3>Comparación (barras)</h3>
        <div class="lienzo-grafica"><canvas id="graficoBarras"></canvas></div>

        <h3>Evolución (líneas)</h3>
        <div class="lienzo-grafica"><canvas id="graficoLineas"></canvas></div>

        <h3>Composición (dona)</h3>
        <div class="lienzo-grafica lienzo-dona"><canvas id="graficoDona"></canvas></div>
    </section>
    <?php include '../pie.html'; ?>

    <script>
        // Tipografía y colores comunes a las tres gráficas
        Chart.defaults.font.family = "'Inter', 'Segoe UI', sans-serif";
        Chart.defaults.color = '#6B7684';
        Chart.defaults.maintainAspectRatio = false;

        // Comparación
        new Chart(document.getElementById('graficoBarras'), {
            type: 'bar',
            data: {
                labels: ['Centro', 'Norte', 'Sur', 'Oriente', 'Occidente'],
                datasets: [{
                    label: 'Ventas vs meta (millones)',
                    data: [128, 112, 97, 84, 71],
                    backgroundColor: '#1F5F99',
                    borderRadius: 4
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
                    borderColor: '#E08A1E',
                    borderWidth: 2,
                    backgroundColor: 'rgba(224,138,30,0.12)',
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
                    backgroundColor: ['#1F5F99', '#2A9D8F', '#E08A1E'],
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            }
        });
    </script>
</body>
</html>