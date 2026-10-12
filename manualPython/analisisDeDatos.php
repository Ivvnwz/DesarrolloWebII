<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    shell_exec('python generar_grafica.py 2>&1');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Análisis de Datos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <?php include 'menuPython.html'; ?>
    <section>
        <h3><?php include 'saludo.php'; ?></h3>
        <h1>Análisis de datos con Python</h1>
        <form method="POST">
            <button type="submit">Generar gráfica desde CSV</button>
        </form>
        <?php if (file_exists('datos/grafica.png')): ?>
            <img src="datos/grafica.png?<?= time() ?>" alt="Gráfica generada" style="max-width:100%">
        <?php endif; ?>
    </section>
</body>
</html>