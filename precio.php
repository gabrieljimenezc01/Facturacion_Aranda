<?php
require 'db.php';

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM Inventario WHERE codigo = $delete_id";

    if ($conn->query($sql) === TRUE) {
        echo "Registro eliminado con éxito";
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['id'] as $key => $id) {
        $medida_inicial = $_POST['medida_inicial'][$key];
        $medida_final = $_POST['medida_final'][$key];
        $valor_residencial = $_POST['valor_residencial'][$key];
        $valor_comercial = $_POST['valor_comercial'][$key];
        $valor_industrial = $_POST['valor_industrial'][$key];
        $valor_fundador = $_POST['valor_fundador'][$key];


        $sql = "UPDATE `precio` SET medida_inicial ='$medida_inicial',medida_final='$medida_final',valor_residencial='$valor_residencial',valor_comercial='$valor_comercial',valor_industrial='$valor_industrial',valor_fundador='$valor_fundador' WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            $update_msg = "Registros actualizados con éxito";
        } else {
            $update_msg = "Error al actualizar los registros: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Precios</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 10px 20px;
            text-decoration: none;
            margin: 5px;
            border-radius: 5px;
        }
        .save-btn {
            background-color: #4CAF50;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        .pdf-btn {
            background-color: #2196F3;
            color: white;
        }
    </style>
</head>
<body>

<h2>Inventario</h2>
<?php if (isset($update_msg)) { echo "<p>$update_msg</p>"; } ?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<table>
    <tr>
        <th>id</th>
        <th>medida inicial</th>
        <th>medida final</th>
        <th>valor residencial</th>
        <th>valor comercial</th>
        <th>valor industrial</th>
        <th>valor fundador</th>
        <th>Acciones</th>
    </tr>
    <?php
    $sql = "SELECT * FROM precio";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td><input type='hidden' name='id[]' value='" . $row["id"] . "'>" . $row["id"] . "</td>
                    <td><input type='text' name='medida_inicial[]' value='" . $row["medida_inicial"] . "'></td>
                    <td><input type='text' name='medida_final[]' value='" . $row["medida_final"] . "'></td>
                    <td><input type='text' name='valor_residencial[]' value='" . $row["valor_residencial"] . "'></td>
                    <td><input type='text' name='valor_comercial[]' value='" . $row["valor_comercial"] . "'></td>
                    <td><input type='text' name='valor_industrial[]' value='" . $row["valor_industrial"] . "'></td>
                    <td><input type='text' name='valor_fundador[]' value='" . $row["valor_fundador"] . "'></td>
                    <td>
                        <a href='precio.php?delete_id=" . $row["id"] . "' class='btn delete-btn' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\")'>Eliminar</a>
                        
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No hay registros en el inventario</td></tr>";
    }

    $conn->close();
    ?>
</table>
<br>
<input type="submit" value="Guardar Cambios" class="btn save-btn">
</form>
</body>
</html>
