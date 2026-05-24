<?php
// Configuración principal de la aplicación
define('BASE_PATH', realpath(dirname(__DIR__, 2)));
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('PUBLIC_URL', 'http://localhost/facturacion_aranda/public');

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'acueducto_aranda');

// Configuración de sesión
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0);

// Zona horaria
date_default_timezone_set('America/Bogota');

// Manejo de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', BASE_PATH . '/logs/error.log');

// ============================================
// IMPORTANTE: Cargar en este orden
// ============================================

// 1. Primero la base de datos (para que $conn esté disponible)
if (file_exists(APP_PATH . '/config/database.php')) {
    require_once APP_PATH . '/config/database.php';
} else {
    die('Error: No se encuentra database.php en ' . APP_PATH . '/config/');
}

// 2. Luego encryption.php (no depende de nada)
if (file_exists(APP_PATH . '/includes/encryption.php')) {
    require_once APP_PATH . '/includes/encryption.php';
} else {
    die('Error: No se encuentra encryption.php en ' . APP_PATH . '/includes/');
}

// 3. Finalmente Validator.php (puede usar $conn pero no requiere incluirlo)
if (file_exists(APP_PATH . '/includes/Validator.php')) {
    require_once APP_PATH . '/includes/Validator.php';
} else {
    die('Error: No se encuentra Validator.php en ' . APP_PATH . '/includes/');
}
?>