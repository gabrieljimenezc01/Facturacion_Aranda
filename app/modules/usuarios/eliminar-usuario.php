<?php
// eliminar-usuario.php - Eliminar clientes

// Cargar configuración central
if (!defined('BASE_PATH')) {
    require_once dirname(__DIR__, 3) . '/config/app.php';
}

// Verificar autenticación
require_once APP_PATH . '/middleware/AuthMiddleware.php';
checkAuth();

// Asegurar conexión a base de datos
if (!isset($conn)) {
    require_once APP_PATH . '/config/database.php';
}

$msgerro = '';
$mensaje = isset($_GET['msg']) ? $_GET['msg'] : '';

if (isset($_GET['delete_id'])) {
    try {
        $delete_id = $_GET['delete_id'];

        // Obtener el orden del usuario a eliminar
        $sql_orden = "SELECT orden FROM clientes WHERE codigo = :codigo";
        $stmt_orden = $conn->prepare($sql_orden);
        $stmt_orden->bindParam(':codigo', $delete_id, PDO::PARAM_INT);
        $stmt_orden->execute();
        $orden_eliminado = (int)$stmt_orden->fetchColumn();

        // Eliminar el usuario
        $sql = "DELETE FROM clientes WHERE codigo = :delete_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $sql_shift = "UPDATE clientes SET orden = orden - 1 WHERE orden > :orden_eliminado";
            $stmt_shift = $conn->prepare($sql_shift);
            $stmt_shift->bindValue(':orden_eliminado', $orden_eliminado, PDO::PARAM_INT);
            $stmt_shift->execute();

            // ✅ CORREGIDO: Redirigir al front controller
            header("Location: " . PUBLIC_URL . "/index.php?page=eliminar_cliente&msg=" . urlencode("Registro eliminado con éxito"));
            exit();
        } else {
            // ✅ CORREGIDO: Redirigir con mensaje de error
            header("Location: " . PUBLIC_URL . "/index.php?page=eliminar_cliente&msg=" . urlencode("Error al eliminar el registro"));
            exit();
        }
    } catch (PDOException $e) {
        $msgerro = "No se puede eliminar: El cliente tiene deudas";
        // ✅ CORREGIDO: Redirigir con mensaje de error
        header("Location: " . PUBLIC_URL . "/index.php?page=eliminar_cliente&msg=" . urlencode($msgerro));
        exit();
    }
}

// Filtrado de clientes
$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$sector = isset($_POST['sector']) ? $_POST['sector'] : '';

$sql = "SELECT * FROM clientes WHERE (codigo LIKE :codigo) AND (nombre LIKE :nombre) AND (sector LIKE :sector) ORDER BY orden ASC";
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
    <link rel="stylesheet" href="<?php echo PUBLIC_URL; ?>/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_URL; ?>/css/deudas-styles.css">
    <link rel="shortcut icon" href="<?php echo PUBLIC_URL; ?>/img/logo.png" type="image/x-icon">
</head>

<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">Módulo Clientes</div>
            <div><a href="principal.php"><i class="fa fa-home" aria-hidden="true" style="color:white; font-size: 30px"></i></a></div>
            <div>
                <button class="logout-button" onclick="cerrar()">Cerrar Sesión</button>
            </div>
        </nav>
        <div class="content">
            <aside class="sidebar">
                <ul class="menu-list">
                     <li><a href="<?php echo PUBLIC_URL; ?>/index.php?page=agregar_cliente"><i class="fa fa-user-plus" aria-hidden="true"></i><br> Agregar Usuario</a></li>
                    <li><a href="<?php echo PUBLIC_URL; ?>/index.php?page=modificar_cliente"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br> Modificar Datos Usuario</a></li>
                    <li><a href="<?php echo PUBLIC_URL; ?>/index.php?page=eliminar_cliente"><i class="fa fa-user-times" aria-hidden="true"></i><br> Eliminar Usuario</a></li>
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
                        <div class="form-row">
                        <input type="number" name="codigo"  value='<?php echo $codigo?>' min="1">
                        <label alt="Label" data-placeholder="Código de usuario"></label>
                        </div>

                        <div class="form-row">
                        <input type="text" id="nombre" name="nombre"  value='<?php echo $nombre?>' >
                        <label alt="Label" data-placeholder="Nombre"></label>
                        </div>

                        <div class="form-row">
                        <input type="number" name="sector"  value='<?php echo $sector?>' min="1">
                        <label alt="Label" data-placeholder="Sector"></label>
                        </div>   

                        <div class="form-row">
                        <button type="submit">Filtrar</button>
                        </div>
                    </form>
                </div>
                <table>
                    <tr>
                        <th>Código</th>
                        <th>Orden</th>
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
                            <td> " . $row["orden"] . "</td>
                            <td> " . $row["nombre"] . "</td>
                            <td> " . $row["apellido"] . "</td>
                            <td> " . $row["direccion"] . "</td>
                            <td> " . $row["sector"] . "</td>
                            <td> " . $row["fundador"] . "</td>
                            <td>
                                <a href='" . PUBLIC_URL . "/index.php?page=eliminar_cliente&delete_id=" . $row["codigo"] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\");'>
                                    <img class='img-borrar' src='" . PUBLIC_URL . "/img/borrar.png' alt='Eliminar'>
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
<script>
    var PUBLIC_URL = '<?php echo PUBLIC_URL; ?>';
    function cerrar() {    
        window.location.href = PUBLIC_URL + '/index.php?page=logout';
    }
</script>
</html>