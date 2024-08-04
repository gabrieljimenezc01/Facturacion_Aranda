<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
};

$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
$nombre = "";
$sql = "SELECT factura.*, clientes.nombre, clientes.apellido 
        FROM factura JOIN clientes 
        ON factura.cod_cliente = clientes.codigo
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
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="deudas-styles.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
</head>

<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">Modulo Deudas</div>
            <div><a href="principal.php"><i class="fa fa-home" aria-hidden="true" style="color:white; font-size: 30px"></i></a></div>
            <div>
            <button class="logout-button" onclick="cerrar()">Cerrar Sesión</button>
            </div>
        </nav>

        <div class="content">
            <aside class="sidebar">
                <ul class="menu-list">
                    <li><a href="deudores.php"><i class="fa fa-list" aria-hidden="true"></i><br>Lista Deudores</a></li>
                    <li><a href="busqueda.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br>Acuerdos de pago</a></li>
                    <li><a href="clientes_facturas.php"><i class="fa fa-user" aria-hidden="true"></i><br>Facturas de clientes</a></li>
                    <li><a href="registro_deudas.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i><br>Registro de Deuda</a></li>
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
                                <th>Guardar</th>
                            </tr>
                            <?php if (count($result) > 0) {
                                foreach ($result as $row) {
                                    echo "<tr> 
                                            <td>" . $row['cod_factura'] . "</td>
                                            <td>" . $row['mes_cobrado'] . "</td>
                                            <td>" . $row['consumo_m3'] . "</td>
                                            <td>" . $row['valor_deuda'] . "</td>
                                            <td>" . $row['valor_total'] . "</td>
                                            <td>
                                                <select name='estado_pago' id='estado_pago_{$row['cod_factura']}'>
                                                    <option value='si' " . ($row['estado_pago'] == 'si' ? 'selected' : '') . ">Sí</option>
                                                    <option value='no' " . ($row['estado_pago'] == 'no' ? 'selected' : '') . ">No</option>
                                                </select>
                                            </td>
                                            <td><a href='generate_pdf.php?cod_factura=" . htmlspecialchars($row["cod_factura"]) . "' target='_blank'>
                                                    <i class='fa fa-file-pdf-o' aria-hidden='true'></i>
                                                </a>
                                            </td>
                                            <td>
                                                <button class='save-btn' data-factura='{$row['cod_factura']}'>Guardar</button>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8'>No hay registros en el inventario</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
<script>
    function cerrar(){    
        setTimeout(function(){ window.location="<?= 'logout.php' ?>"; }, 0000); 
    }

    document.querySelectorAll('.save-btn').forEach(button => {
        button.addEventListener('click', function() {
            var cod_factura = this.getAttribute('data-factura');
            var estado_pago = document.getElementById('estado_pago_' + cod_factura).value;
            var valor_total = this.closest('tr').querySelector('td:nth-child(5)').innerText;
            var codigo_cliente = <?php echo json_encode($codigo); ?>;

            var formData = new FormData();
            formData.append('cod_factura', cod_factura);
            formData.append('estado_pago', estado_pago);
            formData.append('valor_total', valor_total);
            formData.append('codigo_cliente', codigo_cliente);
            formData.append('guardar', true);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "actualizar_estado_pago.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.send(formData);
        });
    });
</script>
</html>
