<?php
// Exporta el reporte del último análisis a PDF usando Python (fpdf)
require 'proteger.php';
require 'config_python.php';

date_default_timezone_set('America/Bogota');

$carpeta = __DIR__ . '/datos/' . preg_replace('/[^A-Za-z0-9_-]/', '', session_id());

// Sin análisis previo no hay nada que exportar
if (!is_file($carpeta . '/resumen.json')) {
    header('Location: analisisDeDatos.php');
    exit();
}

$pdf = $carpeta . '/reporte_clima_popayan.pdf';
if (is_file($pdf)) {
    unlink($pdf);
}

$salida = ejecutarPython(__DIR__ . '/reporte_pdf.py', [
    $carpeta,
    $_SESSION['nombre'],
    date('Y-m-d H:i'),
    $_SESSION['csv_subido']['nombre'] ?? 'clima.csv',
    $pdf,
]);

if (!is_file($pdf)) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Python no pudo generar el PDF:\n\n$salida";
    exit();
}

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="reporte_clima_popayan_' . date('Ymd') . '.pdf"');
header('Content-Length: ' . filesize($pdf));
header('Cache-Control: no-store');
readfile($pdf);
