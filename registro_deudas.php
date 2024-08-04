<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
};
$codigo = "";
$motivo = "";
$valor = "";
$msg = "";
$valorant= "";
$valorup= "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deuda'])) {
    $codigo = $_POST['codigo'];
    $motivo = $_POST['concepto'];
    $valor = $_POST['valor'];
    try {
        //BUSCAR SI EL CLIENTE ESTA EN LA TABLA DEUDORES
        $sql = "SELECT COUNT(*) FROM deudores WHERE cod_cliente = :codi_cliente";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codi_cliente', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            //buscamos el valor de la deuda
            $sql="SELECT valor_total FROM deudores WHERE cod_cliente=:codigo";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
            $stmt->execute();
            $dato=$stmt->fetch(PDO::FETCH_ASSOC);
            $valorant= $dato['valor_total'];
            //echo"valor anterior: ".$valorant;
            //actualizamos el valor de la deuda
            $valorup=$valorant+$valor;
            //echo"valor nuevo: ".$valorup;
            $sql="UPDATE deudores SET valor_total =:valor WHERE cod_cliente = :codigo";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
            $stmt->bindParam(':valor', $valorup, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $msg = "Deuda Actualizada con éxito";
            }
        }else {
            //insertamos el valor de la nueva deuda
            $sql = "INSERT INTO deudores (cod_cliente, valor_total, motivo) VALUES (:codigo, :valor, :motivo)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
            $stmt->bindParam(':valor', $valor, PDO::PARAM_INT);
            $stmt->bindParam(':motivo', $motivo, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $msg = "Datos ingresados con éxito";
            }
        }
    } catch (PDOException $e) {
        echo "Error en la consulta: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Deudas</title>
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
                <div class="registro_deuda">
                    <div style=" text-align:center">
                        <h2> Registro de Duedas</h2>
                    </div>
                    <div>
                        <p>
                            Digite los datos del usuario y la deuda
                        </p>
                    </div>
                    <form action="registro_deudas.php" method="post" class="form_eliminacion">
                        <div class="form-row">
                            <input type="number" name="codigo" required min="1" value='<?php echo $codigo ?>'>
                            <label alt="Label" data-placeholder="Código del cliente..."></label>
                        </div>
                        <div class="form-row">
                            <input type="text" name="concepto" required maxlength="100" value='<?php echo $motivo ?>'>
                            <label alt="Label" data-placeholder="Concepto de la deuda"></label>
                        </div>
                        <div class="form-row">
                            <input type="number" name="valor" required min="1" value='<?php echo $valor ?>'>
                            <label alt="Label" data-placeholder="Valor"></label>
                        </div>
                        <div class="form-row">
                            <button type="submit" name="deuda">Registrar Deuda</button>
                        </div>
                    </form>
                    <?php if (isset($msg)) {
                        echo "<p>$msg</p>";
                    } ?>
                </div>
            </main>
        </div>
    </div>
</body>

</html>