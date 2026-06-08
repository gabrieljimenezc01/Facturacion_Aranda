<?php
// procesar_registro.php - Guarda un nuevo cliente

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $estrato = $_POST['estrato'];
    $sector = $_POST['sector'];
    $uso = $_POST['uso'];
    $codigo_medidor = $_POST['codigo_medidor'];
    $diametro_medidor = $_POST['diametro_medidor'];
    $fundador = isset($_POST['fundador']) ? 'SI' : 'NO';
    $activo = 'SI';
    $orden_input = $_POST['orden'];

    // Comprobar si el usuario ya existe (COMENTADO - DECISIÓN DEL CLIENTE)
    /*$sql_check = "SELECT COUNT(*) FROM clientes WHERE codigo_medidor = :codigo_medidor";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindParam(':codigo_medidor', $codigo_medidor);
    $stmt_check->execute();
    $user_exists = $stmt_check->fetchColumn();

    if ($user_exists) {
        $msg = "El usuario con este código de medidor ya existe.";
        header("Location: " . PUBLIC_URL . "/index.php?page=agregar_cliente&msg=" . urlencode($msg));
        exit;
    } else {*/

        // Lógica para agregar orden
        if ($orden_input === 'ninguna') {
            // Obtener el último orden del mismo sector
            $sql_max_sector = "SELECT MAX(orden) AS max_orden FROM clientes WHERE sector = :sector";
            $stmt_max_sector = $conn->prepare($sql_max_sector);
            $stmt_max_sector->bindParam(':sector', $sector);
            $stmt_max_sector->execute();
            $max_result_sector = $stmt_max_sector->fetch(PDO::FETCH_ASSOC);

            if ($max_result_sector && $max_result_sector['max_orden'] !== null) {
                $nuevo_orden = $max_result_sector['max_orden'] + 1;
            } else {
                // Si no hay clientes en el sector, buscar el mayor orden actual
                $sql_max = "SELECT MAX(orden) AS max_orden FROM clientes";
                $stmt_max = $conn->query($sql_max);
                $max_result = $stmt_max->fetch(PDO::FETCH_ASSOC);
                $nuevo_orden = ($max_result['max_orden'] ?? 0) + 1;
            }
        } else {
            $nuevo_orden = intval($orden_input);
        }
        
        // Mover hacia abajo los clientes que tienen orden igual o mayor
        $sql_update = "UPDATE clientes SET orden = orden + 1 WHERE orden >= :nuevo_orden";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bindParam(':nuevo_orden', $nuevo_orden, PDO::PARAM_INT);
        $stmt_update->execute();
        
        // Insertar el nuevo cliente
        $sql = "INSERT INTO clientes (nombre, apellido, direccion, estrato, sector, uso, codigo_medidor, diametro_medidor, fundador, activo, orden) 
                VALUES (:nombre, :apellido, :direccion, :estrato, :sector, :uso, :codigo_medidor, :diametro_medidor, :fundador, :activo, :orden)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':estrato', $estrato);
        $stmt->bindParam(':sector', $sector);
        $stmt->bindParam(':uso', $uso);
        $stmt->bindParam(':codigo_medidor', $codigo_medidor);
        $stmt->bindParam(':diametro_medidor', $diametro_medidor);
        $stmt->bindParam(':fundador', $fundador);
        $stmt->bindParam(':activo', $activo);
        $stmt->bindParam(':orden', $nuevo_orden, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $msg = "Usuario agregado con éxito";
        } else {
            $msg = "Error al agregar el usuario";
        }
        header("Location: " . PUBLIC_URL . "/index.php?page=agregar_cliente&msg=" . urlencode($msg));
        exit;
    //}  // ← Llave de cierre del else comentado
} else {
    // Si no es POST, redirigir al formulario
    header("Location: " . PUBLIC_URL . "/index.php?page=agregar_cliente");
    exit;
}
?>