<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Deudas</title>
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="deudas-styles.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
</head>
<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">Modulo Deudas</div>
            <div><a href="principal.php"><i class="fa fa-home" aria-hidden="true" style="color:white; font-size: 30px"></i></a></div>
            <div>
                <button class="logout-button" onclick="cerrar()">Cerrar Sesión</button>
            </div>
        </nav>

        <div class="content">
            <aside class="sidebar">
                <ul class="menu-list">
                    <li><a href="deudores.php"><i class="fa fa-list" aria-hidden="true"></i><br>Lista Deudores</a></li>
                    <li><a href="busqueda.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br>Acuerdos de pago</a></li>
                    <li><a href="clientes_facturas.php"><i class="fa fa-user" aria-hidden="true"></i><br>Facturas de clientes</a></li>
                    <li><a href="registro_deudas.php"><i class="fa fa-plus-square-o" aria-hidden="true"></i><br>Registro de Deuda</a></li>
                </ul>
            </aside>
            <main class="main-content">
            </main>
        </div>
    </div>
</body>
</html>