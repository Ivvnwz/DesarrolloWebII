<?php
// Verifica si la sesión está activa antes de intentar leerla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<h3 class="saludo-bienvenida">
    Bienvenido MR, <?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Pule'; ?>
</h3>