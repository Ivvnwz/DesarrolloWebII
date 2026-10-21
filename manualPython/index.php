<?php require 'proteger.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conceptos</title>
    <link rel="shortcut icon" href="../imagenes/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <?php
    include 'menuPython.html';
    ?>
    <section>

        <?php include 'saludo.php'; ?>

        <h1>Conceptos Python</h1>
        <p><strong>¿Qué es Python?</strong> Python es un lenguaje de programación:</p>
        <ul>
            <li>Sintaxis clara y legible: Utiliza una estructura limpia muy cercana al inglés y recurre a la indentación
                obligatoria en lugar de llaves, lo que obliga a escribir código ordenado de forma natural.</li>
            <li>Lenguaje interpretado: El código se ejecuta línea por línea directamente a través de un intérprete, lo que
                ahorra el tiempo de compilación y facilita enormemente las pruebas rápidas y la depuración.</li>
            <li>Tipado dinámico: No necesitas declarar explícitamente el tipo de datos de una variable al crearla; el
                intérprete lo detecta y lo asigna automáticamente en tiempo de ejecución.</li>
            <li> Multiparadigma: Permite programar utilizando diferentes estilos según la necesidad del proyecto, incluyendo
                programación orientada a objetos (POO), estructurada e incluso funcional.</li>
            <li> Gran biblioteca estándar: Cuenta con un ecosistema masivo de módulos preinstalados listos para resolver
                tareas
                comunes como manejo de archivos, conexiones de red, operaciones matemáticas y procesamiento de textos.</li>
            <li> Multiplataforma: Es un lenguaje portable que funciona exactamente igual en los sistemas operativos más
                comunes
                como Windows, macOS y Linux.</li>
            <li> Comunidad enorme y activa: Dispone de millones de desarrolladores en todo el mundo, lo que garantiza
                abundante
                documentación, soporte constante en foros y miles de librerías de terceros listas para descargar.</li>
        </ul>


        <h1>¿Cómo ejecuta Python tu código?</h1>
        <ol>
            <li>Escribe el código: Abre cualquier editor de texto o entorno de desarrollo (como VS Code) y escribe tus
                líneas
                de código.</li>
            <li>Guarda el archivo: Guarda el documento con un nombre descriptivo y asegúrate de agregar la extensión .py
                al
                final (por ejemplo, programa.py).</li>
            <li>Abre la terminal: Abre la consola de comandos de tu sistema operativo (Terminal en macOS/Linux o
                CMD/PowerShell en Windows).</li>
            <li> Navega a la carpeta: Usa el comando cd seguido de la ruta de la carpeta donde guardaste tu archivo
                (por
                ejemplo, cd Documentos/Python).</li>
            <li> Ejecuta el comando: Escribe python programa.py (o python3 programa.py en algunos sistemas) y presiona
                Enter
                para ver el resultado en pantalla.</li>
        </ol>
        <h1>Ejemplo:</h1>
        <pre><code># 1. Definición de variables (Tipado dinámico)
nombre = "Carlos"
edad = 20

# 2. Estructura de control condicional (Usa indentación con espacios)
if edad &gt;= 18:
    print(f"Hola {nombre}, eres mayor de edad y puedes pasar.")
else:
    print(f"Hola {nombre}, eres menor de edad.")</code></pre>
    </section>
    <?php include '../pie.html'; ?>
</body>

</html>