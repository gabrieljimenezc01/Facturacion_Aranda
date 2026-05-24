<?php
// principal.php - Dashboard principal

// Cargar configuración central
if (!defined('BASE_PATH')) {
    require_once dirname(__DIR__, 3) . '/config/app.php';
}

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar que el usuario está autenticado
if (!isset($_SESSION['user'])) {
    header("Location: " . PUBLIC_URL . "/index.php?page=login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventana Principal - Acueducto de Aranda</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    
    <!-- CORREGIDO: Usar PUBLIC_URL -->
    <link rel="stylesheet" href="<?php echo PUBLIC_URL; ?>/css/principal-styles.css">
    <link rel="shortcut icon" href="<?php echo PUBLIC_URL; ?>/img/disponibilidad.png">
    <link rel="stylesheet" href="<?php echo PUBLIC_URL; ?>/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="shortcut icon" href="<?php echo PUBLIC_URL; ?>/img/logo.png" type="image/x-icon">
</head>

<body>
    <div class="background-overlay"></div>
    <div class="navbar">
        <div class="user-container">
            <!-- CORREGIDO: Usar PUBLIC_URL para todas las rutas -->
            <button class="user-btn" onclick="window.location.href='<?php echo PUBLIC_URL; ?>/index.php?page=clientes'">Clientes</button>
            <button class="user-btn" onclick="window.location.href='<?php echo PUBLIC_URL; ?>/index.php?page=deudores'">Deudas</button>
            <button class="user-btn" onclick="window.location.href='<?php echo PUBLIC_URL; ?>/index.php?page=facturacion'">Facturación</button>
            <button class="user-btn" onclick="window.location.href='<?php echo PUBLIC_URL; ?>/index.php?page=listados'">Listados</button>
            <button class="user-btn" onclick="window.location.href='<?php echo PUBLIC_URL; ?>/index.php?page=precios'">Precios</button>
            <button class="user-btn" onclick="window.location.href='<?php echo PUBLIC_URL; ?>/index.php?page=logout'">Cerrar Sesión</button>
        </div>
    </div>
    <div class="main-container">
        <div class="card-container">
            <h1>¡Bienvenido(a) al Sistema Integral de Gestión de Clientes y Facturación del Acueducto Aranda!</h1>
            <p class="welcome-message">
                Nos complace tenerle con nosotros para gestionar nuestras operaciones.
            </p>
            <h2>A continuación, encontrará las principales funcionalidades disponibles:</h2><br>
        </div><br>
        <div class="icons-container">
            <!-- CORREGIDO: Usar PUBLIC_URL en todos los enlaces -->
            <a href="<?php echo PUBLIC_URL; ?>/index.php?page=clientes" class="icon-card">
                <h2>Modulo Clientes</h2><br>
                <i class="fa fa-users fa-5x icon"></i>
            </a>
            <a href="<?php echo PUBLIC_URL; ?>/index.php?page=deudores" class="icon-card">
                <h2>Modulo Deudas</h2><br>
                <i class="fa fa-dollar fa-5x icon"></i>
            </a>
            <a href="<?php echo PUBLIC_URL; ?>/index.php?page=facturacion" class="icon-card">
                <h2>Facturación</h2><br>
                <i class="fa fa-file-pdf-o fa-5x icon"></i>
            </a>
            <a href="<?php echo PUBLIC_URL; ?>/index.php?page=listados" class="icon-card">
                <h2>Listados</h2><br>
                <i class="fa fa-newspaper-o fa-5x icon"></i>
            </a>
            <a href="<?php echo PUBLIC_URL; ?>/index.php?page=precios" class="icon-card">
                <h2>Precios</h2><br>
                <i class="fa fa-money fa-5x icon"></i>
            </a>
        </div>
    </div>
</body>

</html>