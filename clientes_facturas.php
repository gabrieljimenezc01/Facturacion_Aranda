<?php
require 'db.php';

$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
$nombre = "";
$sql = "SELECT factura.*, clientes.nombre, clientes.apellido 
        FROM factura JOIN clientes 
        ON factura.cod_cliente=clientes.codigo
        WHERE cod_cliente = :codigo";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':codigo', $codigo, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($result) > 0) {
    $nombre = $result[0]['nombre'] . ' ' . $result[0]['apellido'];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas del Cliente</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="deudas-styles.css">
</head>

<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">Modulo Deudas y Facturas</div>
            <div>
                <button class="logout-button">Cerrar Sesión</button>
            </div>
        </nav>

        <div class="content">
            <aside class="sidebar">
                <ul class="menu-list">
                    <li><a href="deudores.php"><i class="fa fa-list" aria-hidden="true"></i><br>Lista Deudores</a></li>
                    <li><a href="busqueda.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br>Acuerdos de pago</a></li>
                    <li><a href="clientes_facturas.php"><i class="fa fa-user" aria-hidden="true"></i><br>Facturas de clientes</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <div class="busqueda_ususario">
                    <h2>Búsqueda del Cliente</h2>
                    <form action="" method="post">
                        <div class="form-row">
                            <input type="number" name="codigo" required value='<?php echo $codigo ?>' min="1">
                            <label alt="Label" data-placeholder="Código de usuario..."></label>
                        </div>
                        <div class="form-row">
                            <button type="submit" name="cliente"> Buscar</button>
                        </div>
                    </form>
                </div>
                <div class="facturas">
                    <div class="titulofacturas">
                        <h2>Facturas del Cliente <?php echo $nombre ?></h2>
                    </div>
                    <div class="lista_facturas">
                        <table>
                            <tr>
                                <th>No de Factura</th>
                                <th>Mes Cobrado</th>
                                <th>Consumo M3</th>
                                <th>Valor de Deuda</th>
                                <th>Valor Total</th>
                                <th>Estado de Pago</th>
                                <th>Ver</th>
                            </tr>
                            <?php if (count($result) > 0) {
                                foreach ($result as $row) {
                                    echo "<tr> 
                                            <th>" . $row['cod_factura'] . "</th>
                                            <th>" . $row['mes_cobrado'] . "</th>
                                            <th>" . $row['consumo_m3'] . "</th>
                                            <th>" . $row['valor_deuda'] . "</th>
                                            <th>" . $row['valor_total'] . "</th>
                                            <th>" . $row['estado_pago'] . "</th>
                                            <td><a href='generate_pdf.php?cod_factura=" . htmlspecialchars($row["cod_factura"]) . "' target='_blank'>
                                                    <i class='fa fa-file-pdf-o' aria-hidden='true'></i>
                                                </a>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No hay registros en el inventario</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>