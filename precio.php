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

        // Validar que la medida inicial no esté en un rango existente para otros registros
        $sql = "SELECT COUNT(*) FROM precio WHERE :medida_inicial BETWEEN medida_inicial AND medida_final AND id != :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':medida_inicial', $medida_inicial, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            $update_msg2 = "Error: La medida inicial está dentro de un rango existente.";
        } else {
            // Validar que la medida final no esté en un rango existente para otros registros
            $sql = "SELECT COUNT(*) FROM precio WHERE :medida_final BETWEEN medida_inicial AND medida_final AND id != :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':medida_final', $medida_final, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                $update_msg2 = "Error: La medida final está dentro de un rango existente.";
            } else {
                if ($medida_final < $medida_inicial) {
                    //validar que la medida final no sea menor que la medida inicial
                    $update_msg2 = "Error: La medida final es menor que la medida inicial.";
                } else {
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
                        $update_msg = "Registros actualizados con éxito.";
                    } else {
                        $update_msg = "Error al actualizar los registros.";
                    }
                }
            }
        }
    }
}

// Manejar inserción de nuevos registros
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $new_medida_inicial = $_POST['new_medida_inicial'];
    $new_medida_final = $_POST['new_medida_final'];
    $new_valor_residencial = $_POST['new_valor_residencial'];
    $new_valor_comercial = $_POST['new_valor_comercial'];
    $new_valor_industrial = $_POST['new_valor_industrial'];
    $new_valor_fundador = $_POST['new_valor_fundador'];

    // Validar que la medida inicial no coincida con ninguna medida final existente
    $sql = "SELECT COUNT(*) FROM precio WHERE medida_final = :new_medida_inicial";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':new_medida_inicial', $new_medida_inicial, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        $add_msg = "Error: La medida final coincide con una medida inicial existente.";
    } else {
        //validar que la medida final no sea menor que la medida inicial
        if ($new_medida_final < $new_medida_inicial) {
            $add_msg = "Error: La medida final es menor que la medida inicial";
        } else {
            //validar que la medida inicial no este en un rango existente
            $sql = "SELECT COUNT(*) FROM precio WHERE :new_medida_inicial BETWEEN medida_inicial AND medida_final";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':new_medida_inicial', $new_medida_inicial, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                $add_msg = "Error: La medida inicial está dentro de un YA rango existente.";
            } else {
                // Validar que la medida final no esté en un rango existente
                $sql = "SELECT COUNT(*) FROM precio WHERE :new_medida_final BETWEEN medida_inicial AND medida_final";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':new_medida_final', $new_medida_final, PDO::PARAM_INT);
                $stmt->execute();
                $count = $stmt->fetchColumn();
                if ($count > 0) {
                    $add_msg = "Error: La medida final está dentro de un rango existente.";
                } else {
                    $sql = "INSERT INTO precio (medida_inicial, medida_final, valor_residencial, valor_comercial, valor_industrial, valor_fundador) VALUES (:medida_inicial, :medida_final, :valor_residencial, :valor_comercial, :valor_industrial, :valor_fundador)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':medida_inicial', $new_medida_inicial, PDO::PARAM_INT);
                    $stmt->bindParam(':medida_final', $new_medida_final, PDO::PARAM_INT);
                    $stmt->bindParam(':valor_residencial', $new_valor_residencial, PDO::PARAM_INT);
                    $stmt->bindParam(':valor_comercial', $new_valor_comercial, PDO::PARAM_INT);
                    $stmt->bindParam(':valor_industrial', $new_valor_industrial, PDO::PARAM_INT);
                    $stmt->bindParam(':valor_fundador', $new_valor_fundador, PDO::PARAM_INT);
                    if ($stmt->execute()) {
                        $add_msg = "Registro agregado con éxito";
                    } else {
                        $add_msg = "Error al agregar el registro";
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Precios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="precio-styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">Modulo Precios</div>
        <div><a href="principal.php"><i class="fa fa-home" aria-hidden="true"></i></a></div>
        <div>
            <button class="logout-button">Cerrar Sesión</button>
        </div>
    </nav>
    <div class="container">
        <div>
            <h2>Manejo de Precios</h2>
        </div>
        <div>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="table_information">
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
                                            <a href='precio.php?delete_id=" . $row["id"] . "'  onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\")'>
                                            <img class='img-borrar' src='./img/borrar.png' alt='Eliminar'>
                                            </a>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No hay registros en el inventario</td></tr>";
                        }

                        $conn = null;
                        ?>
                    </table>
                </div>
                <br>
                <button type="submit" name="update" value="Guardar Cambios" class="btn save-btn">Guardar Cambios </button>
            </form>
        </div>
        <?php if (isset($update_msg2)) {
            echo "<p>$update_msg2</p>";
        } ?>
        <?php if (isset($update_msg)) {
            echo "<p>$update_msg</p>";
        } ?>
        <?php if (isset($delete_msg)) {
            echo "<p>$delete_msg</p>";
        } ?>
        <div class="div_agregar">
            <h2>Agregar Nuevo Registro</h2>
            <div class="datosregistronuevo">
                <form method="post" class="formdatos" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="add-form">
                    <div class="form-row">
                        <input type="number" required name="new_medida_inicial" min="0">
                        <label alt="Label" data-placeholder="Medida Inicial"></label>
                    </div>
                    <div class="form-row">
                        <input type="number" required name="new_medida_final" min="0">
                        <label alt="Label" data-placeholder="Medida Final"></label>
                    </div>
                    <div class="form-row">
                        <input type="number" required name="new_valor_residencial" min="0">
                        <label alt="Label" data-placeholder="Valor Residencial"></label>
                    </div>
                    <div class="form-row">
                        <input type="number" required name="new_valor_comercial" min="0">
                        <label alt="Label" data-placeholder="Valor Comercial"></label>
                    </div>
                    <div class="form-row">
                        <input type="number" required name="new_valor_industrial" min="0">
                        <label alt="Label" data-placeholder="Valor Industrial"></label>
                    </div>
                    <div class="form-row">
                        <input type="number" required name="new_valor_fundador" min="0">
                        <label alt="Label" data-placeholder="Valor Fundador"></label>
                    </div>
                    <div class="form-row">
                        <button type="submit" name="add" class="btn save-btn">Agregar Registro</button>
                    </div>
                </form>
            </div>
            <?php if (isset($add_msg)) {
                echo "<p>$add_msg</p>";
            } ?>
        </div>
    </div>
</body>

</html>