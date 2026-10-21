<?php
// Entrega una gráfica generada por Python para la sesión actual
require 'proteger.php';

$archivo = basename($_GET['f'] ?? '');
$ruta = __DIR__ . '/datos/' . preg_replace('/[^A-Za-z0-9_-]/', '', session_id()) . '/' . $archivo;

if (!preg_match('/^grafica\d_[a-z_]+\.png$/', $archivo) || !is_file($ruta)) {
    http_response_code(404);
    exit();
}

header('Content-Type: image/png');
header('Cache-Control: no-store');
readfile($ruta);
