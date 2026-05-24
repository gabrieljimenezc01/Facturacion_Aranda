<?php
require_once dirname(__DIR__) . '/app/config/app.php';

echo "<h1>Verificación de authenticate.php</h1>";

// Intentar incluir authenticate.php y capturar su salida
ob_start();
require_once APP_PATH . '/modules/auth/authenticate.php';
$output = ob_get_clean();

echo "<h2>Contenido que genera authenticate.php:</h2>";
echo "<pre>" . htmlspecialchars($output) . "</pre>";

echo "<h2>Variables de sesión después de la ejecución:</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>