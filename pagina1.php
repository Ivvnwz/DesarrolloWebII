<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina 1</title>
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon" />
</head>

<body>
    <h1>Alcance de las variables</h1>
    <?php
    $_SESSION['nombre'] = "Vivi Dora";
    echo "Nombre:   $_SESSION[nombre] ";
    ?>
    <a href = "pagina2.php">Ir a Pagina 2</a>
</body>

</html>