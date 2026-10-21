<?php
// Se incluye al inicio de cada página del manual:
// si no hay sesión iniciada, redirige al login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['nombre'])) {
    header('Location: ../python.php');
    exit();
}
