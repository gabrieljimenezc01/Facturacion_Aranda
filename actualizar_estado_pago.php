<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar'])) {
    $cod_factura = $_POST['cod_factura'];
    $nuevo_estado_pago = $_POST['estado_pago'];
    $valor_total = $_POST['valor_total'];  // Asegúrate de que este valor se pase correctamente
    $codigo_cliente = $_POST['codigo_cliente'];

    try {
        // Verificar si el cliente existe en la tabla clientes
        $stmt_check_cliente = $conn->prepare("SELECT codigo FROM clientes WHERE codigo = ?");
        $stmt_check_cliente->execute([$codigo_cliente]);
        $cliente_existe = $stmt_check_cliente->fetch(PDO::FETCH_ASSOC);

        if (!$cliente_existe) {
            throw new Exception("El cliente no existe en la base de datos.");
        }
        $stmt_check_status= $conn->prepare("SELECT estado_pago FROM factura WHERE cod_factura =?");
        $stmt_check_status->execute([$cod_factura]);
        $estado = $stmt_check_status->fetch(PDO::FETCH_ASSOC);
        $estado_actual=$estado['estado_pago'];
        if ($estado_actual==$nuevo_estado_pago) {
            echo "El estado Pago de la factura es ".$estado_actual.", por lo tanto no hay cambio";
        } else{
        // Obtener la deuda actual del cliente
        $stmt_deuda = $conn->prepare("SELECT valor_total FROM deudores WHERE cod_cliente = ?");
        $stmt_deuda->execute([$codigo_cliente]);
        $deudor = $stmt_deuda->fetch(PDO::FETCH_ASSOC);

        // Actualizar el estado de pago en la tabla factura
        $stmt_update = $conn->prepare("UPDATE factura SET estado_pago = ? WHERE cod_factura = ?");
        $stmt_update->execute([$nuevo_estado_pago, $cod_factura]);

        if ($nuevo_estado_pago === 'NO') {
            if ($deudor) {
                // Sumar el valor total a la deuda existente
                $nuevo_valor_total = $deudor['valor_total'] + $valor_total;
                $stmt_update_deuda = $conn->prepare("UPDATE deudores SET valor_total = ? WHERE cod_cliente = ?");
                $stmt_update_deuda->execute([$nuevo_valor_total, $codigo_cliente]);
            } else {
                // Insertar nueva deuda
                $stmt_insert_deuda = $conn->prepare("INSERT INTO deudores (cod_cliente, valor_total) VALUES (?, ?)");
                $stmt_insert_deuda->execute([$codigo_cliente, $valor_total]);
            }
        } elseif ($nuevo_estado_pago === 'SI' && $deudor) {
            // Si el cliente ha pagado parcialmente o totalmente
            $nuevo_valor_total = max($deudor['valor_total'] - $valor_total, 0);

            if ($nuevo_valor_total > 0) {
                $stmt_update_deuda = $conn->prepare("UPDATE deudores SET valor_total = ? WHERE cod_cliente = ?");
                $stmt_update_deuda->execute([$nuevo_valor_total, $codigo_cliente]);
            } else {
                // Eliminar la deuda si está pagada completamente
                $stmt_delete_deuda = $conn->prepare("DELETE FROM deudores WHERE cod_cliente = ?");
                $stmt_delete_deuda->execute([$codigo_cliente]);
            }
        }

        echo "Cambio realizado";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
