<?php require 'proteger.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comandos</title>
    <link rel="shortcut icon" href="../imagenes/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <?php
    include 'menuPython.html';
    ?>
    <section>
        <?php include 'saludo.php'; ?>
        <h1>Comandos</h1>
        <p>Estructuras y comandos básicos de Python.</p>

        <h2>Entrada y salida de datos</h2>
        <pre><code>print("¡Hola, mundo!")
nombre = input("Introduce tu nombre: ")</code></pre>

        <h2>Condicionales (toma de decisiones)</h2>
        <pre><code>edad = 20
if edad &gt;= 18:
    print("Mayor de edad")
else:
    print("Menor de edad")</code></pre>

        <h2>Bucle for (repetir un número fijo de veces)</h2>
        <pre><code>for i in range(5):
    print(f"Repetición número: {i}")</code></pre>

        <h2>Bucle while (repetir mientras se cumpla una condición)</h2>
        <pre><code>contador = 0
while contador &lt; 3:
    print(contador)
    contador += 1</code></pre>

        <h2>Funciones integradas (built-in) comunes</h2>

        <h3>Obtener la longitud de un texto o lista</h3>
        <pre><code>longitud = len("Python")</code></pre>

        <h3>Conocer el tipo de dato</h3>
        <pre><code>tipo = type(10.5)</code></pre>

        <h3>Convertir tipos de datos (casting)</h3>
        <pre><code>entero = int("25")
decimal = float(10)
texto = str(4.5)</code></pre>

        <h3>Operaciones matemáticas simples</h3>
        <pre><code>absoluto = abs(-7)
redondeado = round(3.14159, 2)
maximo = max(5, 12, 8)
minimo = min(5, 12, 8)</code></pre>

        <h2>Estructura para crear tus propias funciones</h2>

        <h3>Definición de una función básica con retorno</h3>
        <pre><code>def sumar(a, b):
    resultado = a + b
    return resultado</code></pre>

        <h3>Llamada y uso de la función</h3>
        <pre><code>mi_suma = sumar(5, 10)
print(mi_suma)</code></pre>
    </section>
</body>

</html>