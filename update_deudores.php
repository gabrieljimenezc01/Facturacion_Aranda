<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigos = $_POST['codigo'];
    $estados_pago = $_POST['estado_pago'];
    $valores = $_POST['valor'];
    $sector = $_POST['sector'];
    $mes = $_POST['mes'];
    $año = $_POST['año'];

    try {
        foreach ($codigos as $index => $codigo) {
            $estado_pago = strtoupper($estados_pago[$index]); // Convertir a mayúsculas
            $valor = $valores[$index];

            // Actualizar el estado de pago en la tabla factura
            $stmt_update_factura = $conn->prepare("UPDATE factura SET estado_pago = ? WHERE cod_cliente = ? AND mes_cobrado = ? AND YEAR(fecha_inicio_cobro) = ?");
            $stmt_update_factura->execute([$estado_pago, $codigo, $mes, $año]);

            // Verificar si ya existe un registro en deudores para este cliente
            $stmt_check = $conn->prepare("SELECT * FROM deudores WHERE cod_cliente = ?");
            $stmt_check->execute([$codigo]);
            $deudor = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($estado_pago === 'NO') {
                if ($deudor) {
                    // Si existe, actualiza el valor total sumando el nuevo valor
                    $stmt_update = $conn->prepare("UPDATE deudores SET valor_total = valor_total + ? WHERE cod_cliente = ?");
                    $stmt_update->execute([$valor, $codigo]);
                } else {
                    // Si no existe, inserta un nuevo registro en la tabla deudores
                    $stmt_insert = $conn->prepare("INSERT INTO deudores (cod_cliente, valor_total) VALUES (?, ?)");
                    $stmt_insert->execute([$codigo, $valor]);
                }
            } /*elseif ($estado_pago === 'SI' && $deudor) {
                // Si el estado de pago es "SI", elimina el registro de la tabla deudores si existe
                $stmt_delete = $conn->prepare("DELETE FROM deudores WHERE cod_cliente = ?");
                $stmt_delete->execute([$codigo]);
            }*/
        }
        echo "success";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
