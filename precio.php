<?php
require 'db.php';
// Manejar eliminación de registros
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM precio WHERE id = :delete_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $delete_msg  = "Registro eliminado con éxito";
    } else {
        $delete_msg = "Error al eliminar el registro";
    }
}
// Manejar actualización de registros
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    foreach ($_POST['id'] as $key => $id) {
        $medida_inicial = $_POST['medida_inicial'][$key];
        $medida_final = $_POST['medida_final'][$key];
        $valor_residencial = $_POST['valor_residencial'][$key];
        $valor_comercial = $_POST['valor_comercial'][$key];
        $valor_industrial = $_POST['valor_industrial'][$key];
        $valor_fundador = $_POST['valor_fundador'][$key];

        $sql = "UPDATE precio SET medida_inicial = :medida_inicial, medida_final = :medida_final, valor_residencial = :valor_residencial, valor_comercial = :valor_comercial, valor_industrial = :valor_industrial, valor_fundador = :valor_fundador WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':medida_inicial', $medida_inicial, PDO::PARAM_INT);
        $stmt->bindParam(':medida_final', $medida_final, PDO::PARAM_INT);
        $stmt->bindParam(':valor_residencial', $valor_residencial, PDO::PARAM_INT);
        $stmt->bindParam(':valor_comercial', $valor_comercial, PDO::PARAM_INT);
        $stmt->bindParam(':valor_industrial', $valor_industrial, PDO::PARAM_INT);
        $stmt->bindParam(':valor_fundador', $valor_fundador, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $update_msg = "Registros actualizados con éxito";
        } else {
            $update_msg = "Error al actualizar los registros";
        }
    }
}

// Manejar inserción de nuevos registros
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $medida_inicial = $_POST['new_medida_inicial'];
    $medida_final = $_POST['new_medida_final'];
    $valor_residencial = $_POST['new_valor_residencial'];
    $valor_comercial = $_POST['new_valor_comercial'];
    $valor_industrial = $_POST['new_valor_industrial'];
    $valor_fundador = $_POST['new_valor_fundador'];

    $sql = "INSERT INTO precio (medida_inicial, medida_final, valor_residencial, valor_comercial, valor_industrial, valor_fundador) VALUES (:medida_inicial, :medida_final, :valor_residencial, :valor_comercial, :valor_industrial, :valor_fundador)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':medida_inicial', $medida_inicial, PDO::PARAM_INT);
    $stmt->bindParam(':medida_final', $medida_final, PDO::PARAM_INT);
    $stmt->bindParam(':valor_residencial', $valor_residencial, PDO::PARAM_INT);
    $stmt->bindParam(':valor_comercial', $valor_comercial, PDO::PARAM_INT);
    $stmt->bindParam(':valor_industrial', $valor_industrial, PDO::PARAM_INT);
    $stmt->bindParam(':valor_fundador', $valor_fundador, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $add_msg = "Nuevo registro agregado con éxito";
    } else {
        $add_msg = "Error al agregar el registro";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Precios</title>
    <link rel="stylesheet" href="precio-styles.css">
</head>

<body>
    <div class="navbar">
        <div class="user-container">
            <button class="user-btn" onclick="window.location.href='principal.html'">Opciones</button>
            <button class="user-btn" onclick="window.location.href='principal.html'">Opciones</button>
            <button class="user-btn" onclick="window.location.href='avanzar.html'">Opciones</button>
            <button class="user-btn" onclick="window.location.href='login.html'">Cerrar Sesión</button>
        </div>
    </div>
    <div class="container">


        <h2>Manejo de Precios</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Medida Inicial</th>
                    <th>Medida Final</th>
                    <th>Valor Residencial</th>
                    <th>Valor Comercial</th>
                    <th>Valor Industrial</th>
                    <th>Valor Fundador</th>
                    <th>Acciones</th>
                </tr>
                <?php
                $sql = "SELECT * FROM precio";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($result) > 0) {
                    foreach ($result as $row) {
                        echo "<tr>
                    <td><input type='hidden' name='id[]' value='" . $row["id"] . "'>" . "</td>
                    <td><input type='number' name='medida_inicial[]' value='" . $row["medida_inicial"] . "'></td>
                    <td><input type='number' name='medida_final[]' value='" . $row["medida_final"] . "'></td>
                    <td><input type='number' name='valor_residencial[]' value='" . $row["valor_residencial"] . "'></td>
                    <td><input type='number' name='valor_comercial[]' value='" . $row["valor_comercial"] . "'></td>
                    <td><input type='number' name='valor_industrial[]' value='" . $row["valor_industrial"] . "'></td>
                    <td><input type='number' name='valor_fundador[]' value='" . $row["valor_fundador"] . "'></td>
                    <td>
                        <a href='precio.php?delete_id=" . $row["id"] . "' class='btn delete-btn' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\")'>Eliminar</a>
                    </td>
                  </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay registros en el inventario</td></tr>";
                }

                $conn = null;
                ?>
            </table>
            <br>
            <button type="submit" name="update" value="Guardar Cambios" class="btn save-btn">Guardar Cambios </button>
        </form>
        <?php if (isset($update_msg)) {
            echo "<p>$update_msg</p>";
        } ?>
        <?php if (isset($delete_msg)) {
            echo "<p>$delete_msg</p>";
        } ?>
        <div class="div_agregar">
        <h2>Agregar Nuevo Registro</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="add-form">
            <input class="inp-form" type="number" name="new_medida_inicial" placeholder="Medida Inicial" required>
            <input class="inp-form" type="number" name="new_medida_final" placeholder="Medida Final" required> 
            <input class="inp-form" type="number" name="new_valor_residencial" placeholder="Valor Residencial" required>
            <input class="inp-form" type="number" name="new_valor_comercial" placeholder="Valor Comercial" required>
            <input class="inp-form" type="number" name="new_valor_industrial" placeholder="Valor Industrial" required>
            <input class="inp-form" type="number" name="new_valor_fundador" placeholder="Valor Fundador" required> <Br></Br>
            <button type="submit" name="add" class="btn save-btn">Agregar Registro</button>
        </form>
        <?php if (isset($add_msg)) {
            echo "<p>$add_msg</p>";
        } ?>
        </div>
    </div>
</body>

</html>