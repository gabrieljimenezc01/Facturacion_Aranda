<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Listas</title>
    <link rel="stylesheet" href="listados-styles.css">
    <link rel="shortcut icon" href="../img/disponibilidad.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="background-overlay"></div>
    <div class="navbar">
        <div class="user-container">
            <button class="user-btn" onclick="window.location.href='principal.html'">Usuarios</button>
            <button class="user-btn" onclick="window.location.href='principal.html'">Busqueda</button>
            <button class="user-btn" onclick="window.location.href='avanzar.html'">Facturación</button>
            <button class="user-btn" onclick="window.location.href='avanzar.html'">Listados</button>
            <button class="user-btn" onclick="window.location.href='avanzar.html'">Precios</button>
            <button class="user-btn" onclick="window.location.href='login.html'">Cerrar Sesión</button>
        </div>
    </div>
    <div class="container">
        <h1>Generador de Listas</h1>
        <form id="pdfForm" method="POST" target="_blank">
            <div class="form-group">
                <label for="list-type">Tipo de Lista</label>
                <select id="list-type" name="list_type" onchange="updateFormAction()">
                    <option value="">Seleccione una opción</option>
                    <option value="tesorero">Lista para Tesorero</option>
                    <option value="secretario">Lista para Secretario</option>
                </select>
            </div>
            <div id="form-details" class="form-container" style="display: none;">
                <div class="form-left">
                <div class="form-group">
                        <label for="sector">Sector</label>
                        <select id="sector" name="sector">
                            <option value="">Seleccione un sector</option>
                            <?php for ($i = 1; $i <= 17; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mes">Mes</label>
                        <select id="mes" name="mes">
                            <option value="">Seleccione un mes</option>
                            <option value="enero">Enero</option>
                            <option value="febrero">Febrero</option>
                            <option value="marzo">Marzo</option>
                            <option value="abril">Abril</option>
                            <option value="mayo">Mayo</option>
                            <option value="junio">Junio</option>
                            <option value="julio">Julio</option>
                            <option value="agosto">Agosto</option>
                            <option value="septiembre">Septiembre</option>
                            <option value="octubre">Octubre</option>
                            <option value="noviembre">Noviembre</option>
                            <option value="diciembre">Diciembre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="año">Año</label>
                        <input type="text" id="año" name="año">
                    </div>
                    <button type="submit" class="btn">Generar PDF</button>
                </div>
                <div class="form-right">
                    <img src="img/agua.gif" alt="GIF Animado" class="form-gif"> <!-- Ruta local al GIF -->
                </div>
            </div>
        </form>
    </div>
    <script>
        function showForm() {
            var listType = document.getElementById("list-type").value;
            var formDetails = document.getElementById("form-details");
            if (listType) {
                formDetails.style.display = "flex";
            } else {
                formDetails.style.display = "none";
            }
        }

        function updateFormAction() {
            var listType = document.getElementById("list-type").value;
            var form = document.getElementById("pdfForm");
            if (listType === "tesorero") {
                form.action = "generate_tesorero.php";
            } else if (listType === "secretario") {
                form.action = "generate_secretario.php";
            } else {
                form.action = "";
            }
            showForm();
        }
    </script>
</body>
</html>
