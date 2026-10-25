<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variables en PHP - Manual</title>
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        /* Caja para el resultado en pantalla (estilo celeste) */
        .result-container {
            background-color: var(--azul-50);
            border: 1px solid #DCE6F1;
            border-left: 4px solid var(--azul-600);
            padding: 20px;
            border-radius: var(--radio);
            margin-bottom: 25px;
            color: var(--texto);
        }

        .result-container h3 {
            margin-top: 0;
            color: var(--azul-800);
        }

        /* Forzamos a que el pre no tenga márgenes raros dentro de la sección */
        .code-container pre {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <?php include 'menu.html'; ?>

    <section>
        <?php include 'manualPython/saludo.php'; ?>

        <h2>Conceptos fundamentales de PHP</h2>
        <h1>Variables</h1>

        <!-- BLOQUE 1: EL RESULTADO -->
        <div class="result-container">
            <h3>Resultado en pantalla:</h3>
            <p>En PHP las variables empiezan con el símbolo $ y no requieren declaración de tipo.</p>
            <?php
            $nombre = "Juan Andres Pulecio";
            echo "<br> Nombre: " . $nombre;

            $edad = 19;
            echo "<br> Edad: " . $edad;

            $soltero = true;
            echo "<br> Soltero: " . ($soltero ? "Sí" : "No");

            if ($soltero == true) {
                echo " - Esta soltero buscando una buena hembra";
            } else {
                echo " - JAJAJAJASJ No picha";
            }
            ?>
        </div>

        <!-- BLOQUE 2: EL CÓDIGO FUENTE -->
        <div class="code-container">
            <h3>Código PHP utilizado:</h3>

            <!-- Usamos tu etiqueta <pre><code> que ya tiene el fondo azul, los puntitos y el texto claro -->
            <pre><code>&lt;?php
    $nombre = "Juan Andres Pulecio";
    echo "&lt;br&gt; Nombre: " . $nombre;

    $edad = 19;
    echo "&lt;br&gt; Edad: " . $edad;

    $soltero = true;
    echo "&lt;br&gt; Soltero: " . ($soltero ? "Sí" : "No");

    if ($soltero == true) {
        echo " - Esta soltero buscando una buena hembra";
    } else {
        echo " - JAJAJAJASJ No picha";
    }
?&gt;</code></pre>

        </div>

    </section>

    <?php include 'pie.html'; ?>
</body>

</html>