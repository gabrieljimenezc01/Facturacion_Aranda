<?php

require 'db.php';

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
            //logica de orden
            $orden_anterior = (int)$usuario['orden'];
            $orden_nuevo = $orden;

            // Si seleccionó "ninguna", calculamos el nuevo orden al final
            if ($orden === 'ninguna') {
                $sql_max = "SELECT MAX(orden) FROM clientes WHERE sector = :sector";
                $stmt_max = $conn->prepare($sql_max);
                $stmt_max->bindValue(':sector', $sector, PDO::PARAM_STR);
                $stmt_max->execute();
                $orden_nuevo = (int)$stmt_max->fetchColumn() + 1;
            } else {
                $orden_nuevo = (int)$orden;
            }

            // Solo mover si el orden ha cambiado
            if ($orden_nuevo !== $orden_anterior) {
                if ($orden_anterior == 0) {
                    // Cliente nuevo o sin orden previa: insertar en la posición deseada
                    $sql_shift = "UPDATE clientes 
                                SET orden = orden + 1 
                                WHERE orden >= :nuevo_orden 
                                AND codigo != :codigo";
                } elseif ($orden_nuevo < $orden_anterior) {
                    // Movimiento hacia arriba
                    $sql_shift = "UPDATE clientes 
                                SET orden = orden + 1 
                                WHERE orden >= :nuevo_orden 
                                AND orden < :anterior_orden 
                                AND codigo != :codigo";
                } else {
                    // Movimiento hacia abajo
                    $sql_shift = "UPDATE clientes 
                                SET orden = orden - 1 
                                WHERE orden <= :nuevo_orden 
                                AND orden > :anterior_orden 
                                AND codigo != :codigo";
                }

                // Preparar la consulta
                $stmt_shift = $conn->prepare($sql_shift);
                $stmt_shift->bindValue(':nuevo_orden', $orden_nuevo, PDO::PARAM_INT);
                if ($orden_anterior != 0) {
                    $stmt_shift->bindValue(':anterior_orden', $orden_anterior, PDO::PARAM_INT);
                }
                $stmt_shift->bindValue(':codigo', $codigo, PDO::PARAM_STR);
                $stmt_shift->execute();
            }
            
            // Usuario existe, proceder con la actualización
            $sql_update = "UPDATE clientes SET nombre = :nombre, apellido = :apellido, direccion = :direccion, estrato = :estrato, sector = :sector, uso = :uso, codigo_medidor = :codigo_medidor, diametro_medidor = :diametro_medidor, fundador = :fundador, activo = :activo, orden = :orden WHERE codigo = :codigo";
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
            $stmt_update->bindValue(':codigo', $codigo, PDO::PARAM_STR);
            $stmt_update->bindValue(':orden', $orden_nuevo, PDO::PARAM_STR);

            if ($stmt_update->execute()) {
                header('Location: modificar-usuario.php?msg=Usuario modificado exitosamente');
                exit();
            } else {
                header('Location: modificar-usuario.php?msg=Error al modificar el usuario');
                exit();
            }
        } else {
            // Usuario no existe
            header('Location: modificar-usuario.php?msg=Usuario no encontrado');
            exit();
        }
    }else{
        // Usuario no existe
        header('Location: modificar-usuario.php?msg=Usuario no encontrado o no seleccionado');
        exit();
    }
}else {
    header('Location: modificar-usuario.php');
    exit();
}
