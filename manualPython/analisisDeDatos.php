<?php
require 'proteger.php';
require 'config_python.php';

date_default_timezone_set('America/Bogota');

// Convierte "2026-10-20" en "20 de octubre de 2026"
function fechaLarga($fecha)
{
    $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio',
        'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
    $partes = explode('-', $fecha);
    return (int) $partes[2] . ' de ' . $meses[(int) $partes[1] - 1] . ' de ' . $partes[0];
}

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
        <?php include 'saludo.php'; ?>
        <h1>Análisis de datos con Python</h1>
        <h2>Objetivos de aprendizaje</h2>

        <p>Al terminar esta clase, el estudiante será capaz de:</p>

        <ul>
            <li>Comprender qué es un archivo CSV y su estructura</li>

            <li>Leer un archivo CSV con pandas.</li>

            <li> Explorar, filtrar y limpiar los datos.</li>

            <li> Generar gráficos de líneas, barras, tortas, histogramas y dispersión.</li>

            <li> Exportar los gráficos como imágenes.</li>

            <li> Interpretar los resultados con criterio analítico.</li>
        </ul>

        <h2>Sistema de información climática</h2>
        <p>
            Flujo completo: los datos se descargan desde una API real, se suben al servidor y Python
            (pandas + matplotlib) los procesa para generar el reporte y sus gráficas.
        </p>

        <ol class="pasos">
            <li class="paso">
                <span class="paso-numero">1</span>
                <h3>Descargar los datos</h3>
                <p>
                    Clima diario de Popayán del último año, obtenido en tiempo real desde la API
                    pública de <a href="https://open-meteo.com" target="_blank" rel="noopener">Open-Meteo</a>.
                </p>
                <a class="boton boton-secundario" href="api/clima_popayan.php">Descargar CSV del clima</a>
            </li>

            <li class="paso">
                <span class="paso-numero">2</span>
                <h3>Subir el CSV</h3>
                <form method="POST" enctype="multipart/form-data" id="formulario-csv">
                    <input type="file" name="csv" accept=".csv,text/csv" required>
                    <button type="submit">Subir y analizar</button>
                </form>
            </li>

            <li class="paso<?= $resumen ? ' paso-listo' : '' ?>">
                <span class="paso-numero">3</span>
                <h3>Reporte y PDF</h3>
                <?php if ($resumen): ?>
                    <p>Reporte generado. Revísalo abajo o descárgalo en PDF.</p>
                    <a class="boton" href="exportar_pdf.php">Exportar reporte a PDF</a>
                <?php else: ?>
                    <p>Sube el CSV para generar el reporte con sus 5 gráficas.</p>
                <?php endif; ?>
            </li>
        </ol>

        <?php if ($mensaje !== ''): ?>
            <p class="alerta alerta-<?= $tipoMensaje ?>"><?= $mensaje ?></p>
        <?php endif; ?>

        <?php if ($resumen): ?>
            <article class="reporte" id="reporte">
                <header class="reporte-encabezado">
                    <p class="reporte-etiqueta">Sistema de información climática</p>
                    <h2 class="reporte-titulo">Reporte climático de Popayán</h2>
                    <p class="reporte-subtitulo">
                        Análisis del clima diario del <?= fechaLarga($resumen['fecha_inicio']) ?>
                        al <?= fechaLarga($resumen['fecha_fin']) ?>
                    </p>
                    <dl class="reporte-datos">
                        <div>
                            <dt>Fecha del reporte</dt>
                            <dd><?= fechaLarga(date('Y-m-d')) ?>, <?= date('H:i') ?></dd>
                        </div>
                        <div>
                            <dt>Elaborado por</dt>
                            <dd><?= htmlspecialchars($_SESSION['nombre']) ?></dd>
                        </div>
                        <div>
                            <dt>Archivo analizado</dt>
                            <dd><?= htmlspecialchars($_SESSION['csv_subido']['nombre'] ?? 'clima.csv') ?></dd>
                        </div>
                        <div>
                            <dt>Fuente</dt>
                            <dd>Open-Meteo · procesado con pandas y matplotlib</dd>
                        </div>
                    </dl>
                </header>

                <ul class="indicadores">
                    <li>
                        <span class="indicador-valor"><?= number_format($resumen['temp_media'], 1, ',', '.') ?> °C</span>
                        <span class="indicador-nombre">Temperatura media</span>
                    </li>
                    <li>
                        <span class="indicador-valor"><?= number_format($resumen['lluvia_total'], 0, ',', '.') ?> mm</span>
                        <span class="indicador-nombre">Lluvia acumulada (<?= $resumen['dias_lluvia'] ?> días)</span>
                    </li>
                    <li>
                        <span class="indicador-valor"><?= number_format($resumen['temp_max'], 1, ',', '.') ?> °C</span>
                        <span class="indicador-nombre">Máxima · <?= fechaLarga($resumen['temp_max_fecha']) ?></span>
                    </li>
                    <li>
                        <span class="indicador-valor"><?= htmlspecialchars(ucfirst($resumen['mes_lluvioso'])) ?></span>
                        <span class="indicador-nombre">Mes más lluvioso (<?= number_format($resumen['mes_lluvioso_mm'], 0, ',', '.') ?> mm)</span>
                    </li>
                </ul>

                <h3 class="reporte-seccion">Resumen</h3>
                <p class="reporte-resumen"><?= htmlspecialchars($resumen['texto']) ?></p>

                <h3 class="reporte-seccion">Gráficas</h3>
                <div class="reporte-graficas">
                    <?php foreach ($resumen['graficas'] as $numero => $grafica): ?>
                        <figure class="grafica">
                            <img src="imagen.php?f=<?= urlencode($grafica['archivo']) ?>&amp;v=<?= time() ?>"
                                alt="<?= htmlspecialchars($grafica['titulo']) ?>">
                            <figcaption>
                                <strong>Figura <?= $numero + 1 ?>. <?= htmlspecialchars($grafica['titulo']) ?>.</strong>
                                <?= htmlspecialchars($grafica['descripcion']) ?>
                            </figcaption>
                        </figure>
                    <?php endforeach; ?>
                </div>
            </article>
        <?php endif; ?>
    </section>

    <script>
        // Mientras Python procesa el archivo, avisar y evitar doble envío
        document.getElementById('formulario-csv').addEventListener('submit', function () {
            var boton = this.querySelector('button');
            boton.disabled = true;
            boton.textContent = 'Analizando con Python…';
        });
    </script>
</body>

</html>
