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
                    <button type="button" class="btn" id="show-info-btn" style="display: none;" onclick="fetchData()">Mostrar Información</button>
                </div>
                <div class="form-right">
                    <img src="img/agua.gif" alt="GIF Animado" class="form-gif">
                </div>
            </div>
            <div id="data-table" style="display: none; margin-top: 20px;">
                <!-- Aquí se mostrará la información de la base de datos -->
            </div><br>
            <button type="submit" class="btn" style="display: none;" id="generate-btn">Generar PDF</button>
        </form>
    </div>
    <script>
        function updateFormAction() {
            var listType = document.getElementById("list-type").value;
            var form = document.getElementById("pdfForm");
            var generateBtn = document.getElementById("generate-btn");
            var showInfoBtn = document.getElementById("show-info-btn");
            var dataTable = document.getElementById("data-table");

            if (listType === "secretario") {
                form.action = "generate_secretario.php";
                showInfoBtn.style.display = "inline-block"; // Mostrar el botón de "Mostrar Información"
                dataTable.style.display = "none"; // Ocultar la tabla de datos inicialmente
            } else if (listType === "tesorero") {
                form.action = "generate_tesorero.php";
                showInfoBtn.style.display = "none"; // Ocultar el botón de "Mostrar Información"
                dataTable.style.display = "none"; // Ocultar la tabla de datos
                generateBtn.style.display = "inline-block"; // Mostrar el botón de "Generar PDF"
            } else {
                form.action = "";
                showInfoBtn.style.display = "none"; // Ocultar el botón de "Mostrar Información"
                dataTable.style.display = "none"; // Ocultar la tabla de datos
                generateBtn.style.display = "none"; // Ocultar el botón de "Generar PDF"
            }

            document.getElementById("form-details").style.display = listType ? "flex" : "none";
        }

        function fetchData() {
            var sector = document.getElementById("sector").value;
            var mes = document.getElementById("mes").value;
            var año = document.getElementById("año").value;

            if (!sector || !mes || !año) {
                alert("Por favor complete todos los campos.");
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "fetch_data.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("data-table").style.display = "block";
                    document.getElementById("data-table").innerHTML = xhr.responseText;
                    document.getElementById("generate-btn").style.display = "inline-block";
                }
            };
            xhr.send("sector=" + sector + "&mes=" + mes + "&año=" + año);
        }
    </script>
</body>
</html>
