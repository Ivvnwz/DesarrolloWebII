<?php require 'proteger.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variables</title>
    <link rel="shortcut icon" href="../imagenes/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <?php
    include 'menuPython.html';
    ?>
    <section>
        <?php include 'saludo.php'; ?>
        <h1>Variables</h1>
        <p>
            Una variable en Python es un contenedor para almacenar valores de datos. A diferencia de otros
            lenguajes, no necesitas declarar su tipo; se crea automáticamente en el momento en que le asignas
            un valor por primera vez usando el signo <code>=</code>.
        </p>
        <p>Aquí tienes los bloques de código listos para copiar y pegar.</p>

        <h2>Explicación rápida en código</h2>
        <p>Sintaxis: <code>nombre_variable = valor</code></p>
        <pre><code>edad = 25          # Se crea la variable 'edad' y guarda el número 25
print(edad)        # Muestra 25 en pantalla</code></pre>

        <h2>Tipos de variables comunes</h2>

        <h3>Variables de texto (strings)</h3>
        <pre><code>nombre = "Ana"
ciudad = 'Madrid'</code></pre>

        <h3>Variables numéricas (enteros y decimales)</h3>
        <pre><code>precio = 19.99
cantidad = 3
año_actual = 2026</code></pre>

        <h3>Variables booleanas (verdadero o falso)</h3>
        <pre><code>es_mayor_de_edad = True
tiene_descuento = False</code></pre>

        <h3>Variables de colecciones (listas y diccionarios)</h3>
        <pre><code>lista_compras = ["manzana", "pan", "leche"]
usuario = {"nombre": "Carlos", "id": 1024}</code></pre>

        <h2>Operaciones rápidas con variables</h2>

        <h3>Modificar el valor de una variable</h3>
        <pre><code>contador = 1
contador = contador + 1  # Ahora vale 2</code></pre>

        <h3>Sumar variables numéricas</h3>
        <pre><code>producto_a = 10
producto_b = 20
total = producto_a + producto_b</code></pre>

        <h3>Unir (concatenar) textos</h3>
        <pre><code>saludo = "Hola " + nombre</code></pre>
    </section>
</body>

</html>