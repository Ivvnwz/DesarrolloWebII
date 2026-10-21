<?php
// Ruta del intérprete de Python que usa PHP para ejecutar los scripts de análisis.
// Apache no siempre tiene el PATH del usuario, por eso se busca la ruta absoluta.
// Si en otro equipo no lo encuentra, define la variable de entorno PYTHON_BIN
// o escribe la ruta directamente en $candidatos.
function rutaPython()
{
    $candidatos = [];

    if (getenv('PYTHON_BIN')) {
        $candidatos[] = getenv('PYTHON_BIN');
    }

    // Instalaciones típicas de Python en Windows
    $carpetasUsuario = glob('C:/Users/*/AppData/Local/Programs/Python/Python3*/python.exe') ?: [];
    $carpetasSistema = array_merge(
        glob('C:/Program Files/Python3*/python.exe') ?: [],
        glob('C:/Python3*/python.exe') ?: []
    );
    rsort($carpetasUsuario);
    rsort($carpetasSistema);
    $candidatos = array_merge($candidatos, $carpetasUsuario, $carpetasSistema);

    foreach ($candidatos as $ruta) {
        if (is_file($ruta)) {
            return $ruta;
        }
    }

    // Último recurso: el que esté en el PATH
    return 'python';
}

// Ejecuta un script de Python con sus argumentos y devuelve la salida (stdout + stderr)
function ejecutarPython($script, array $argumentos = [])
{
    $comando = escapeshellarg(rutaPython()) . ' ' . escapeshellarg($script);
    foreach ($argumentos as $argumento) {
        $comando .= ' ' . escapeshellarg($argumento);
    }
    $salida = trim((string) shell_exec($comando . ' 2>&1'));

    // Los mensajes de cmd.exe llegan en la codificación de consola de Windows (CP850);
    // sin convertirlos, htmlspecialchars() devolvería una cadena vacía
    if (!mb_check_encoding($salida, 'UTF-8')) {
        $salida = mb_convert_encoding($salida, 'UTF-8', 'CP850');
    }
    return $salida;
}
