<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
};

// Definir variables con valores predeterminados
$f_inicio = "";
$f_fin = "";
$f_cobro = "";
$f_cobro_2 = "";
$mes = "";
$sector = "";

// Procesar los datos del formulario cuando se envían
if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin']) && isset($_POST['fecha_cobro']) && isset($_POST['fecha_cobro_2']) && isset($_POST['mes_facturado'])) {
    $f_inicio = $_POST['fecha_inicio'];
    $f_fin = $_POST['fecha_fin'];
    $f_cobro = $_POST['fecha_cobro'];
    $f_cobro_2 = $_POST['fecha_cobro_2'];

    // Alternativa sin IntlDateFormatter: Array de meses en español
    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];
    $mes_numero = date('n', strtotime($f_fin)); // 'n' devuelve el mes sin ceros iniciales
    $mes = $meses[$mes_numero];
}

if (isset($_POST['sector_facturado'])) {
    $sector = $_POST['sector_facturado'];
}

// Verificar si ya existen facturas para el sector, mes y año seleccionados
$facturasExistentes = false;
if (!empty($sector) && !empty($f_fin)) {
    $query = " SELECT COUNT(*) FROM factura f INNER JOIN clientes c ON f.cod_cliente = c.codigo WHERE c.sector = :sector AND f.mes_cobrado = :mes AND YEAR(f.fecha_fin_cobro) = YEAR(:fecha_fin)";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':sector', $sector);
    $stmt->bindValue(':mes', $mes);
    $stmt->bindValue(':fecha_fin', $f_fin);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $facturasExistentes = true;
    }
}

// Consultar la base de datos para obtener los usuarios del sector especificado
$clientes = [];
if (!empty($sector) && !$facturasExistentes) {
    $query = "SELECT codigo, nombre, apellido, fundador, uso, orden FROM clientes WHERE sector = :sector and activo='SI' ORDER BY orden ASC";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':sector', $sector);
    $stmt->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Consultar la tabla de precios
$precios = [];
$query = "SELECT * FROM precio";
$stmt = $conn->prepare($query);
$stmt->execute();
$precios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="facturacion-styles.css">
</head>

<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">Facturación</div>
            <div><a href="principal.php"><i class="fa fa-home" aria-hidden="true" style="color:white; font-size: 30px"></i></a></div>
            <div>
                <button class="logout-button" onclick="cerrar()">Cerrar Sesión</button>
            </div>
        </nav>
        <div class="content">
            <aside class="sidebar">
                <ul class="menu-list">
                    <li><a href="facturacion.php"><i class="fa fa-file" aria-hidden="true"></i><br>Generar Facturas</a></li>
                    <li><a href="facturas.php"><i class="fa fa-print" aria-hidden="true"></i><br>Imprimir Facturas</a></li>
                    <li><a href="modificar_factura.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br>Editar Facturas</a></li>
                    <li><a href="eliminar_facturas.php"><i class="fa fa-trash-o" aria-hidden="true"></i><br>Eliminar Facturas</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <!-- Vista del Resumen -->
                <div id="summaryView" class="summary-view" style="display: none;">
                    <div class="general-info">
                        <h3>Datos Generales</h3>
                        <div class="summary-grid">
                            <p><strong>Fecha de inicio de cobro:</strong> <?php echo isset($f_inicio) ? $f_inicio : 'N/A'; ?></p>
                            <p><strong>Fecha de finalización de cobro:</strong> <?php echo isset($f_fin) ? $f_fin : 'N/A'; ?></p>
                            <p><strong>Fecha límite de pago:</strong> <?php echo isset($f_cobro) ? $f_cobro : 'N/A'; ?></p>
                            <p><strong>Fecha límite de pago 2:</strong> <?php echo isset($f_cobro_2) ? $f_cobro_2 : 'N/A'; ?></p>
                            <p><strong>Mes a facturar:</strong> <?php echo isset($mes) ? $mes : 'N/A'; ?></p>
                        </div>
                        <div class="button-group">
                            <button class="submit-button" id="editButton">Editar Información</button>
                        </div>
                    </div>
                    <div class="contenedor-filtro">
                        <form method="POST" action="facturacion.php" class="filtro">
                            <label for="sector">Filtrar Por: </label>
                            <input type="number" id="sector" name="sector_facturado" placeholder="Sector" min="1">
                            <input type="hidden" id="f_inicio" name="fecha_inicio" value="<?php echo $f_inicio; ?>">
                            <input type="hidden" id="f_fin" name="fecha_fin" value="<?php echo $f_fin; ?>">
                            <input type="hidden" id="f_cobro" name="fecha_cobro" value="<?php echo $f_cobro; ?>">
                            <input type="hidden" id="f_cobro_2" name="fecha_cobro_2" value="<?php echo $f_cobro_2; ?>">
                            <input type="hidden" id="mes_facturado" name="mes_facturado" value="<?php echo $mes; ?>">
                            <button type="submit">Filtrar</button>
                        </form>
                    </div>
                    <table>
                        <tr>
                            <th>Código</th>
                            <th>Orden</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fundador</th>
                            <th>Tipo de Uso</th>
                            <th>Lectura Anterior</th>
                            <th>Lectura Actual</th>
                            <th>Consumo</th>
                            <th>Anotaciones</th>
                            <th>Deuda</th>
                            <th>Total Factura</th>
                            <th>Total</th>
                        </tr>
                        <?php
                        if (count($clientes) > 0) {
                            foreach ($clientes as $row) {
                                $codigo = $row['codigo'];
                                $query = "SELECT * FROM deudores WHERE cod_cliente = :codigo LIMIT 1";
                                $stmt = $conn->prepare($query);
                                $stmt->bindValue(':codigo', $codigo);
                                $stmt->execute();
                                $deuda = $stmt->fetch(PDO::FETCH_ASSOC);
                                $valor_deuda = $deuda ? $deuda['valor_total'] : 0;

                                $sql = "SELECT * FROM factura WHERE cod_cliente = :codigo ORDER BY fecha_fin_cobro DESC LIMIT 1";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindValue(':codigo', $codigo);
                                $stmt->execute();
                                $factura = $stmt->fetch(PDO::FETCH_ASSOC);
                                $lectura_anterior = $factura ? $factura['lectura_final'] : 0;
                                echo "<tr>
                                    <td> " . $row["codigo"] . "</td>
                                    <td> " . $row["orden"] . "</td>
                                    <td> " . $row["nombre"] . "</td>
                                    <td> " . $row["apellido"] . "</td>
                                    <td> " . $row["fundador"] . "</td>
                                    <td> " . $row["uso"] . "</td>
                                    <td> <input type='number' class='lectura-anterior' name='lectura_anterior[]' value='" . $lectura_anterior . "'> </td>
                                    <td> <input type='number' class='lectura-actual' name='lectura_actual[]' onchange='calculateConsumo(this)'></td>
                                    <td> <input type='number' class='consumo' name='consumo[]' readonly> </td>
                                    <td class= 'table-cell'> <textarea class='anotaciones' name='anotaciones[]'>Ninguna</textarea> </td>
                                    <td> <input type='number' class='deuda' name='deuda[]' value='" . $valor_deuda . "'> </td>
                                    <td> 0 </td>
                                    <td> 0 </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr>
                                <td> N.E </td>
                                <td> N.E </td>
                                <td> N.E </td>
                                <td> N.E </td>
                                <td> N.E </td>
                                <td> <input type='number' class='lectura-anterior' name='lectura_anterior[]'></td>
                                <td> <input type='number' class='lectura-actual' name='lectura_actual[]' onchange='calculateConsumo(this)'></td>
                                <td> <input type='number' class='consumo' name='consumo[]' readonly> </td>
                                <td class= 'table-cell'> <textarea name='anotaciones[]'></textarea> </td>
                                <td> <input type='number' class='deuda' name='deuda[]'></td>
                                <td> N.E </td>
                                <td> N.E </td>
                            </tr>";
                        }
                        ?>
                    </table>
                    <div class="button-group">
                        <button class="calculate-button" id="calculateButton" type="button">Calcular Totales</button>
                        <button class="save-button" id="saveButton" type="button">Guardar Facturas</button>
                    </div>
                </div>

                <!-- Formulario de Facturación -->
                <form class="billing-form" id="billingForm" method="POST" action="facturacion.php">
                    <div class="form-group">
                        <label for="f-inicio">Fecha de inicio de cobro:</label>
                        <input type="date" id="f-inicio" name="fecha_inicio" value="<?php echo $f_inicio; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="f-fin">Fecha de finalización de cobro:</label>
                        <input type="date" id="f-fin" name="fecha_fin" value="<?php echo $f_fin; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="f-cobro">Fecha límite de pago:</label>
                        <input type="date" id="f-cobro" name="fecha_cobro" value="<?php echo $f_cobro; ?>" required>
                        <input type="date" id="f-cobro-2" name="fecha_cobro_2" value="<?php echo $f_cobro_2; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="mes">Mes a facturar:</label>
                        <label id="mes-label"><?php echo isset($mes) ? ucfirst(strtolower(trim($mes))) : ''; ?></label>
                    </div>
                    <input type="hidden" id="sector_hidden" name="sector_facturado" value="<?php echo $sector; ?>">
                    <input type="hidden" id="mes_hidden" name="mes_facturado" value="<?php echo $mes; ?>">
                    <div class="form-group button-group">
                        <button type="submit" name="submit" class="submit-button">Siguiente</button>
                    </div>
                </form>
            </main>
        </div>
    </div>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const editButton = document.getElementById('editButton');
            const billingForm = document.getElementById('billingForm');
            const summaryView = document.getElementById('summaryView');
            const fFin = document.getElementById('f-fin');
            const fInicio = document.getElementById('f-inicio');
            const fCobro = document.getElementById('f-cobro');
            const fCobro2 = document.getElementById('f-cobro-2');
            const mesLabel = document.getElementById('mes-label');
            const mesHidden = document.getElementById('mes_hidden');
            const calculateButton = document.getElementById('calculateButton');
            const saveButton = document.getElementById('saveButton');
            const facturasExistentes = <?php echo json_encode($facturasExistentes); ?>;

            // Función para actualizar el mes en tiempo real
            fCobro.addEventListener('change', function() {
                // Obtén el valor del campo fecha_cobro1
                const valorFecha = fCobro.value;
                // Verifica que el campo no esté vacío
                if (valorFecha) {
                    // Crear un objeto Date a partir del valor de fecha
                    const fecha = new Date(valorFecha);
                    
                    // Sumar un día a la fecha
                    fecha.setDate(fecha.getDate() + 1);
                    
                    // Formatear la fecha para el campo input (YYYY-MM-DD)
                    const fechaFormateada = fecha.toISOString().split('T')[0];
                    
                    // Actualizar el campo fecha_cobro2 con la nueva fecha
                    fCobro2.value = fechaFormateada;    
                } else {
                    // Si fecha_cobro1 está vacío, limpia fecha_cobro2
                    fCobro2.value = '';
                }
            });

            // Función para actualizar el mes en tiempo real
            fFin.addEventListener('change', function() {
                const finDate = new Date(fFin.value + "T00:00:00"); // Evitar ajustes de zona horaria
                if (isNaN(finDate)) {
                    mesLabel.textContent = '';
                    mesHidden.value = '';
                    return;
                }

                // Actualizar el mes en la etiqueta y el campo oculto
                const monthNames = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
                const month = monthNames[finDate.getMonth()];
                mesLabel.textContent = month.charAt(0).toUpperCase() + month.slice(1);
                mesHidden.value = month;
            });

            // Validar las fechas y actualizar el mes al enviar el formulario
            billingForm.addEventListener('submit', function(event) {
                const inicioDate = new Date(fInicio.value + "T00:00:00");
                const finDate = new Date(fFin.value + "T00:00:00");
                const cobroDate = new Date(fCobro.value + "T00:00:00");

                if (finDate <= inicioDate) {
                    alert("La fecha de finalización de cobro debe ser mayor que la fecha de inicio de cobro.");
                    event.preventDefault();
                    return;
                }

                if (cobroDate <= finDate) {
                    alert("La fecha límite de pago debe ser mayor que la fecha de finalización de cobro.");
                    event.preventDefault();
                    return;
                }

                // Si todo está bien, el mes ya habrá sido actualizado en el cambio de fecha
            });

            // Mostrar el formulario y ocultar el resumen si no hay datos
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
                billingForm.style.display = 'none';
                summaryView.style.display = 'block';
            <?php } else { ?>
                billingForm.style.display = 'grid';
                summaryView.style.display = 'none';
            <?php } ?>

            // Manejar el clic en el botón de editar información
            editButton.addEventListener('click', function() {
                summaryView.style.display = 'none';
                billingForm.style.display = 'grid';
            });

            // Función para calcular el consumo
            window.calculateConsumo = function(element) {
                let row = element.closest('tr');
                let lecturaAnterior = parseFloat(row.querySelector('.lectura-anterior').value) || 0;
                let lecturaActual = parseFloat(element.value) || 0;
                let consumo = lecturaActual - lecturaAnterior;
                row.querySelector('.consumo').value = consumo;
            }

            window.calculateConsumo2 = function(element) {
                let row = element.closest('tr');
                let lecturaActual = parseFloat(row.querySelector('.lectura-actual').value) || 0;
                let lecturaAnterior = parseFloat(element.value) || 0;
                let consumo = lecturaActual - lecturaAnterior;
                row.querySelector('.consumo').value = consumo;
            }

            // Validar cuando se cambia la lectura anterior
            document.querySelectorAll('.lectura-anterior').forEach(function(input) {
                input.addEventListener('change', function() {
                    let row = input.closest('tr');
                    let lecturaActual = parseFloat(row.querySelector('.lectura-actual').value) || 0;
                    let lecturaAnterior = parseFloat(input.value) || 0;

                    if (lecturaAnterior > lecturaActual) {
                        alert("La lectura anterior debe ser menor o igual que la lectura actual.");
                        input.value = lecturaActual;
                    }
                    calculateConsumo(row.querySelector('.lectura-actual'));
                });
            });

            // Validar cuando se cambia la lectura actual
            document.querySelectorAll('.lectura-actual').forEach(function(input) {
                input.addEventListener('change', function() {
                    let row = input.closest('tr');
                    let lecturaAnterior = parseFloat(row.querySelector('.lectura-anterior').value) || 0;
                    let lecturaActual = parseFloat(input.value) || 0;
                    if (lecturaAnterior > lecturaActual) {
                        alert("La lectura actual debe ser mayor o igual que la lectura anterior.");
                        input.value = lecturaAnterior;
                    }
                    calculateConsumo2(row.querySelector('.lectura-anterior'));
                });
            });

            // Validar la deuda en tiempo real
            document.querySelectorAll('.deuda').forEach(function(input) {
                input.addEventListener('input', function() {
                    if (input.value.trim() === '') {
                        alert("El campo de deuda no puede estar vacío.");
                        input.value = 0;
                    }
                });
            });

            // Función para calcular el valor total
            function calcularValorTotal(consumo, tipoUso, fundador, precios) {
                let valorTotal = 0;
                let valorBase = 0;
                let valorConsumo = 0;
                precios.forEach(precio => {
                    let medidaInicial = precio.medida_inicial;
                    let medidaFinal = precio.medida_final;
                    let valor = 0;

                    // Precio o cobro base
                    if (medidaInicial == 0 && medidaFinal == 0) {
                        valor = precio.valor_fundador;
                        valorBase = valor;
                        valorTotal += 1 * valor;
                    } else if (consumo >= medidaInicial && consumo <= medidaFinal) {
                        let consumoRango = (consumo - medidaInicial) + 1;
                        if (fundador == 'SI') {
                            valor = precio.valor_fundador;
                            valorTotal += consumoRango * valor;
                        } else {
                            if (tipoUso == 'Residencial') {
                                valor = precio.valor_residencial;
                            } else if (tipoUso == 'Comercial') {
                                valor = precio.valor_comercial;
                            } else if (tipoUso == 'Industrial') {
                                valor = precio.valor_industrial;
                            }
                            valorTotal += consumoRango * valor;
                        }
                    } else if (consumo > medidaFinal) {
                        let consumoRango = (medidaFinal - medidaInicial) + 1;
                        if (fundador == 'SI') {
                            valor = precio.valor_fundador;
                            valorTotal += consumoRango * valor;
                        } else {
                            if (tipoUso == 'Residencial') {
                                valor = precio.valor_residencial;
                            } else if (tipoUso == 'Comercial') {
                                valor = precio.valor_comercial;
                            } else if (tipoUso == 'Industrial') {
                                valor = precio.valor_industrial;
                            }
                            valorTotal += consumoRango * valor;
                        }
                    }

                });
                valorConsumo = valorTotal - valorBase;
                return {
                    valorTotal: valorTotal,
                    cobroBasico: valorBase,
                    cobroConsumo: valorConsumo
                };
            }

            // Validar si todos los campos necesarios están completos
            function validateFields() {
                let valid = true;
                let rows = document.querySelectorAll('table tr');

                rows.forEach((row, index) => {
                    if (index > 0) { // Ignorar la cabecera
                        let lecturaAnterior = row.querySelector('.lectura-anterior').value.trim();
                        let lecturaActual = row.querySelector('.lectura-actual').value.trim();
                        let deuda = row.querySelector('.deuda').value.trim();

                        if (lecturaAnterior === '' || lecturaActual === '' || deuda === '') {
                            valid = false;
                            return;
                        }

                        let consumo = parseFloat(lecturaActual) - parseFloat(lecturaAnterior);
                        if (consumo < 0) {
                            valid = false;
                            return;
                        }
                    }
                });
                if (valid == false) {
                    alert("Los campos no estan completos o estan mal dijitados.");
                }

                return valid;
            }

            // Manejar el clic en el botón de calcular totales
            calculateButton.addEventListener('click', function() {
                if (validateFields()) {
                    let table = document.querySelector('table');
                    let rows = table.querySelectorAll('tr');

                    rows.forEach((row, index) => {
                        if (index > 0) { // Ignorar la cabecera
                            
                            let cells = row.querySelectorAll('td');
                            let consumo = parseFloat(row.querySelector('.consumo').value) || 0;
                            let tipoUso = cells[5].innerText;
                            let fundador = cells[4].innerText;

                            let resultado = calcularValorTotal(consumo, tipoUso, fundador, <?php echo json_encode($precios); ?>);

                            let valorTotal = resultado.valorTotal;
                            let cobroBasico = resultado.cobroBasico;
                            let cobroConsumo = resultado.cobroConsumo;

                            row.setAttribute('data-cobro-factura', valorTotal);
                            cells[11].innerText = valorTotal.toFixed(); // Actualizar la celda de total factura

                            let deuda = parseFloat(row.querySelector('.deuda').value) || 0;
                            valorTotal = valorTotal + deuda;

                            cells[12].innerText = valorTotal.toFixed(); // Actualizar la celda de total

                            row.setAttribute('data-cobro-basico', cobroBasico);
                            row.setAttribute('data-cobro-consumo', cobroConsumo);
                        }
                    });
                }
            });

            // Manejar el clic en el botón de guardar facturas
            saveButton.addEventListener('click', function() {
                if (validateFields()) {
                    let table = document.querySelector('table');
                    let rows = table.querySelectorAll('tr');
                    let data = [];

                    rows.forEach((row, index) => {
                        if (index > 0) { // Ignorar la cabecera
                            let cells = row.querySelectorAll('td');
                            let lectura_anterior = row.querySelector('input.lectura-anterior').value;
                            let lectura_actual = row.querySelector('input.lectura-actual').value;
                            let consumo = row.querySelector('input.consumo').value;
                            let anotaciones = row.querySelector('textarea.anotaciones').value;
                            let deuda = row.querySelector('input.deuda').value;
                            let cobroBasico = row.getAttribute('data-cobro-basico');
                            let valorConsumo = row.getAttribute('data-cobro-consumo');

                            let rowData = {
                                codigo: cells[0].innerText,
                                nombre: cells[2].innerText,
                                apellido: cells[3].innerText,
                                fundador: cells[4].innerText,
                                lectura_anterior: lectura_anterior,
                                lectura_actual: lectura_actual,
                                consumo: consumo,
                                anotaciones: anotaciones,
                                deuda: deuda,
                                total: cells[12].innerText,
                                valor_consumo: valorConsumo,
                                valor_basico: cobroBasico,
                                valor_factura: cells[11].innerText
                            };
                            data.push(rowData);
                        }
                    });

                    let generalData = {
                        fecha_inicio: '<?php echo $f_inicio; ?>',
                        fecha_fin: '<?php echo $f_fin; ?>',
                        fecha_cobro: '<?php echo $f_cobro; ?>',
                        fecha_cobro_2: '<?php echo $f_cobro_2; ?>',
                        mes_facturado: mesHidden.value,
                        sector_facturado: '<?php echo $sector; ?>'
                    };

                    fetch('save_facturas.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                generalData: generalData,
                                facturas: data
                            })
                        }).then(response => response.json())
                        .then(data => {
                            alert('Facturas guardadas exitosamente');
                        }).catch((error) => {
                            console.log('Error:', error);
                            alert('Hubo un error al guardar las facturas o lasfacturas ya existen');
                        });
                }
            });

            // Mostrar alerta y deshabilitar botones si ya existen facturas
            if (facturasExistentes) {
                alert("Ya existen facturas para este sector en el mes y año seleccionados. No se pueden generar nuevas facturas.");
                if (calculateButton) calculateButton.disabled = true;
                if (saveButton) saveButton.disabled = true;
            }
        });

        function cerrar() {
            setTimeout(function() {
                window.location = "<?= 'logout.php' ?>";}, 0000); // Aquí es donde se "redirecciona" luego de trancurridos los N segundos que indiques
        }
    </script>
</body>

</html>