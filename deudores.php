<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
};


// Filtrado de clientes
$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
// $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$sector = isset($_POST['sector']) ? $_POST['sector'] : '';
// "SELECT * FROM clientes JOIN deudores WHERE deudores.cod_cliente= clientes.codigo";
$sql = "SELECT * FROM clientes JOIN deudores WHERE (clientes.codigo= deudores.cod_cliente) AND (clientes.codigo LIKE :codigo) AND (sector LIKE :sector)";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':codigo', "%$codigo%", PDO::PARAM_STR);
$stmt->bindValue(':sector', "%$sector%", PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Deudores</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="deudas-styles.css">
</head>

<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">Modulo Deudas y Facturas</div>
            <div><a href="principal.php"><i class="fa fa-home" aria-hidden="true" style="color:white"></i></a></div>
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
                </ul>
            </aside>
            <main class="main-content">
                <h2>Deudores</h2>

                <div class="filtro">
                    <!-- Formulario de filtrado -->
                    <form method="POST" >
                        <label>Filtrar Por: </label>

                        <div class="form-row">
                        <input type="number" name="codigo"  value='<?php echo $codigo?>' min="1">
                        <label alt="Label" data-placeholder="Código de usuario"></label>
                        </div>

                        <div class="form-row">
                        <input type="number" name="sector"  value='<?php echo $sector?>' min="1">
                        <label alt="Label" data-placeholder="Sector"></label>
                        </div>                 

                        <div class="form-row">
                        <button type="submit">Filtrar</button>
                        </div>
                    </form>

                    <table>
                        <tr>
                            <th>Código</th>
                            <th>Nombre Completo</th>
                            <th>Dirección</th>
                            <th>Sector</th>
                            <th>Fundador</th>
                            <th>Valor de Deuda</th>
                        </tr>
                        <?php
                        if (count($result) > 0) {
                            foreach ($result as $row) {
                                echo "<tr>
                            <td> " . $row["codigo"] . "</td>
                            <td> " . $row["nombre"] . " " . $row["apellido"] . "</td>
                            <td> " . $row["direccion"] . "</td>
                            <td> " . $row["sector"] . "</td>
                            <td> " . $row["fundador"] . "</td>
                             <td> " . $row["valor_total"] . "</td>
                          </tr>";
                            }
                        }
                        ?>
                    </table>

                </div>
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