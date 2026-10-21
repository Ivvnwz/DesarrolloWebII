<?php require 'proteger.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operadores</title>
    <link rel="shortcut icon" href="../imagenes/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <?php
    include 'menuPython.html';
    ?>
    <section>
        <?php include 'saludo.php'; ?>
        <h1>Operadores</h1>
        <p>Los operadores permiten hacer cálculos, comparar valores y combinar condiciones.</p>

        <h2>Operadores aritméticos</h2>
        <table>
            <tr><th>Operador</th><th>Nombre</th><th>Ejemplo (a = 7, b = 5)</th><th>Resultado</th></tr>
            <tr><td><code>+</code></td><td>Suma</td><td><code>a + b</code></td><td>12</td></tr>
            <tr><td><code>-</code></td><td>Resta</td><td><code>a - b</code></td><td>2</td></tr>
            <tr><td><code>*</code></td><td>Multiplicación</td><td><code>a * b</code></td><td>35</td></tr>
            <tr><td><code>/</code></td><td>División</td><td><code>a / b</code></td><td>1.4</td></tr>
            <tr><td><code>//</code></td><td>División entera</td><td><code>a // b</code></td><td>1</td></tr>
            <tr><td><code>%</code></td><td>Módulo (residuo)</td><td><code>a % b</code></td><td>2</td></tr>
            <tr><td><code>**</code></td><td>Potencia</td><td><code>a ** b</code></td><td>16807</td></tr>
        </table>
        <pre><code>a = 7
b = 5
print(a * b)
print(a + b)
print(a - b)
print(a / b)
print(a // b)
print(a % b)
print(a ** b)

ciudad = "Popayan"
print("Longitud", len(ciudad))</code></pre>

        <h2>Operadores de comparación</h2>
        <p>Devuelven <code>True</code> o <code>False</code>.</p>
        <pre><code>edad = 20
print(edad == 20)   # Igual a              -> True
print(edad != 18)   # Diferente de         -> True
print(edad &gt; 18)    # Mayor que            -> True
print(edad &lt; 18)    # Menor que            -> False
print(edad &gt;= 20)   # Mayor o igual que    -> True
print(edad &lt;= 19)   # Menor o igual que    -> False</code></pre>

        <h2>Operadores lógicos</h2>
        <pre><code>tiene_cedula = True
es_mayor = edad &gt;= 18

print(tiene_cedula and es_mayor)   # True si ambas son verdaderas
print(tiene_cedula or es_mayor)    # True si al menos una es verdadera
print(not tiene_cedula)            # Invierte el valor -> False</code></pre>

        <h2>Operadores de asignación</h2>
        <pre><code>contador = 10
contador += 5   # contador = contador + 5  -> 15
contador -= 3   # contador = contador - 3  -> 12
contador *= 2   # contador = contador * 2  -> 24
contador /= 4   # contador = contador / 4  -> 6.0</code></pre>
    </section>
</body>

</html>