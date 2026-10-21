<?php require 'proteger.php'; ?>
<!DOCTYPE html>
<html lang="en">

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
        <h3> <?php include 'saludo.php'; ?></h3>
        <h1>Comandos</h1>
        <pre>
Estructuras y comandos básicos


Entrada y salida de datos

print("¡Hola, mundo!")
nombre = input("Introduce tu nombre: ")

Condicionales (Toma de decisiones)

edad = 20
if edad >= 18:
print("Mayor de edad")
else:
print("Menor de edad")

Bucle For (Repetir un número fijo de veces)

for i in range(5):
print(f"Repetición número: {i}")

Bucle While (Repetir mientras se cumpla una condición)

contador = 0
while contador < 3:
print(contador)
contador += 1

Funciones integradas (Built-in) comunes


Obtener la longitud de un texto o lista

longitud = len("Python")

Conocer el tipo de dato

tipo = type(10.5)

Convertir tipos de datos (Casting)

entero = int("25")
decimal = float(10)
texto = str(4.5)

Operaciones matemáticas simples

absoluto = abs(-7)
redondeado = round(3.14159, 2)
maximo = max(5, 12, 8)
minimo = min(5, 12, 8)

Estructura para crear tus propias funciones


Definición de una función básica con retorno

def sumar(a, b):
resultado = a + b
return resultado

Llamada y uso de la función

mi_suma = sumar(5, 10)
print(mi_suma)
</pre>
    </section>
</body>

</html>