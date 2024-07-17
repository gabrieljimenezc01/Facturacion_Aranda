<?php
require 'db.php';
$codigo_cliente = "";
$nombre_cliente = "";
$direccion_cliente = "";
$sector_cliente = "";
$uso_cliente = "";
$fundador_cliente = "";
$deuda_cliente = "";

//buscar clientes en la base de datos
function datos($codigo)
{
    global $conn, $codigo_cliente, $nombre_cliente, $direccion_cliente, $sector_cliente, $uso_cliente, $fundador_cliente, $deuda_cliente;
    try {
        $sql = "SELECT * FROM clientes WHERE codigo = :codigo ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);

        $stmt->execute();

        $turno = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($turno) {
            // Si se encontró el cliente, mostrar la informacion
            $codigo_cliente = $turno['codigo'];
            $nombre_cliente = $turno['nombre'] . " " . $turno['apellido'];
            $direccion_cliente = $turno['direccion'];
            $sector_cliente = $turno['sector'];
            $uso_cliente = $turno['uso'];
            $fundador_cliente = $turno['fundador'];

            $sql = "SELECT valor_total FROM deudores WHERE cod_cliente = :cliente ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cliente', $turno['codigo'], PDO::PARAM_INT);
            $stmt->execute();
            $deuda = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($deuda) {
                $deuda_cliente = $deuda['valor_total'];
            } else {
                $deuda_cliente = "0";
            }
        } else {
            // Si no se encontró el cliente, mostrar un mensaje
            echo "Cliente no encontrado.";
        }
    } catch (PDOException $e) {
        echo "Error en la consulta: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
}

//procesar datos del cliente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cliente'])) {
    $codigo = $_POST['codigo'];
    datos($codigo);
}

// Procesar abono
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['abonar'])) {
    $codigo = $_POST['codigo_cliente'];
    $concepto = $_POST['concepto'];
    $fecha = $_POST['fecha'];
    $valor = $_POST['valor'];

    try {
        $conn->beginTransaction();
        $sql = "SELECT COUNT(*) FROM deudores WHERE cod_cliente = :codi_cliente";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codi_cliente', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Insertar el abono en la tabla abonos
            $sql = "INSERT INTO abonos (cod_cliente, concepto, fecha, valor) VALUES (:codigo_cliente, :concepto, :fecha, :valor)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':codigo_cliente', $codigo, PDO::PARAM_INT);
            $stmt->bindParam(':concepto', $concepto, PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':valor', $valor, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Actualizar el valor de la deuda en la tabla deudores
                $sql = "UPDATE deudores SET valor_total = valor_total - :valor WHERE cod_cliente = :codigo_cliente";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':valor', $valor, PDO::PARAM_INT);
                $stmt->bindParam(':codigo_cliente', $codigo, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $conn->commit();
                    echo "Abono registrado y deuda actualizada exitosamente.";
                } else {
                    $conn->rollBack();
                    echo "Error al actualizar la deuda.";
                }
            } else {
                $conn->rollBack();
                echo "Error al registrar el abono.";
            }
        } else {
            echo "El Cliente no tiene deudas registradas";
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error en la consulta: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
    datos($codigo);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busqueda de Usarios </title>
</head>

<body>
    <div id="busqueda_ususario">
        <h2>Busquedad de Usuarios en deuda</h2>
        <form action="busqueda.php" method="post">
            <label>codigo de usuario</label>
            <input type="number" name="codigo" required value='<?php echo $codigo_cliente ?>'>
            <button type="submit" name="cliente"> Buscar</button>
        </form>
    </div>
    <div id="datos-usuario">
        <h2>informacion del usuario</h2>
        <table>
            <tr>
                <th> Código</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Sector</th>
            </tr>
            <tr>
                <th><?php echo $codigo_cliente ?></th>
                <th><?php echo $nombre_cliente ?></th>
                <th><?php echo $direccion_cliente ?></th>
                <th><?php echo $sector_cliente ?></th>

            </tr>
            <tr>
                <th>Uso</th>
                <th>Fundador</th>
                <th>Valor de Deuda</th>
            </tr>
            <tr>
                <th><?php echo $uso_cliente ?></th>
                <th><?php echo $fundador_cliente ?></th>
                <th><?php echo $deuda_cliente ?></th>
            </tr>
        </table>
    </div>
    <div id="infomacion_abonos">
        <?php if ($deuda_cliente) : ?>
            <h2>Registrar Abono</h2>
            <form action="busqueda.php" method="post">
                <input type="hidden" name="codigo_cliente" value="<?php echo $codigo_cliente; ?>">
                <label>Concepto</label>
                <input type="text" name="concepto" required>
                <label>Fecha</label>
                <input type="date" name="fecha" required>
                <label>Valor</label>
                <input type="number" name="valor" required>
                <button type="submit" name="abonar">Registrar Abono</button>
            </form>

            <h2> Historial de Pagos o Abonos </h2>
            <table>
                <tr>
                    <th>Codigo</th>
                    <th>Concepto</th>
                    <th>Fecha</th>
                    <th>Valor</th>
                </tr>
                <?php
                $sql = "SELECT * FROM abonos";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $abonos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($abonos) > 0) {
                    foreach ($abonos as $row) {
                        echo "<tr>
                                <td> " . $row["cod_cliente"] . "</td>
                                <td> " . $row["concepto"] . "</td>
                                <td> " . $row["fecha"] . "</td>
                                <td> " . $row["valor"] . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay registros en el inventario</td></tr>";
                }
                ?>
            </table>
        <?php endif; ?>
    </div>


</body>

</html>