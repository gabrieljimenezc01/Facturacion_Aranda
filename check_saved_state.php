<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sector = $_POST['sector'];
    $mes = $_POST['mes'];
    $año = $_POST['año'];

    try {
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM factura f JOIN clientes c ON f.cod_cliente = c.codigo WHERE c.sector = ? AND f.mes_cobrado = ? AND YEAR(f.fecha_inicio_cobro) = ? AND f.estado_pago = 'SI'");
        $stmt->execute([$sector, $mes, $año]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            echo "saved"; // Si hay al menos un cliente con estado de pago "SI"
        } else {
            echo "not_saved"; // No hay clientes con estado de pago "SI"
        }
    } catch (PDOException $e) {
        echo "error";
    }
}
?>
