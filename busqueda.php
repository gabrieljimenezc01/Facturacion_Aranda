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
    global $conn, $codigo_cliente, $nombre_cliente, $direccion_cliente, $sector_cliente,
        $uso_cliente, $fundador_cliente, $deuda_cliente, $msg, $msgbase;
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

            $msg = "Cliente no encontrado.";
        }
    } catch (PDOException $e) {
        $msgbase = "Error en la consulta: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
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
        //BUSCAR SI EL CLIENTE ESTA EN LA TABLA DEUDORES
        $conn->beginTransaction();
        $sql = "SELECT COUNT(*) FROM deudores WHERE cod_cliente = :codi_cliente";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codi_cliente', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            //validar que el valor de la deuda sea diferente a 0
            $sql = "SELECT * FROM deudores WHERE cod_cliente = :codi_cliente";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':codi_cliente', $codigo, PDO::PARAM_INT);
            $stmt->execute();

            $valor_total = $stmt->fetch(PDO::FETCH_ASSOC);
            //validar que el abono no supere la deuda
            if ($valor > $valor_total['valor_total']) {
                $msgabono = "Valor de abono mayor al de la deuda";
            } else {
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
                        //validar si el valor de la deuda es 0 para eliminar al cliente
                        $sql = "SELECT * FROM deudores WHERE cod_cliente = :codi_cliente";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':codi_cliente', $codigo, PDO::PARAM_INT);
                        $stmt->execute();
                        $valor_actualizado = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($valor_actualizado['valor_total'] == 0) {
                            //eliminar de deudores si el cliente tiene la deuda en 0
                            $sql = "DELETE FROM deudores WHERE cod_cliente = :codi_cliente";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':codi_cliente', $codigo, PDO::PARAM_INT);
                            $stmt->execute();
                            // echo "cliente eliminado de deudas";
                        }
                        $conn->commit();
                        $msgabono = "Abono registrado y deuda actualizada exitosamente. ";
                    } else {
                        $conn->rollBack();
                        $msgabono = "Error al actualizar la deuda.";
                    }
                } else {
                    $conn->rollBack();
                    $msgabono = "Error al registrar el abono.";
                }
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="deudas-styles.css">
</head>

<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">Modulo Deudas</div>
            <div>
                <button class="logout-button">Cerrar Sesión</button>
            </div>
        </nav>

        <div class="content">
            <aside class="sidebar">
                <ul class="menu-list">
                    <li><a href="deudores.php"><i class="fa fa-user" aria-hidden="true"></i><br>Clientes con Deudas</a></li>
                    <li><a href="busqueda.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br>Pago de Deudas</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <?php if (isset($msgbase)) {
                    echo "<p>$msgbase</p>";
                } ?>

                <div class="busqueda_ususario">
                    <h2>Pago de Deudas</h2>
                    <form action="busqueda.php" method="post">
                        <div class="form-row">
                            <input type="number" name="codigo" required value='<?php echo $codigo_cliente ?>' min="1">
                            <label alt="Label" data-placeholder="Código de usuario..."></label>
                        </div>
                        <div class="form-row">
                            <button type="submit" name="cliente"> Buscar</button>
                        </div>
                    </form>
                </div>

                <?php if (isset($msg)) {
                    echo "<label >$msg </label>";
                } ?>

                <div class="datos-usuario">
                    <table>
                        <tr>
                            <th> Código</th>
                            <th>Nombre y Apellido</th>
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


                <?php if ($deuda_cliente) : ?>
                    <h2>Registrar Abono</h2>
                    <div class="infomacion_abonos">
                        <form action="busqueda.php" method="post">
                            <input type="hidden" name="codigo_cliente" value="<?php echo $codigo_cliente; ?>">


                            <div class="form-row">
                                <input type="date" name="fecha" required>
                                <label alt="Label" data-placeholder="Fecha"></label>
                            </div>

                            <div class="form-row">
                                <input type="text" name="concepto" required maxlength="100">
                                <label alt="Label" data-placeholder="Concepto"></label>
                            </div>

                            <div class="form-row">
                                <input type="number" name="valor" required min="1">
                                <label alt="Label" data-placeholder="Valor"></label>
                            </div>
                            <div class="form-row">
                                <button type="submit" name="abonar">Registrar Abono</button>
                            </div>
                        </form>
                        <?php if (isset($msgabono)) {
                            echo "<p>$msgabono</p>";
                        } ?>
                    </div>
                    <div class="historial-abono">
                        <h2> Historial de Pagos o Abonos </h2>
                        <table>
                            <tr>
                                <th>Código</th>
                                <th>Concepto</th>
                                <th>Fecha</th>
                                <th>Valor</th>
                            </tr>
                            <?php
                            $sql = "SELECT * FROM abonos where cod_cliente= :cliente";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':cliente', $codigo_cliente, PDO::PARAM_INT);
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
            </main>
        </div>
    </div>


</body>

</html>