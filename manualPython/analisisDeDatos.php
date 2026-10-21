<?php
require 'proteger.php';
require 'config_python.php';

// Columnas que debe traer el CSV descargado desde la API
$columnasRequeridas = [
    'fecha', 'temp_max_c', 'temp_min_c', 'temp_media_c',
    'precipitacion_mm', 'humedad_pct', 'viento_max_kmh', 'radiacion_mj_m2',
];

// Carpeta de trabajo propia de cada sesión (datos/<id de sesión>/)
$carpeta = __DIR__ . '/datos/' . preg_replace('/[^A-Za-z0-9_-]/', '', session_id());

$mensaje = '';
$tipoMensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv'])) {
    $archivo = $_FILES['csv'];
    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        $mensaje = 'No se recibió el archivo. Selecciona un CSV e inténtalo de nuevo.';
    } elseif ($extension !== 'csv') {
        $mensaje = 'El archivo debe tener extensión .csv';
    } elseif ($archivo['size'] > 2 * 1024 * 1024) {
        $mensaje = 'El archivo supera el tamaño máximo de 2 MB.';
    } else {
        // Revisar que el encabezado tenga las columnas esperadas
        $manejador = fopen($archivo['tmp_name'], 'r');
        $encabezado = fgetcsv($manejador);
        $filas = 0;
        while (fgetcsv($manejador) !== false) {
            $filas++;
        }
        fclose($manejador);

        $encabezado = array_map(fn($c) => trim($c, " \t\n\r\0\x0B\xEF\xBB\xBF"), $encabezado ?: []);
        $faltantes = array_diff($columnasRequeridas, $encabezado);

        if ($faltantes) {
            $mensaje = 'Al CSV le faltan columnas: ' . implode(', ', $faltantes)
                . '. Usa el archivo descargado en el paso 1.';
        } elseif ($filas === 0) {
            $mensaje = 'El CSV no tiene filas de datos.';
        } else {
            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            move_uploaded_file($archivo['tmp_name'], $carpeta . '/clima.csv');

            // Borrar el análisis anterior y procesar el CSV con Python (pandas + matplotlib)
            array_map('unlink', array_merge(glob($carpeta . '/grafica*.png') ?: [], glob($carpeta . '/resumen.json') ?: []));
            $salida = ejecutarPython(__DIR__ . '/analisis_clima.py', [$carpeta . '/clima.csv', $carpeta]);

            if (is_file($carpeta . '/resumen.json')) {
                $_SESSION['csv_subido'] = [
                    'nombre' => basename($archivo['name']),
                    'filas'  => $filas,
                    'fecha'  => date('Y-m-d H:i'),
                ];
                $mensaje = 'Archivo "' . htmlspecialchars(basename($archivo['name'])) . "\" analizado: $filas registros.";
                $tipoMensaje = 'exito';
            } else {
                $mensaje = 'Python no pudo procesar el CSV: <pre>' . htmlspecialchars($salida) . '</pre>';
            }
        }
    }

    if ($tipoMensaje === '') {
        $tipoMensaje = 'error';
    }
}

// Resultado del último análisis de esta sesión (lo escribe analisis_clima.py)
$resumen = null;
if (is_file($carpeta . '/resumen.json')) {
    $resumen = json_decode(file_get_contents($carpeta . '/resumen.json'), true);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis de Datos</title>
    <link rel="shortcut icon" href="../imagenes/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <?php include 'menuPython.html'; ?>
    <section>
        <h3><?php include 'saludo.php'; ?></h3>
        <h1>Análisis de datos con Python</h1>
        <h2>Objetivos de aprendizaje</h2>

        Al terminar esta clase, el estudiante será capaz de:

        <ul>
            <li>Comprender qué es un archivo CSV y su estructura</li>

            <li>Leer un archivo CSV con pandas.</li>

            <li> Explorar, filtrar y limpiar los datos.</li>

            <li> Generar gráficos de líneas, barras, tortas, histogramas y dispersión.</li>

            <li> Exportar los gráficos como imágenes.</li>

            <li> Interpretar los resultados con criterio analítico.</li>
        </ul>

        <h2>1. Descargar los datos</h2>
        <p>
            Clima diario de Popayán del último año, obtenido en tiempo real desde la API
            pública de <a href="https://open-meteo.com" target="_blank" rel="noopener">Open-Meteo</a>.
        </p>
        <a class="boton" href="api/clima_popayan.php">Descargar CSV del clima</a>

        <h2>2. Subir el CSV</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="csv" accept=".csv,text/csv" required>
            <button type="submit">Subir y analizar</button>
        </form>

        <?php if ($mensaje !== ''): ?>
            <p class="alerta alerta-<?= $tipoMensaje ?>"><?= $mensaje ?></p>
        <?php endif; ?>

        <?php if ($resumen): ?>
            <h2>3. Gráficas generadas con Python</h2>
            <?php foreach ($resumen['graficas'] as $grafica): ?>
                <figure class="grafica">
                    <img src="imagen.php?f=<?= urlencode($grafica['archivo']) ?>&amp;v=<?= time() ?>"
                        alt="<?= htmlspecialchars($grafica['titulo']) ?>">
                    <figcaption><?= htmlspecialchars($grafica['descripcion']) ?></figcaption>
                </figure>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</body>

</html>
