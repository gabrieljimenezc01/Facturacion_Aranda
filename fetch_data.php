<?php
require 'db.php';

$sector = $_POST['sector'];
$mes = $_POST['mes'];
$año = $_POST['año'];

try {
    $stmt = $conn->prepare("
        SELECT c.codigo, c.nombre, c.apellido, f.cod_factura AS factura, f.consumo_m3 AS m3, f.valor_total AS valor_ingreso, f.valor_deuda AS deuda, f.estado_pago
        FROM clientes c
        JOIN factura f ON c.codigo = f.cod_cliente
        WHERE c.sector = ? AND f.mes_cobrado = ? AND YEAR(f.fecha_inicio_cobro) = ?");
    $stmt->execute([$sector, $mes, $año]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($data) {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Codigo</th><th>Nombre</th><th>Apellido</th><th>Factura</th><th>M3</th><th>Valor Ingreso</th><th>Deuda</th><th>Estado Pago</th></tr>";
        foreach ($data as $row) {
            echo "<tr>
                    <td><input type='hidden' name='codigo[]' value='{$row['codigo']}'>{$row['codigo']}</td>
                    <td>{$row['nombre']}</td>
                    <td>{$row['apellido']}</td>
                    <td>{$row['factura']}</td>
                    <td>{$row['m3']}</td>
                    <td>{$row['valor_ingreso']}</td>
                    <td>{$row['deuda']}</td>
                    <td>
                        <select name='estado_pago[]'>
                            <option value='si' " . ($row['estado_pago'] == 'si' ? 'selected' : '') . ">Sí</option>
                            <option value='no' " . ($row['estado_pago'] == 'no' ? 'selected' : '') . ">No</option>
                        </select>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron datos.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
