<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
};
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="deudas-styles.css">
</head>

<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">Facturación</div>
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

                <div class="filtro">
                    <!-- Formulario de filtrado -->
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <label>Seleccionar Facturas Por: </label>
                        <div class="form-row">
                            <input type="number" min="1" required name="sector" value='<?php echo $sector ?>'>
                            <label alt="Label" data-placeholder="Sector"></label>
                        </div>
                        <div class="form-row">
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
                        <a href='generate_pdf.php?cod_factura=" . htmlspecialchars($row["cod_factura"]) . "' target='_blank'>
                            <i class='fa fa-file-pdf-o' aria-hidden='true'></i>
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
                <?php if (!empty($result)) : ?>
                    <div>
                        <form action="generar_facturas.php" method="post">
                            <input type="hidden" name="sector" value='<?php echo $sector ?>'>
                            <input type="hidden" name="mes" value='<?php echo $mes ?>'>
                            <input type="hidden" name="año" value='<?php echo $año ?>'>
                            <button type="submit" name="descarga">Descargar facturas</button>
                        </form>
                    </div>
                <?php endif ?>
            </main>
        </div>

    </div>
</body>
<script>
    function cerrar(){    
        setTimeout(function(){ window.location="<?= 'logout.php' ?>"; }, 0000); // Aquí es donde se "redirecciona" luego de trancurridos los N segundos que indiques
    }
</script>

</html>