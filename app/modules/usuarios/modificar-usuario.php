<?php
// modificar-usuario.php - Formulario para modificar clientes

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

$codigo = '';
$nombre = '';
$apellido = '';
$direccion = '';
$estrato = '';
$sector = '';
$uso = '';
$codigo_medidor = '';
$diametro_medidor = '';
$fundador = '';
$activo = " ";
$orden = " ";

$add_msg = isset($_GET['msg']) ? $_GET['msg'] : '';

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

if (isset($_GET['modificar_id'])) {
    $id = $_GET['modificar_id'];
    $sql = "SELECT * FROM clientes WHERE codigo = :codigo LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':codigo', $id, PDO::PARAM_STR);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($usuario) {
        $codigo = $usuario['codigo'];
        $nombre = $usuario['nombre'];
        $apellido = $usuario['apellido'];
        $direccion = $usuario['direccion'];
        $estrato = $usuario['estrato'];
        $sector = $usuario['sector'];
        $uso = $usuario['uso'];
        $codigo_medidor = $usuario['codigo_medidor'];
        $diametro_medidor = $usuario['diametro_medidor'];
        $fundador = $usuario['fundador'];
        $activo = $usuario['activo'];
        $orden = $usuario['orden'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario - Acueducto de Aranda</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo PUBLIC_URL; ?>/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_URL; ?>/css/modificar-usuario-styles.css">
    <link rel="shortcut icon" href="<?php echo PUBLIC_URL; ?>/img/logo.png" type="image/x-icon">
</head>
<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">Módulo Clientes</div>
            <div><a href="<?php echo PUBLIC_URL; ?>/index.php?page=dashboard"><i class="fa fa-home" aria-hidden="true" style="color:white; font-size: 30px"></i></a></div>
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
                <h2>Modificar Usuario</h2>
                <?php if ($add_msg): ?>
                    <p class="msg"><?php echo htmlspecialchars($add_msg); ?></p>
                <?php endif; ?>
                <div class="mensajes"></div>
                
                <form class="form-modificar" method="POST" action="<?php echo PUBLIC_URL; ?>/index.php?page=procesar_modificacion" onsubmit="return validarFormulario()">
                    <div class="form-row">
                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($nombre); ?>" maxlength="100">
                            <span class="error-message" id="error-nombre"></span>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido:</label>
                            <input type="text" id="apellido" name="apellido" required value="<?php echo htmlspecialchars($apellido); ?>" maxlength="100">
                            <span class="error-message" id="error-apellido"></span>
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección:</label>
                            <input type="text" id="direccion" name="direccion" required value="<?php echo htmlspecialchars($direccion); ?>" maxlength="100">
                            <span class="error-message" id="error-direccion"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="estrato">Estrato:</label>
                            <select id="estrato" name="estrato" required>
                                <option value="" disabled>Seleccione un estrato</option>
                                <option value="1" <?php echo $estrato == 1 ? 'selected' : ''; ?>>1</option>
                                <option value="2" <?php echo $estrato == 2 ? 'selected' : ''; ?>>2</option>
                                <option value="3" <?php echo $estrato == 3 ? 'selected' : ''; ?>>3</option>
                                <option value="4" <?php echo $estrato == 4 ? 'selected' : ''; ?>>4</option>
                                <option value="5" <?php echo $estrato == 5 ? 'selected' : ''; ?>>5</option>
                                <option value="6" <?php echo $estrato == 6 ? 'selected' : ''; ?>>6</option>
                                <option value="7" <?php echo $estrato == 7 ? 'selected' : ''; ?>>7</option>
                            </select>
                            <span class="error-message" id="error-estrato"></span>
                        </div>
                        <div class="form-group">
                            <label for="sector">Sector:</label>
                            <input type="text" id="sector" name="sector" required value="<?php echo htmlspecialchars($sector); ?>" maxlength="3">
                            <span class="error-message" id="error-sector"></span>
                        </div>
                        <div class="form-group">
                            <label for="uso">Uso:</label>
                            <select id="uso" name="uso" required>
                                <option value="" disabled>Seleccione un uso</option>
                                <option value="Residencial" <?php echo $uso === 'Residencial' ? 'selected' : ''; ?>>Residencial</option>
                                <option value="Comercial" <?php echo $uso === 'Comercial' ? 'selected' : ''; ?>>Comercial</option>
                                <option value="Industrial" <?php echo $uso === 'Industrial' ? 'selected' : ''; ?>>Industrial</option>
                            </select>
                            <span class="error-message" id="error-uso"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="codigo_medidor">Código del Medidor:</label>
                            <input type="text" id="codigo_medidor" name="codigo_medidor" required value="<?php echo htmlspecialchars($codigo_medidor); ?>" maxlength="50">
                            <span class="error-message" id="error-codigo-medidor"></span>
                        </div>
                        <div class="form-group">
                            <label for="diametro_medidor">Diámetro del Medidor:</label>
                            <input type="text" id="diametro_medidor" name="diametro_medidor" required value="<?php echo htmlspecialchars($diametro_medidor); ?>" maxlength="50">
                            <span class="error-message" id="error-diametro-medidor"></span>
                        </div>
                        <div class="form-group">
                            <label for="orden">Orden:</label>
                            <select id="orden" name="orden">
                                <option value="ninguna" selected>Ninguna</option>
                            </select>
                            <span class="error-message" id="error-orden"></span>
                        </div>
                        <div class="form-group checkbox-group center-row">
                            <label for="activo">Activo:</label>
                            <input type="checkbox" id="activo" name="activo" value="SI" <?php echo $activo === 'SI' ? 'checked' : ''; ?>>
                        </div>
                        <div class="form-group checkbox-group center-row">
                            <label for="fundador">Fundador:</label>
                            <input type="checkbox" id="fundador" name="fundador" value="SI" <?php echo $fundador === 'SI' ? 'checked' : ''; ?>>
                        </div>
                    </div>
                    <div class="btn-modificar">
                        <button type="submit">Modificar</button>
                    </div>
                </form>
                
                <div class="user-list">
                    <h2>Lista de Usuarios</h2>
                    <div class="filtro"> 
                        <form class="form-filtro" method="POST" action="<?php echo PUBLIC_URL; ?>/index.php?page=modificar_cliente">
                            <label>Filtrar Por: </label>
                            <input type="text" name="codigo" placeholder="Codigo" value="<?php echo htmlspecialchars($codigo); ?>">
                            <input type="text" name="nombre" placeholder="Nombre" value="<?php echo htmlspecialchars($nombre); ?>">
                            <input type="text" name="sector" placeholder="Sector" value="<?php echo htmlspecialchars($sector); ?>">
                            <button type="submit">Filtrar</button>
                        </form>
                    </div>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Orden</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Dirección</th>
                                <th>Sector</th>
                                <th>Fundador</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($result) > 0) {
                                foreach ($result as $row) {
                                    echo "<tr>
                                        <td> " . htmlspecialchars($row["codigo"]) . " </td>
                                        <td> " . htmlspecialchars($row["orden"]) . " </td>
                                        <td> " . htmlspecialchars($row["nombre"]) . " </td>
                                        <td> " . htmlspecialchars($row["apellido"]) . " </td>
                                        <td> " . htmlspecialchars($row["direccion"]) . " </td>
                                        <td> " . htmlspecialchars($row["sector"]) . " </td>
                                        <td> " . htmlspecialchars($row["fundador"]) . " </td>
                                        <td>
                                            <a href='" . PUBLIC_URL . "/index.php?page=modificar_cliente&modificar_id=" . $row["codigo"] . "' onclick='return confirm(\"¿Estás seguro de que deseas modificar este registro?\")'>
                                                <img class='img-modificar' src='" . PUBLIC_URL . "/img/editar.png' alt='Modificar'>
                                            </a>
                                          </td>
                                    </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <script>
        // Variables globales para JavaScript
        var PUBLIC_URL = '<?php echo PUBLIC_URL; ?>';
        var ordenActual = <?php echo isset($orden) && $orden !== " " ? json_encode($orden) : 'null'; ?>;
        var sectorOriginal = <?php echo json_encode($sector); ?>;
    </script>
    <script src="<?php echo PUBLIC_URL; ?>/js/modificar_usuario.js"></script>

</body>
</html>