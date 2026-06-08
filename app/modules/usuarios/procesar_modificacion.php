<?php
// procesar_modificacion.php - Procesa la modificación de clientes

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
    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
    $estrato = isset($_POST['estrato']) ? $_POST['estrato'] : '';
    $sector = isset($_POST['sector']) ? $_POST['sector'] : '';
    $uso = isset($_POST['uso']) ? $_POST['uso'] : '';
    $codigo_medidor = isset($_POST['codigo_medidor']) ? $_POST['codigo_medidor'] : '';
    $diametro_medidor = isset($_POST['diametro_medidor']) ? $_POST['diametro_medidor'] : '';
    $fundador = isset($_POST['fundador']) ? 'SI' : 'NO';
    $activo = isset($_POST['activo']) ? 'SI' : 'NO';
    $orden = isset($_POST['orden']) ? $_POST['orden'] : 'ninguna';

    // Verificar si el usuario existe
    if ($codigo != "") {
        $sql_verificar = "SELECT * FROM clientes WHERE codigo = :codigo";
        $stmt_verificar = $conn->prepare($sql_verificar);
        $stmt_verificar->bindValue(':codigo', $codigo, PDO::PARAM_STR);
        $stmt_verificar->execute();
        $usuario = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Lógica de orden
            $orden_anterior = (int)$usuario['orden'];
            $orden_nuevo = $orden;

            // Si seleccionó "ninguna", calculamos el nuevo orden al final
            if ($orden === 'ninguna') {
                $sql_max = "SELECT MAX(orden) FROM clientes WHERE sector = :sector";
                $stmt_max = $conn->prepare($sql_max);
                $stmt_max->bindValue(':sector', $sector, PDO::PARAM_STR);
                $stmt_max->execute();
                $max_orden = $stmt_max->fetchColumn();
                $orden_nuevo = ($max_orden ? (int)$max_orden : 0) + 1;
            } else {
                $orden_nuevo = (int)$orden;
            }

            // Solo mover si el orden ha cambiado
            if ($orden_nuevo !== $orden_anterior) {
                if ($orden_anterior == 0) {
                    // Cliente sin orden previa: insertar en la posición deseada
                    $sql_shift = "UPDATE clientes 
                                SET orden = orden + 1 
                                WHERE orden >= :nuevo_orden 
                                AND codigo != :codigo";
                    $stmt_shift = $conn->prepare($sql_shift);
                    $stmt_shift->bindValue(':nuevo_orden', $orden_nuevo, PDO::PARAM_INT);
                    $stmt_shift->bindValue(':codigo', $codigo, PDO::PARAM_STR);
                } elseif ($orden_nuevo < $orden_anterior) {
                    // Movimiento hacia arriba
                    $sql_shift = "UPDATE clientes 
                                SET orden = orden + 1 
                                WHERE orden >= :nuevo_orden 
                                AND orden < :anterior_orden 
                                AND codigo != :codigo";
                    $stmt_shift = $conn->prepare($sql_shift);
                    $stmt_shift->bindValue(':nuevo_orden', $orden_nuevo, PDO::PARAM_INT);
                    $stmt_shift->bindValue(':anterior_orden', $orden_anterior, PDO::PARAM_INT);
                    $stmt_shift->bindValue(':codigo', $codigo, PDO::PARAM_STR);
                } else {
                    // Movimiento hacia abajo
                    $sql_shift = "UPDATE clientes 
                                SET orden = orden - 1 
                                WHERE orden <= :nuevo_orden 
                                AND orden > :anterior_orden 
                                AND codigo != :codigo";
                    $stmt_shift = $conn->prepare($sql_shift);
                    $stmt_shift->bindValue(':nuevo_orden', $orden_nuevo, PDO::PARAM_INT);
                    $stmt_shift->bindValue(':anterior_orden', $orden_anterior, PDO::PARAM_INT);
                    $stmt_shift->bindValue(':codigo', $codigo, PDO::PARAM_STR);
                }
                
                $stmt_shift->execute();
            }
            
            // Actualizar el usuario
            $sql_update = "UPDATE clientes SET 
                            nombre = :nombre, 
                            apellido = :apellido, 
                            direccion = :direccion, 
                            estrato = :estrato, 
                            sector = :sector, 
                            uso = :uso, 
                            codigo_medidor = :codigo_medidor, 
                            diametro_medidor = :diametro_medidor, 
                            fundador = :fundador, 
                            activo = :activo, 
                            orden = :orden 
                          WHERE codigo = :codigo";
            
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt_update->bindValue(':apellido', $apellido, PDO::PARAM_STR);
            $stmt_update->bindValue(':direccion', $direccion, PDO::PARAM_STR);
            $stmt_update->bindValue(':estrato', $estrato, PDO::PARAM_INT);
            $stmt_update->bindValue(':sector', $sector, PDO::PARAM_STR);
            $stmt_update->bindValue(':uso', $uso, PDO::PARAM_STR);
            $stmt_update->bindValue(':codigo_medidor', $codigo_medidor, PDO::PARAM_STR);
            $stmt_update->bindValue(':diametro_medidor', $diametro_medidor, PDO::PARAM_STR);
            $stmt_update->bindValue(':fundador', $fundador, PDO::PARAM_STR);
            $stmt_update->bindValue(':activo', $activo, PDO::PARAM_STR);
            $stmt_update->bindValue(':orden', $orden_nuevo, PDO::PARAM_INT);
            $stmt_update->bindValue(':codigo', $codigo, PDO::PARAM_STR);

            if ($stmt_update->execute()) {
                header("Location: " . PUBLIC_URL . "/index.php?page=modificar_cliente&msg=" . urlencode("Usuario modificado exitosamente"));
                exit();
            } else {
                header("Location: " . PUBLIC_URL . "/index.php?page=modificar_cliente&msg=" . urlencode("Error al modificar el usuario"));
                exit();
            }
        } else {
            // Usuario no existe
            header("Location: " . PUBLIC_URL . "/index.php?page=modificar_cliente&msg=" . urlencode("Usuario no encontrado"));
            exit();
        }
    } else {
        // Código no proporcionado
        header("Location: " . PUBLIC_URL . "/index.php?page=modificar_cliente&msg=" . urlencode("Usuario no encontrado o no seleccionado"));
        exit();
    }
} else {
    header("Location: " . PUBLIC_URL . "/index.php?page=modificar_cliente");
    exit();
}
?>