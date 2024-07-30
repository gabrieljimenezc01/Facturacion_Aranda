<?php
require 'db.php';
$sector = "";
$año = "";
$mes = "MES";
$msg_eliminacion = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sector = $_POST['sector'];
    $mes = $_POST['mes'];
    $año = $_POST['año'];

    try {
        // eliminar facturas x sector and mes and año
        $sql = "DELETE factura FROM factura
                JOIN clientes ON factura.cod_cliente = clientes.codigo 
                WHERE clientes.sector = '$sector' 
                AND factura.mes_cobrado = '$mes' 
                AND YEAR(factura.fecha_fin_cobro) = $año";
        $stmt = $conn->query($sql);
        $stmt->execute();
        $msg_eliminacion = "Ejecución completada";
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
    <title>eliminar facturas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="deudas-styles.css">
</head>

<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">Modulo Deudas y Facturas</div>
            <div><a href="principal.php"><i class="fa fa-home" aria-hidden="true" style="color:white"></i></a></div>
            <div>
                <button class="logout-button">Cerrar Sesión</button>
            </div>
        </nav>

        <div class="content">
            <aside class="sidebar">
                <ul class="menu-list">
                    <li><a href="facturas.php"><i class="fa fa-file" aria-hidden="true"></i><br>Generar Facturas</a></li>
                    <li><a href="facturas.php"><i class="fa fa-print" aria-hidden="true"></i><br>Imprimir Facturas</a></li>
                    <li><a href="facturas.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br>Editar Facturas</a></li>
                    <li><a href="eliminar_facturas.php"><i class="fa fa-trash-o" aria-hidden="true"></i><br>Eliminar Facturas</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <div style=" text-align:center">
                    <h2>Eliminar Facturas</h2>
                </div>
                <div class="content_div_eliminacion">
                    <div style="margin-bottom: 1rem; text-align:center">
                    <label>Digite los datos de las facturas que desea eliminar</label>
                    </div>
                    <form action="" method="post" class="form_eliminacion">
                        <div class="form-row">
                            <input type="number" name="sector" required value='<?php echo $sector ?>' min="1">
                            <label alt="Label" data-placeholder="Sector..."></label>
                        </div>
                        <div class="div_mes">
                            <select name="mes" required id="mes" class="select_mes">
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
                            <input type="number" name="año" required value='<?php echo $año ?>' min="2000">
                            <label alt="Label" data-placeholder="Año..."></label>
                        </div>
                        <div class="form-row">
                            <button type="submit" name="cliente" style=" background-color: red">Eliminar</button>
                        </div>
                    </form>
                    <?php echo $msg_eliminacion; ?>
                </div>
            </main>
        </div>
    </div>
</body>

</html>