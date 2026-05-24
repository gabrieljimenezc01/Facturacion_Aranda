<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: http://localhost/facturacion_aranda/public/index.php?page=auth/login.php");
        exit();
    };
    $add_msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost/facturacion_aranda/http://localhost/facturacion_aranda/public/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://localhost/facturacion_aranda/http://localhost/facturacion_aranda/public/css/agregar-usuario-styles.css">
    <link rel="shortcut icon" href="http://localhost/facturacion_aranda/http://localhost/facturacion_aranda/public/img/logo.png" type="image/x-icon">
</head>
<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">Módulo Clientes</div>
            <div><a href="../reportes/principal.php"><i class="fa fa-home" aria-hidden="true" style="color:white; font-size: 30px"></i></a></div>
            <div>
                <button class="logout-button" onclick="cerrar()">Cerrar Sesión</button>
            </div>
        </nav>
        <div class="content">
            <aside class="sidebar">
                <ul class="menu-list">
                    <li><a href="agregar-usuario.php"><i class="fa fa-user-plus" aria-hidden="true"></i><br> Agregar Usuario</a></li>
                    <li><a href="modificar-usuario.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br> Modificar Datos Usuario</a></li>
                    <li><a href="eliminar-usuario.php"><i class="fa fa-user-times" aria-hidden="true"></i><br> Eliminar Usuario</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <h2>Agregar Usuario</h2>
                <?php if ($add_msg): ?>
                    <p class="msg"><?php echo htmlspecialchars($add_msg); ?></p>
                <?php endif; ?>
                <div class="mensajes"></div>
                <form method="POST" action="procesar_registro.php" onsubmit="return validarFormulario()">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" required maxlength="100">
                            <span class="error-message" id="error-nombre"></span>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido:</label>
                            <input type="text" id="apellido" name="apellido" required maxlength="100">
                            <span class="error-message" id="error-apellido"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="direccion">Dirección:</label>
                            <input type="text" id="direccion" name="direccion" required maxlength="100">
                            <span class="error-message" id="error-direccion"></span>
                        </div>
                        <div class="form-group">
                            <label for="estrato">Estrato:</label>
                            <select id="estrato" name="estrato" required>
                                <option value="" disabled selected>Seleccione un estrato</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                            </select>
                            <span class="error-message" id="error-estrato"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="sector">Sector:</label>
                            <input type="text" id="sector" name="sector" required maxlength="3">
                            <span class="error-message" id="error-sector"></span>
                        </div>
                        <div class="form-group">
                            <label for="uso">Uso:</label>
                            <select id="uso" name="uso" required>
                                <option value="" disabled selected>Seleccione un uso</option>
                                <option value="Residencial">Residencial</option>
                                <option value="Comercial">Comercial</option>
                                <option value="Industrial">Industrial</option>
                            </select>
                            <span class="error-message" id="error-uso"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="codigo_medidor">Código del Medidor:</label>
                            <input type="text" id="codigo_medidor" name="codigo_medidor" required maxlength="50">
                            <span class="error-message" id="error-codigo-medidor"></span>
                        </div>
                        <div class="form-group">
                            <label for="diametro_medidor">Diámetro del Medidor:</label>
                            <input type="text" id="diametro_medidor" name="diametro_medidor" required maxlength="50">
                            <span class="error-message" id="error-diametro-medidor"></span>
                        </div>
                        <div class="form-group">
                            <label for="diametro_medidor">Orden:</label>
                            <select id="orden" name="orden">
                                <option value="ninguna" selected>Ninguna</option>
                            </select>
                            <span class="error-message" id="error-diametro-medidor"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group checkbox-group center-row">
                            <label for="fundador">Fundador:</label>
                            <input type="checkbox" id="fundador" name="fundador">
                        </div>
                    </div>
                    <button type="submit">Agregar</button>
                </form>
            </main>
        </div>
    </div>
</body>
<script src="http://localhost/facturacion_aranda/http://localhost/facturacion_aranda/public/js/agregar-usuario.js"></script>
</html>
