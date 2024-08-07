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

    // Verificar si el usuario existe
    if ($codigo != "") {
        $sql_verificar = "SELECT * FROM clientes WHERE codigo = :codigo";
        $stmt_verificar = $conn->prepare($sql_verificar);
        $stmt_verificar->bindValue(':codigo', $codigo, PDO::PARAM_STR);
        $stmt_verificar->execute();
        $usuario = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Usuario existe, proceder con la actualización
            $sql_update = "UPDATE clientes SET nombre = :nombre, apellido = :apellido, direccion = :direccion, estrato = :estrato, sector = :sector, uso = :uso, codigo_medidor = :codigo_medidor, diametro_medidor = :diametro_medidor, fundador = :fundador, activo = :activo WHERE codigo = :codigo";
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
