<?php
// AuthMiddleware.php - Verificación de autenticación centralizada

// Verificar que el usuario está autenticado
function checkAuth() {
    // Iniciar sesión si no está iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['user'])) {
        header("Location: " . PUBLIC_URL . "/index.php?page=login");
        exit();
    }
}

// Verificar que el usuario NO está autenticado (para login/register)
function checkGuest() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (isset($_SESSION['user'])) {
        header("Location: " . PUBLIC_URL . "/index.php?page=dashboard");
        exit();
    }
}
?>