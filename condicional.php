<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

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

    <section class="calculadora">
        <?php include 'manualPython/saludo.php'; ?>
        <h1>Condicionales</h1>

        <form action="condicional.php" method="POST">
            <table>
                <tr>
                    <th colspan="2">Calculadora Criolla</th>
                </tr>
                <tr>
                    <th>Número 1</th>
                    <td><input type="text" name="numero1" value="5"></td>
                </tr>
                <tr>
                    <th>Número 2</th>
                    <td><input type="text" name="numero2" value="2"></td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="operacion" value="+">
                        <input type="submit" name="operacion" value="-">
                    </td>
                    <td>
                        <input type="submit" name="operacion" value="*">
                        <input type="submit" name="operacion" value="/">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="operacion" value="R">
                        <input type="submit" name="operacion" value="S">
                    </td>
                    <td>
                        <input type="submit" name="operacion" value="T">
                        <input type="submit" name="operacion" value="L">
                    </td>
                </tr>
            </table>
        </form>

        <br>

        <?php
        // Procesar la operación solo si se envió el formulario
        if (isset($_POST['operacion'])) {
            $numero1 = $_POST['numero1'];
            $numero2 = $_POST['numero2'];
            $operacion = $_POST['operacion'];
            $rta = 0;

            switch ($operacion) {
                case "+":
                    $rta = $numero1 + $numero2;
                    echo "<div>Suma: <b>$rta</b></div>";
                    break;
                case "-":
                    $rta = $numero1 - $numero2;
                    echo "<div>Resta: <b>$rta</b></div>";
                    break;
                case "*":
                    $rta = $numero1 * $numero2;
                    echo "<div>Multiplicación: <b>$rta</b></div>";
                    break;
                case "/":
                    if ($numero2 != 0) {
                        $rta = $numero1 / $numero2;
                        echo "<div>División: <b>$rta</b></div>";
                    } else {
                        echo "<div>Error: <b>No se puede dividir entre cero</b></div>";
                    }
                    break;
                case "R":
                    if ($numero1 >= 0) {
                        $rta = sqrt($numero1);
                        echo "<div>Raíz Cuadrada de $numero1: <b>$rta</b></div>";
                    } else {
                        echo "<div>Error: <b>La raíz cuadrada requiere un número positivo</b></div>";
                    }
                    break;
                case "S":
                    $rta = sin($numero1);
                    echo "<div>Seno de $numero1: <b>$rta</b></div>";
                    break;
                case "T":
                    $rta = tan($numero1);
                    echo "<div>Tangente de $numero1: <b>$rta</b></div>";
                    break;
                case "L":
                    if ($numero1 > 0) {
                        $rta = log($numero1);
                        echo "<div>Logaritmo Natural de $numero1: <b>$rta</b></div>";
                    } else {
                        echo "<div>Error: <b>El logaritmo requiere un número positivo</b></div>";
                    }
                    break;
                default:
                    echo "<div>Operación no válida</div>";
                    break;
            }
        }
        ?>

        <!-- ========================================== -->
        <!-- EXPLICACIÓN Y CÓDIGO FUENTE (AÑADIDO)      -->
        <!-- ========================================== -->

        <hr>

        <h2>¿Cómo funcionan los condicionales aquí?</h2>
        <p>
            Esta calculadora usa la estructura <code>switch</code>, que es una alternativa a los
            <code>if...elseif...else</code> cuando se tienen muchas opciones. Evalúa el valor de
            <code>$operacion</code> (el botón que presionaste) y ejecuta el bloque <code>case</code> que coincida.
        </p>

        <ul class="lista-caracteristicas">
            <li><strong>if / else:</strong> Se usan dentro de los casos de división, raíz y logaritmo para validar errores (como dividir entre cero o sacar raíz de un negativo).</li>
            <li><strong>switch:</strong> Es el condicional principal que decide qué operación matemática realizar según el botón.</li>
            <li><strong>break:</strong> Detiene la ejecución del switch para que no se sigan evaluando los demás casos.</li>
        </ul>

        <div class="concepto">
            <h3>Código fuente de la calculadora</h3>
            <p>Este es el código PHP que procesa las operaciones:</p>

            <pre><code>&lt;?php
if (isset($_POST['operacion'])) {
    $numero1 = $_POST['numero1'];
    $numero2 = $_POST['numero2'];
    $operacion = $_POST['operacion'];
    $rta = 0;

    switch ($operacion) {
        case "+":
            $rta = $numero1 + $numero2;
            echo "&lt;div&gt;Suma: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            break;
        case "-":
            $rta = $numero1 - $numero2;
            echo "&lt;div&gt;Resta: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            break;
        case "*":
            $rta = $numero1 * $numero2;
            echo "&lt;div&gt;Multiplicación: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            break;
        case "/":
            if ($numero2 != 0) {
                $rta = $numero1 / $numero2;
                echo "&lt;div&gt;División: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            } else {
                echo "&lt;div&gt;Error: No se puede dividir entre cero&lt;/div&gt;";
            }
            break;
        case "R":
            if ($numero1 &gt;= 0) {
                $rta = sqrt($numero1);
                echo "&lt;div&gt;Raíz Cuadrada: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            } else {
                echo "&lt;div&gt;Error: La raíz requiere un número positivo&lt;/div&gt;";
            }
            break;
        case "S":
            $rta = sin($numero1);
            echo "&lt;div&gt;Seno: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            break;
        case "T":
            $rta = tan($numero1);
            echo "&lt;div&gt;Tangente: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            break;
        case "L":
            if ($numero1 &gt; 0) {
                $rta = log($numero1);
                echo "&lt;div&gt;Logaritmo: &lt;b&gt;$rta&lt;/b&gt;&lt;/div&gt;";
            } else {
                echo "&lt;div&gt;Error: El logaritmo requiere un número positivo&lt;/div&gt;";
            }
            break;
    }
}
?&gt;</code></pre>
        </div>
        <!-- FIN DEL BLOQUE AÑADIDO -->

    </section>

    <?php include 'pie.html'; ?>

</body>

</html>