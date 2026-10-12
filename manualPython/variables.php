<!DOCTYPE html>
<html lang="en">

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
        <h3> <?php include 'saludo.php'; ?></h3>
        <h1>Variables</h1>
        <pre>
            Una variable en Python es un contenedor para almacenar valores de datos. A diferencia de otros lenguajes,
             no necesitas declarar su tipo; se crea automáticamente en el momento en que le asignas un valor por primera
              vez usando el signo =.
Aquí tienes los bloques de código listos para copiar y pegar:

Explicación rápida en código


Sintaxis: nombre_variable = valor

edad = 25          # Se crea la variable 'edad' y guarda el número 25
print(edad)        # Muestra 25 en pantalla

Tipos de variables comunes para copiar y pegar


Variables de texto (Strings)

nombre = "Ana"
ciudad = 'Madrid'

Variables numéricas (Enteros y Decimales)

precio = 19.99
cantidad = 3
año_actual = 2026

Variables booleanas (Verdadero o Falso)

es_mayor_de_edad = True
tiene_descuento = False

Variables de colecciones (Listas y Diccionarios)

lista_compras = ["manzana", "pan", "leche"]
usuario = {"nombre": "Carlos", "id": 1024}

Operaciones rápidas con variables


Modificar el valor de una variable

contador = 1
contador = contador + 1  # Ahora vale 2

Sumar variables numéricas

producto_a = 10
producto_b = 20
total = producto_a + producto_b

Unir (concatenar) textos

saludo = "Hola " + nombre

        </pre>
    </section>
</body>

</html>