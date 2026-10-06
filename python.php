<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina inicial</title>
    <link rel="shortcut icon" href="imagenes/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <?php
    include 'menu.html';
    ?>
    <section>
        <h1> Acceder al manual de Python </h1>

        <form action="python.php" method="POST">
            <table border=5>
                <TR>
                    <th colspan="2">Verificación de Usuario</th>
                </TR>
                <tr>
                    <th>Login</th>
                    <td><input type="text" name="login"></td>

                </tr>
                <tr>
                    <th>Password</th>
                    <td><input type="password" name="clave"></td>

                </tr>
                <tr>
                    <td><input type="submit" name="enviar"></td>
                    <td><input type="reset"></td>
                </tr>
            </table>

        </form>
        <?php
        //datos de la base de datos
        $loginUsuario = "admin";
        $claveUsuario = "123";
        $nombre = "Elton Tito";
        if (isset($_POST['enviar'])) {
            $login = $_POST['login'];
            $clave = $_POST['clave'];

            if (($login == $loginUsuario) && ($clave == $claveUsuario)) {
                session_start();
                $_SESSION['nombre'] = $nombre;
                header('Location: manualPython/index.php');
                exit();
            } else {
                echo "<p style='color:red; text-align:center;'>Usuario o contraseña incorrectos</p>";
            }
        }
        ?>
    </section>
    <footer></footer>
</body>

</html>