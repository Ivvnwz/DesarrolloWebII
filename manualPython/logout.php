<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinalizarSesion</title>
    <link rel="shortcut icon" href="../imagenes/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <?php

    // cambia de pagina automaticamente y me devuelvo un nivel
    session_start();
    session_unset();    // Elimina las variables de sesión
    session_destroy();  // Destruye la sesión completamente
    header('Location: ../home.php');
    exit();
    ?>
    <section>
        <?php include 'saludo.php'; ?>
        <h1>Finalizar sesion (logout)</h1>
    </section>
</body>

</html>