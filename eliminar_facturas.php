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
        // eliminar facturas x sector and mes and año
        $sql = "DELETE factura FROM factura
                JOIN clientes ON factura.cod_cliente = clientes.codigo 
                WHERE clientes.sector = '$sector' 
                AND factura.mes_cobrado = '$mes' 
                AND YEAR(factura.fecha_fin_cobro) = $año";
        $stmt= $conn->query($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $msg_eliminacion ="Eliminación exitosa";
        } else {
            $msg_eliminacion= "No se encontraron facturas para eliminar";
        }
        
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
                    <li><a href="deudores.php"><i class="fa fa-list" aria-hidden="true"></i><br>Lista Deudores</a></li>
                    <li><a href="busqueda.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br>Acuerdos de pago</a></li>
                    <li><a href="clientes_facturas.php"><i class="fa fa-user" aria-hidden="true"></i><br>Facturas de clientes</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <div class="content_div_eliminacion">
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
                            <button type="submit" name="cliente">Eliminar</button>
                        </div>
                    </form>
                    <?php  echo $msg_eliminacion;?>
                </div>
            </main>
        </div>
    </div>
</body>

</html>