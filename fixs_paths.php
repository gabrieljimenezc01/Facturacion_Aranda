<?php
// fix_paths.php - Script para actualizar rutas automáticamente
// Ejecutar UNA SOLA VEZ en la terminal: php fix_paths.php

// PASO 1: Definir las constantes manualmente (porque app/config/app.php aún no existe)
define('BASE_PATH', __DIR__);  // C:\xampp\htdocs\Facturacion_Aranda
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('PUBLIC_URL', 'http://localhost/facturacion_aranda/public');

// PASO 2: Verificar que la carpeta app existe
if (!file_exists(APP_PATH)) {
    die("Error: La carpeta 'app/' no existe. ¿Ya moviste los archivos de src/ a app/?");
}

echo "=== INICIANDO ACTUALIZACIÓN DE RUTAS ===\n";
echo "Ruta base: " . BASE_PATH . "\n";
echo "Buscando archivos en: " . APP_PATH . "\n\n";

// PASO 3: Definir qué buscar y por qué reemplazar
$replacements = [
    // Buscar rutas relativas de CSS/JS/imágenes
    '../../../public/' => PUBLIC_URL . '/',
    '../../public/' => PUBLIC_URL . '/',
    '../public/' => PUBLIC_URL . '/',
    './public/' => PUBLIC_URL . '/',
    'public/' => PUBLIC_URL . '/',
    
    // Buscar includes de archivos de configuración
    '../config/db.php' => APP_PATH . '/config/database.php',
    '../includes/Validator.php' => APP_PATH . '/includes/Validator.php',
    '../includes/encryption.php' => APP_PATH . '/includes/encryption.php',
    './config/db.php' => APP_PATH . '/config/database.php',
    'config/db.php' => APP_PATH . '/config/database.php',
    
    // Buscar redirecciones
    'header("Location: ../' => 'header("Location: ' . PUBLIC_URL . '/index.php?page=',
    'header("Location: ../src/' => 'header("Location: ' . PUBLIC_URL . '/',
];

// PASO 4: Función para procesar archivos
function processFile($filepath, $replacements) {
    $content = file_get_contents($filepath);
    $original = $content;
    
    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    
    if ($content !== $original) {
        file_put_contents($filepath, $content);
        return true;
    }
    return false;
}

// PASO 5: Recorrer TODOS los archivos PHP en app/
$count = 0;
$modified = [];
$errors = [];

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(APP_PATH, RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $filepath = $file->getPathname();
        try {
            if (processFile($filepath, $replacements)) {
                $modified[] = $filepath;
                $count++;
                echo "✓ Modificado: " . $file->getPathname() . "\n";
            }
        } catch (Exception $e) {
            $errors[] = $filepath . " - " . $e->getMessage();
            echo "✗ Error: " . $filepath . "\n";
        }
    }
}

// PASO 6: Mostrar resumen
echo "\n=== RESUMEN ===\n";
echo "Total de archivos modificados: " . $count . "\n";
echo "Archivos sin cambios: " . (iterator_count($iterator) - $count) . "\n";

if (!empty($errors)) {
    echo "\n=== ERRORES ===\n";
    foreach ($errors as $error) {
        echo $error . "\n";
    }
}

if ($count > 0) {
    echo "\n✓ ¡Archivos actualizados correctamente!\n";
    echo "\n⚠️ IMPORTANTE: Revisa manualmente los siguientes archivos si existen:\n";
    echo "  - app/modules/auth/authenticate.php (verificar redirecciones)\n";
    echo "  - app/config/database.php (verificar credenciales)\n";
} else {
    echo "\n⚠️ No se modificó ningún archivo. ¿Los archivos ya están actualizados?\n";
}