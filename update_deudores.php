<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sector = $_POST['sector'];
    $mes = $_POST['mes'];
    $año = $_POST['año'];
    $codigos = $_POST['codigo'];
    $estados_pago = $_POST['estado_pago'];
    $valores = $_POST['valor'];

    try {
        foreach ($codigos as $index => $codigo) {
            $estado_pago = $estados_pago[$index];
            $valor = $valores[$index];

            // Verificar si ya existe un registro en deudores para este cliente, mes y año
            $stmt_check = $conn->prepare("SELECT * FROM deudores WHERE cod_cliente = ? AND mes_cobrado = ? AND año_cobrado = ?");
            $stmt_check->execute([$codigo, $mes, $año]);
            $deudor = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($estado_pago === 'no') {
                if ($deudor) {
                    // Si existe, no hagas nada para evitar duplicados
                    continue;
                } else {
                    // Si no existe, inserta un nuevo registro en la tabla deudores
                    $stmt_insert = $conn->prepare("INSERT INTO deudores (cod_cliente, valor_total, mes_cobrado, año_cobrado) VALUES (?, ?, ?, ?)");
                    $stmt_insert->execute([$codigo, $valor, $mes, $año]);
                }
            } elseif ($estado_pago === 'si') {
                if ($deudor) {
                    // Si el estado de pago es "SI", elimina el registro de la tabla deudores si existe
                    $stmt_delete = $conn->prepare("DELETE FROM deudores WHERE cod_cliente = ? AND mes_cobrado = ? AND año_cobrado = ?");
                    $stmt_delete->execute([$codigo, $mes, $año]);
                }
            }
        }
        echo "success";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
