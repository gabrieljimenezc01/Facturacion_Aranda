<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
};
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventana Principal</title>
    <link rel="stylesheet" href="../../../public/css/principal-styles.css">
    <link rel="shortcut icon" href="../../../public/img/disponibilidad.png">
    <link rel="stylesheet" href="../../../public/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="shortcut icon" href="../../../public/img/logo.png" type="image/x-icon">
</head>

<body>
    <div class="background-overlay"></div>
    <div class="navbar">
        <div class="user-container">
            <button class="user-btn" onclick="window.location.href='agregar-usuario.php'">Clientes</button>
            <button class="user-btn" onclick="window.location.href='deudores.php'">Deudas</button>
            <button class="user-btn" onclick="window.location.href='facturacion.php'">Facturación</button>
            <button class="user-btn" onclick="window.location.href='listados.php'">Listados</button>
            <button class="user-btn" onclick="window.location.href='precio.php'">Precios</button>
            <button class="user-btn" onclick="window.location.href='../auth/logout.php'">Cerrar Sesión</button>
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
            <a href="agregar-usuario.php" class="icon-card">
                <h2>Modulo Clientes</h2><br>
                <i class="fa fa-users fa-5x icon"></i>
            </a>
            <a href="deudores.php" class="icon-card">
                <h2>Modulo Deudas</h2><br>
                <i class="fa fa-dollar fa-5x icon"></i>
            </a>
            <a href="facturacion.php" class="icon-card">
                <h2>Facturación</h2><br>
                <i class="fa fa-file-pdf-o fa-5x icon"></i>
            </a>
            <a href="listados.php" class="icon-card">
                <h2>Listados</h2><br>
                <i class="fa fa-newspaper-o fa-5x icon"></i>
            </a>
            <a href="precio.php" class="icon-card">
                <h2>Precios</h2><br>
                <i class="fa fa-money fa-5x icon"></i>
            </a>
        </div>
    </div>
    </div>
</body>

</html>