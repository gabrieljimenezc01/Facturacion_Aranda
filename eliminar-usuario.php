<?php
require 'db.php';

if (isset($_GET['delete_id'])) {
    try {
        $delete_id = $_GET['delete_id'];
        $sql = "DELETE FROM clientes WHERE codigo = :delete_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $delete_msg = "Registro eliminado con éxito";
        } else {
            $delete_msg = "Error al eliminar el registro";
        }
    } catch (PDOException $e) {
        $msgerro =  " <h2>No se puede eliminar: El cliente tiene deudas </h2>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
}

// Filtrado de clientes
$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$sector = isset($_POST['sector']) ? $_POST['sector'] : '';

$sql = "SELECT * FROM clientes WHERE (codigo LIKE :codigo) AND (nombre LIKE :nombre) AND (sector LIKE :sector)";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':codigo', "%$codigo%", PDO::PARAM_STR);
$stmt->bindValue(':nombre', "%$nombre%", PDO::PARAM_STR);
$stmt->bindValue(':sector', "%$sector%", PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="eliminar-usuario-styles.css">
</head>

<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">Sistema de Facturación</div>
            <div>
                <button class="logout-button">Cerrar Sesión</button>
            </div>
        </nav>
        <div class="content">
            <aside class="sidebar">
                <ul class="menu-list">
                    <li><a href="#"><i class="fa fa-user-plus" aria-hidden="true"></i><br> Agregar Usuario</a></li>
                    <li><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br> Modificar Datos Usuario</a></li>
                    <li><a href="eliminar-usuario.php"><i class="fa fa-user-times" aria-hidden="true"></i><br> Eliminar Usuario</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <?php if (isset($msgerro)) {
                    echo "<p>$msgerro</p>";
                } ?>
                <h2>Eliminar Usuario</h2>

                <div class="filtro">
                    <!-- Formulario de filtrado -->
                    <form method="POST" action="eliminar-usuario.php">
                        <label>Filtrar Por: </label>
                        <input type="text" id="codigo" name="codigo" placeholder="Codigo" value="<?php echo htmlspecialchars($codigo); ?>">
                        <input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo htmlspecialchars($nombre); ?>">
                        <input type="text" id="sector" name="sector" placeholder="Sector" value="<?php echo htmlspecialchars($sector); ?>">
                        <button type="submit">Filtrar</button>
                    </form>
                </div>
                <table>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Dirección</th>
                        <th>Sector</th>
                        <th>Fundador</th>
                        <th>Acciones</th>
                    </tr>
                    <?php
                    if (count($result) > 0) {
                        foreach ($result as $row) {
                            echo "<tr>
                            <td> " . $row["codigo"] . "</td>
                            <td> " . $row["nombre"] . "</td>
                            <td> " . $row["apellido"] . "</td>
                            <td> " . $row["direccion"] . "</td>
                            <td> " . $row["sector"] . "</td>
                            <td> " . $row["fundador"] . "</td>
                            <td>
                                <a href='eliminar-usuario.php?delete_id=" . $row["codigo"] . "'  onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\")'>
                                <img class='img-borrar' src='./img/borrar.png' alt='Eliminar'>
                                </a>
                            </td>
                          </tr>";
                        }
                    }
                    ?>
                </table>

            </main>
        </div>
    </div>
</body>

</html>