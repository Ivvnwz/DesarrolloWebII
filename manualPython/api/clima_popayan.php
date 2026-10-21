<?php
// API que devuelve un CSV descargable con el clima diario de Popayán
// Fuente: Open-Meteo (https://open-meteo.com) - gratuita y sin API key

$latitud  = 2.4448;
$longitud = -76.6147;

// El archivo histórico tiene unos días de retraso, por eso se termina 5 días antes de hoy
$fin    = new DateTime('-5 days', new DateTimeZone('America/Bogota'));
$inicio = (clone $fin)->modify('-364 days');

$variables = [
    'temperature_2m_max',
    'temperature_2m_min',
    'temperature_2m_mean',
    'precipitation_sum',
    'relative_humidity_2m_mean',
    'wind_speed_10m_max',
    'shortwave_radiation_sum',
];

$url = 'https://archive-api.open-meteo.com/v1/archive?' . http_build_query([
    'latitude'   => $latitud,
    'longitude'  => $longitud,
    'start_date' => $inicio->format('Y-m-d'),
    'end_date'   => $fin->format('Y-m-d'),
    'daily'      => implode(',', $variables),
    'timezone'   => 'America/Bogota',
    'format'     => 'csv',
]);

$curl = curl_init($url);
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_FOLLOWLOCATION => true,
]);
$respuesta = curl_exec($curl);
$codigo    = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$error     = curl_error($curl);
curl_close($curl);

if ($respuesta === false || $codigo !== 200) {
    http_response_code(502);
    header('Content-Type: text/plain; charset=utf-8');
    echo "No se pudo obtener el clima desde Open-Meteo. $error (HTTP $codigo)";
    exit();
}

// Open-Meteo antepone un bloque de metadatos separado por una línea en blanco:
// nos quedamos solo con la tabla diaria (la que empieza por "time,")
$lineas = preg_split('/\r?\n/', trim($respuesta));
$posicion = null;
foreach ($lineas as $i => $linea) {
    if (strpos($linea, 'time,') === 0) {
        $posicion = $i;
        break;
    }
}

if ($posicion === null) {
    http_response_code(502);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'La respuesta de Open-Meteo no tiene el formato esperado.';
    exit();
}

// Encabezados en español y sin símbolos para leerlos fácil con pandas
$encabezados = [
    'fecha',
    'temp_max_c',
    'temp_min_c',
    'temp_media_c',
    'precipitacion_mm',
    'humedad_pct',
    'viento_max_kmh',
    'radiacion_mj_m2',
];

$filas = array_slice($lineas, $posicion + 1);
$csv = implode(',', $encabezados) . "\r\n" . implode("\r\n", $filas) . "\r\n";

$nombre = 'clima_popayan_' . $inicio->format('Ymd') . '_' . $fin->format('Ymd') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $nombre . '"');
header('Content-Length: ' . strlen($csv));
header('Cache-Control: no-store');
echo $csv;
