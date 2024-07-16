<?php
require 'db.php';
$codigo_cliente = "";
$nombre_cliente = "";
$direccion_cliente = "";
$sector_cliente = "";
$uso_cliente = "";
$fundador_cliente = "";
$deuda_cliente = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cliente'])) {
    $codigo = $_POST['codigo'];

    try {
        $sql = "SELECT * FROM clientes WHERE codigo = :codigo ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);

        $stmt->execute();

        $turno = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($turno) {
            // Si se encontró el cliente, mostrar la informacion
            $codigo_cliente = $turno['codigo'];
            $nombre_cliente = $turno['nombre']." ".$turno['apellido'];
            $direccion_cliente = $turno['direccion'];
            $sector_cliente = $turno['sector'];
            $uso_cliente = $turno['uso'];
            $fundador_cliente = $turno['fundador'];

            $sql="SELECT valor_total FROM deudores WHERE cod_cliente = :cliente ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cliente', $turno['codigo'], PDO::PARAM_INT);
            $stmt->execute();
            $deuda = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($deuda) {
                $deuda_cliente = $deuda['valor_total'];
            } else{
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


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busqueda de Usarios </title>
</head>

<body>
    <h2>Busquedad de Usuarios en deuda</h2>

    <form action="" method="post">
        <label>codigo de usuario</label>
        <input type="number" name="codigo"> 
        <button type="submit" name="cliente"> Buscar</button>
    </form>

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

</body>

</html>