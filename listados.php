<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Listas</title>
    <link rel="stylesheet" href="listados-styles.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">
</head>

<body>
    <div class="background-overlay"></div>
    <nav class="navbar">
        <div class="navbar-brand">Listados</div>
        <div><a href="principal.php"><i class="fa fa-home" aria-hidden="true"
                    style="color:white; font-size: 30px"></i></a></div>
        <div>
            <button class="logout-button" onclick="cerrar()" style="width: 100%;">Cerrar Sesión</button>
        </div>
    </nav>
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
                        <input type="number" id="sector" name="sector" onchange="handleDateChange()"
                            placeholder="Seleccione un sector" min="1">
                    </div>
                    <div class="form-group">
                        <label for="mes">Mes</label>
                        <select id="mes" name="mes" onchange="handleDateChange()">
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
                        <input type="number" id="año" name="año" onchange="handleDateChange()"
                            placeholder="Seleccione un año" min="2000">
                    </div>
                    <button type="button" class="btn" id="show-info-btn" style="display: none;"
                        onclick="fetchData()">Mostrar Información</button>
                </div>
                <div class="form-right">
                    <img src="img/agua.gif" alt="GIF Animado" class="form-gif">
                </div>
            </div>
            <div id="data-table" style="display: none; margin-top: 20px;">
                <!-- Aquí se mostrará la información de la base de datos -->
            </div><br>
            <button type="button" class="btn" style="display: none;" id="save-btn" onclick="saveChanges()">Guardar
                Cambios</button>
            <span id="save-confirmation" style="display: none; color: green;">Cambios guardados correctamente.</span>
            <button type="submit" class="btn" style="display: none;" id="generate-btn">Generar PDF</button>
        </form>
    </div>
    <script>
        function cerrar() {
            setTimeout(function () {
                window.location = "<?= 'logout.php' ?>";
            }, 0);
        }

        function updateFormAction() {
            var listType = document.getElementById("list-type").value;
            var form = document.getElementById("pdfForm");
            var generateBtn = document.getElementById("generate-btn");
            var showInfoBtn = document.getElementById("show-info-btn");
            var saveBtn = document.getElementById("save-btn");
            var dataTable = document.getElementById("data-table");

            if (listType === "secretario") {
                form.setAttribute("action", "generate_secretario.php");
                showInfoBtn.style.display = "inline-block";
                saveBtn.style.display = "inline-block";
                generateBtn.style.display = "inline-block";
            } else if (listType === "tesorero") {
                form.setAttribute("action", "generate_tesorero.php");
                showInfoBtn.style.display = "none";
                saveBtn.style.display = "none";
                generateBtn.style.display = "inline-block";
            } else {
                form.removeAttribute("action");
                showInfoBtn.style.display = "none";
                saveBtn.style.display = "none";
                generateBtn.style.display = "none";
            }

            document.getElementById("form-details").style.display = listType ? "flex" : "none";
            checkSavedState();
        }

        function fetchData() {
            var sector = document.getElementById("sector").value;
            var mes = document.getElementById("mes").value;
            var año = document.getElementById("año").value;

            if (!sector || !mes || !año) {
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "fetch_data.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("data-table").style.display = "block";
                    document.getElementById("data-table").innerHTML = xhr.responseText;
                    checkSavedState(); // Verifica si el estado ya está guardado después de mostrar los datos
                }
            };
            xhr.send("sector=" + sector + "&mes=" + mes + "&año=" + año);
        }

        function saveChanges() {
            var form = document.getElementById('pdfForm');
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_deudores.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        if (xhr.responseText.trim() === "success") {
                            document.getElementById("save-confirmation").style.display = "inline-block";
                            document.getElementById("save-btn").style.display = "none"; // Deshabilita el botón después de guardar
                            checkSavedState(); // Revisa el estado después de guardar
                        } else {
                            alert("Error al actualizar los deudores: " + xhr.responseText);
                        }
                    } else {
                        alert("Error al comunicarse con el servidor: " + xhr.status);
                    }
                }
            };
            xhr.send(formData);
        }


        function resetSaveButton() {
            var listType = document.getElementById("list-type").value;
            if (listType === "secretario") {
                checkSavedState();
            }
            document.getElementById("save-confirmation").style.display = "none";
        }

        function saveState() {
            var sector = document.getElementById("sector").value;
            var mes = document.getElementById("mes").value;
            var año = document.getElementById("año").value;
            var savedStates = JSON.parse(localStorage.getItem('savedStates')) || [];
            var currentState = sector + '_' + mes + '_' + año;

            if (!savedStates.includes(currentState)) {
                savedStates.push(currentState);
                localStorage.setItem('savedStates', JSON.stringify(savedStates));
            }
        }

        function checkSavedState() {
            var listType = document.getElementById("list-type").value;
            var sector = document.getElementById("sector").value;
            var mes = document.getElementById("mes").value;
            var año = document.getElementById("año").value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "check_saved_state.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText === "saved") {
                        if (listType === "secretario") {
                            document.getElementById("save-btn").style.display = "none";
                            document.getElementById("save-confirmation").style.display = "inline-block";
                        } else {
                            // En Lista para Tesorero no mostramos el mensaje
                            document.getElementById("save-confirmation").style.display = "none";
                        }
                    } else {
                        document.getElementById("save-btn").style.display = listType === "secretario" ? "inline-block" : "none";
                        document.getElementById("save-confirmation").style.display = "none";
                    }
                }
            };
            xhr.send("sector=" + sector + "&mes=" + mes + "&año=" + año);
        }

        function handleSectorChange() {
            resetSaveButton();
            checkSavedState();
        }

        function handleDateChange() {
            resetSaveButton();
            checkSavedState();
        }

        document.getElementById('generate-btn').addEventListener('click', function () {
            // Asegura que no se muestre el mensaje de "Cambios guardados correctamente" al generar el PDF
            document.getElementById("save-confirmation").style.display = "none";
        });
    </script>
</body>

</html>