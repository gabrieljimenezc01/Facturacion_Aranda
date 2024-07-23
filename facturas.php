<?php
require 'db.php';
$sector = "";
$año = "";
$mes = "MES";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sector = $_POST['sector'];
    $mes = $_POST['mes'];
    $año = $_POST['año'];

    try {
        // Construir la consulta SQL concatenando las cadenas
        $sql = "SELECT DISTINCT *FROM factura 
                JOIN clientes ON factura.cod_cliente = clientes.codigo 
                WHERE clientes.sector = '$sector' 
                AND factura.mes_cobrado = '$mes' 
                AND YEAR(factura.fecha_fin_cobro) = $año";
        $stmt = $conn->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impresión de Facturas</title>
    <link rel="stylesheet" href="facturas-styles.css">
</head>

<body>
    <div class="filtro">
        <!-- Formulario de filtrado -->
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label>Seleccionar Facturas Por: </label>
            <div class="form-row">
                <input type="number" min="1" required name="sector" value='<?php echo $sector ?>'>
                <label alt="Label" data-placeholder="Sector"></label>
            </div>
            <div class="form-row">
                <select name="mes" required id="mes">
                    <option value="<?php echo $mes ?>"><?php echo $mes ?></option>
                    <option value="ENERO">ENERO</option>
                    <option value="FEBRERO">FEBRERO</option>
                    <option value="MARZO">MARZO</option>
                    <option value="ABRIL">ABRIL</option>
                    <option value="MAYO">MAYO</option>
                    <option value="JUNIO">JUNIO</option>
                    <option value="JULIO">JULIO</option>
                    <option value="AGOSTO">AGOSTO</option>
                    <option value="SEPTIEMBRE">SEPTIEMBRE</option>
                    <option value="OCTUBRE">OCTUBRE</option>
                    <option value="NOVIEMBRE">NOVIEMBRE</option>
                    <option value="DICIEMBRE">DICIEMBRE</option>
                </select>
            </div>
            <div class="form-row">
                <input type="number" min="2000" required name="año" min value='<?php echo $año ?>'>
                <label alt="Label" data-placeholder="Año de Cobro"></label>
            </div>
            <div class="form-row">
                <button type="submit" name="busqueda">Buscar</button>
            </div>
        </form>
    </div>
    <div>
        <table>
            <tr>
                <th>Código Factura</th>
                <th>Código Ususario</th>
                <th>Nombre Completo</th>
                <th>uso</th>
                <th>Sector</th>
                <th>Fundador</th>
                <th>Consumo m3</th>
                <th>Valor Deuda</th>
                <th>Valor Factura</th>
                <th>Acciones</th>
            </tr>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($result)) {
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['cod_factura']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['codigo']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nombre'] . " " . $row['apellido']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['uso']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['sector']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fundador']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['consumo_m3']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['valor_deuda']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['valor_total']) . "</td>";
                    echo "<td>
                                <a href='#" . $row["cod_factura"] . "'  onclick='return confirm(\"¿Estás seguro de que deseas ver este registro?\")'>
                                <img class='img-borrar' src='./img/borrar.png' alt='Eliminar'>
                                </a>
                            </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No hay registros</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>