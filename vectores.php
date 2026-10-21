<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vectores</title>
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <?php include 'menu.html'; ?>
    <section>
        <?php include 'manualPython/saludo.php'; ?>
        <h1>Vectores (Arrays) en PHP</h1>
        <p>Un vector es una variable que guarda varios valores bajo un mismo nombre.</p>

        <h3>1. Vector indexado</h3>
        <pre><code>&lt;?php
$frutas = ["Manzana", "Pera", "Uva"];
echo $frutas[0]; // Manzana
?&gt;</code></pre>

        <h3>2. Vector asociativo</h3>
        <pre><code>&lt;?php
$persona = ["nombre" => "Ana", "edad" => 25];
echo $persona["nombre"];
?&gt;</code></pre>

        <h3>3. Recorrer un vector</h3>
        <pre><code>&lt;?php
foreach ($frutas as $fruta) {
    echo $fruta . "&lt;br&gt;";
}
?&gt;</code></pre>

        <h3>4. Ejemplo en vivo</h3>
        <?php
        $notas = [4.5, 3.2, 5.0, 2.8, 4.0];
        $suma = array_sum($notas);
        $promedio = $suma / count($notas);
        echo "<ul>";
        foreach ($notas as $i => $n) {
            echo "<li>Nota " . ($i + 1) . ": $n</li>";
        }
        echo "</ul>";
        echo "<p><strong>Promedio:</strong> " . round($promedio, 2) . "</p>";
        ?>
    </section>
    <?php include 'pie.html'; ?>
</body>

</html>