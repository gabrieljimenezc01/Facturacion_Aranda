<?php
// obtener_ordenes.php - Devuelve las órdenes disponibles por sector

// Cargar configuración central
if (!defined('BASE_PATH')) {
    require_once dirname(__DIR__, 3) . '/config/app.php';
}

// Verificar autenticación
require_once APP_PATH . '/middleware/AuthMiddleware.php';
checkAuth();

// Asegurar conexión a base de datos
if (!isset($conn)) {
    require_once APP_PATH . '/config/database.php';
}

// Configurar cabecera para respuesta JSON
header('Content-Type: application/json');

if (isset($_GET['sector'])) {
    $sector = $_GET['sector'];

    try {
        $sql = "SELECT orden FROM clientes WHERE sector = :sector ORDER BY orden ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sector', $sector);
        $stmt->execute();
        $ordenes = $stmt->fetchAll(PDO::FETCH_COLUMN); // devuelve array de órdenes

        echo json_encode($ordenes);
    } catch (PDOException $e) {
        error_log("Error en obtener_ordenes.php: " . $e->getMessage());
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>