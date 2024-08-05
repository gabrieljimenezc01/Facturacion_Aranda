<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
};

// Configurar cabecera para recibir JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decodificar los datos JSON recibidos
    $data = json_decode(file_get_contents('php://input'), true);

    // Verificar si los datos JSON están bien formateados
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
        exit();
    }

    // Extraer datos generales y facturas del JSON
    $generalData = $data['generalData'];
    $facturas = $data['facturas'];

    // Extraer datos generales
    $fi = $generalData['fecha_inicio'];
    $ff = $generalData['fecha_fin'];
    $fc = $generalData['fecha_cobro'];
    $mes = $generalData['mes_facturado'];
    $sector = $generalData['sector_facturado'];

        $query = "SELECT COUNT(*) FROM factura f INNER JOIN clientes c ON f.cod_cliente = c.codigo WHERE c.sector = :sector AND f.mes_cobrado = :mes AND YEAR(f.fecha_fin_cobro) = YEAR(:fecha_fin)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':sector', $sector);
        $stmt->bindValue(':mes', $mes);
        $stmt->bindValue(':fecha_fin', $ff);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Si ya existen facturas, retornamos un error
            echo json_encode(["status" => "error", "message" => "Invalid request method"]);
        }else {

        }

    // Preparar una variable para almacenar el mensaje de error si ocurre
    $error_message = '';

    // Iniciar una transacción
    $conn->beginTransaction();

    try {
        $query = "SELECT COUNT(*) FROM factura f INNER JOIN clientes c ON f.cod_cliente = c.codigo WHERE c.sector = :sector AND f.mes_cobrado = :mes AND YEAR(f.fecha_fin_cobro) = YEAR(:fecha_fin)";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':sector', $sector);
        $stmt->bindValue(':mes', $mes);
        $stmt->bindValue(':fecha_fin', $ff);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Si ya existen facturas, retornamos un error
            echo json_encode(["status" => "error", "message" => "Invalid request method"]);
        }else {
            foreach ($facturas as $row) {
                $codigo = $row['codigo'];
                $nombre = $row['nombre'];
                $apellido = $row['apellido'];
                $fundador = $row['fundador'];
                $lectura_anterior = $row['lectura_anterior'];
                $lectura_actual = $row['lectura_actual'];
                $consumo = $row['consumo'];
                $anotaciones = $row['anotaciones'];
                $deuda = $row['deuda'];
                $total = $row['total'];
                $valor_basico = $row['valor_basico'];
                $valor_consumo = $row['valor_consumo'];
                $valor_factura = $row['valor_factura'];
                $estado = 'NO';
    
                $query = "INSERT INTO factura (`cod_cliente`, `fecha_inicio_cobro`, `fecha_fin_cobro`, `mes_cobrado`, `lectura_inicial`, `lectura_final`, `consumo_m3`, `valor_total`, `valor_consumo`, `valor_basico`, `valor_factura`, `valor_deuda`, `Anotaciones`, `estado_pago`, `fecha_limite_pago`) VALUES (:cod_cliente, :fecha_inicio_cobro, :fecha_fin_cobro, :mes_cobrado, :lectura_inicial, :lectura_final, :consumo_m3, :valor_total, :valor_consumo, :valor_basico, :valor_factura, :valor_deuda, :Anotaciones,  :estado_pago, :fecha_limite_pago)";
                $stmt = $conn->prepare($query);
                $stmt->bindValue(':cod_cliente', $codigo);
                $stmt->bindValue(':fecha_inicio_cobro', $fi);
                $stmt->bindValue(':fecha_fin_cobro', $ff);
                $stmt->bindValue(':mes_cobrado', $mes);
                $stmt->bindValue(':lectura_inicial', $lectura_anterior);
                $stmt->bindValue(':lectura_final', $lectura_actual);
                $stmt->bindValue(':consumo_m3', $consumo);
                $stmt->bindValue(':valor_total', $total);
                $stmt->bindValue(':valor_consumo', $valor_consumo);
                $stmt->bindValue(':valor_basico', $valor_basico);
                $stmt->bindValue(':valor_factura', $valor_factura);
                $stmt->bindValue(':valor_deuda', $deuda);
                $stmt->bindValue(':Anotaciones', $anotaciones);
                $stmt->bindValue(':estado_pago', $estado);
                $stmt->bindValue(':fecha_limite_pago', $fc);
                $stmt->execute();
            }
            // Confirmar la transacción
            $conn->commit();
            echo json_encode(["status" => "success"]);
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollBack();
        $error_message = $e->getMessage();
        echo json_encode(["status" => "error", "message" => "Database error: " . $error_message]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
