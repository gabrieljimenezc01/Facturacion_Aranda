<?php
// logout.php - Cerrar sesión

// Cargar configuración
if (!defined('BASE_PATH')) {
    require_once dirname(__DIR__, 3) . '/config/app.php';
}

// Iniciar sesión si es necesario
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destruir la sesión
session_destroy();

// Redirigir al login
header("Location: " . PUBLIC_URL . "/index.php?page=login");
exit();
?>