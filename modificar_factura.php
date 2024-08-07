<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
};

// Consultar la tabla de precios
$precios = [];
$query = "SELECT * FROM precio";
$stmt = $conn->prepare($query);
$stmt->execute();
$precios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];

    $sql = "SELECT * FROM factura f JOIN clientes c ON f.cod_cliente = c.codigo WHERE f.cod_factura = :cod_factura LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':cod_factura', $searchTerm);
    $stmt->execute();
    $factura = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($factura) {
        $cod_factura = $factura['cod_factura'];
        $fecha_inicio = $factura['fecha_inicio_cobro'];
        $fecha_fin = $factura['fecha_fin_cobro'];
        $fecha_cobro = $factura['fecha_limite_pago'];
        $mes = $factura['mes_cobrado'];
        $lectura_anterior = $factura['lectura_inicial'];
        $lectura_actual = $factura['lectura_final'];
        $consumo = $factura['consumo_m3'];
        $anotaciones = $factura['Anotaciones'];
        $deuda = $factura['valor_deuda'];
        $total = $factura['valor_total'];
        $total_factura = $factura['valor_factura'];
        $valor_basico = $factura['valor_basico'];
        $valor_consumo= $factura['valor_consumo'];
        $nombre = $factura['nombre'];
        $apellido = $factura['apellido'];
        $fundador = $factura['fundador'];
        $uso = $factura['uso'];

    } else {
        $error = "No se encontró ninguna factura.";
    }
}
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
    <link rel="stylesheet" href="modificar-factura-styles.css">
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
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alerta">
                        ¡La factura se ha modificado con éxito!
                    </div>
                <?php endif; ?>
                <div class="search-container">
                    <form method="POST" class="search">
                        <input type="text" id="search-box" name="searchTerm" placeholder="Buscar factura" required>
                        <button type="submit" id="search-button" name="search"><i class="fa fa-search"></i> Buscar</button>
                    </form>
                </div>

                <?php if (isset($cod_factura)): ?>
                <form id="modify-invoice-form" action="actualizar_factura.php" method="POST">
                    <h2>Modificar Factura</h2>
                    <label for="codfactura">Número de Factura:</label>
                    <input type="text" id="codfactura" name="cod_factura" value="<?php echo $cod_factura; ?>" readonly>

                    <label for="fi">Fecha de inicio:</label>
                    <input type="text" id="fi" name="fi" value="<?php echo $fecha_inicio; ?>" readonly>

                    <label for="ff">Fecha de fin:</label>
                    <input type="text" id="ff" name="ff" value="<?php echo $fecha_fin; ?>" readonly>

                    <label for="fc">Fecha de cobro:</label>
                    <input type="text" id="fc" name="fc" value="<?php echo $fecha_cobro; ?>" readonly>

                    <label for="mes">Mes facturado:</label>
                    <input type="text" id="mes" name="mes" value="<?php echo $mes; ?>" readonly>

                    <label for="nombre">Nombre del Cliente:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" readonly>

                    <label for="apellido">Apellido del Cliente:</label>
                    <input type="text" id="apellido" name="apellido" value="<?php echo $apellido; ?>" readonly>

                    <label for="fundador">Fundador:</label>
                    <input type="text" id="fundador" name="fundador" value="<?php echo $fundador; ?>" readonly>

                    <label for="uso">Tipo de uso:</label>
                    <input type="text" id="uso" name="uso" value="<?php echo $uso; ?>" readonly>

                    <label for="lectura-anterior">Lectura Anterior:</label>
                    <input type="number" class="modify-input" id="lectura-anterior" name="lectura-anterior" value="<?php echo $lectura_anterior; ?>">

                    <label for="lectura-actual">Lectura Actual:</label>
                    <input type="number" class="modify-input" id="lectura-actual" name="lectura-actual" value="<?php echo $lectura_actual; ?>">

                    <label for="consumo">Consumo m^3:</label>
                    <input type="number" id="consumo" name="consumo" value="<?php echo $consumo; ?>" readonly>

                    <label for="anotaciones">Anotaciones:</label>
                    <input type="text" id="anotaciones" class="modify-input" name="anotaciones" value="<?php echo $anotaciones; ?>">

                    <label for="deuda">Deuda:</label>
                    <input type="number" id="deuda" name="deuda" value="<?php echo $deuda; ?>">

                    <label for="valorfactura">Valor Factura:</label>
                    <input type="number" id="valorfactura" name="valor_factura" value="<?php echo $total_factura; ?>" readonly>

                    <label for="total">Valor Total:</label>
                    <input type="number" id="total" name="total" value="<?php echo $total; ?>" readonly>

                    <!-- Campos ocultos para valor_consumo y valor_factura -->
                    <input type="hidden" id="valor_consumo" name="valor_consumo" value="<?php echo $valor_consumo; ?>">
                    <input type="hidden" id="valor_basico" name="valor_basico" value="<?php echo $valor_basico; ?>">

                    <div class="contenedor-save">
                        <button type="submit" class="save-button"><i class="fa fa-floppy-o"></i> Guardar Cambios</button>
                    </div>
                </form>
                <?php elseif (isset($error)): ?>
                    <p><?php echo $error; ?></p>
                <?php endif; ?>
            </main>
        </div>
    </div>
    <script>
        const precios = <?php echo json_encode($precios); ?>;

        
        document.getElementById('lectura-anterior').addEventListener('input', calcularValores);
        document.getElementById('lectura-actual').addEventListener('input', calcularValores);

        function calcularValores() {
            // Obtener los valores de las lecturas
            const lecturaAnterior = parseFloat(document.getElementById('lectura-anterior').value);
            const lecturaActual = parseFloat(document.getElementById('lectura-actual').value);
            const consumoInput = document.getElementById('consumo');
            const totalInput = document.getElementById('total');
            const deudaInput = parseFloat(document.getElementById('deuda').value);
            const valorFacturaInput = document.getElementById('valorfactura');
            const tipoUso = document.getElementById('uso').value;
            const fundador = document.getElementById('fundador').value;

            // Validar que la lectura anterior sea menor que la actual
            if (lecturaAnterior >= lecturaActual) {
                consumoInput.value = '';
                totalInput.value = '';
                alert('La lectura actual debe ser mayor que la lectura anterior.');
                return;
            }

            // Calcular el consumo
            if (!isNaN(lecturaActual) && !isNaN(lecturaAnterior)) {
                const consumo = lecturaActual - lecturaAnterior;
                consumoInput.value = consumo;
                const resultado = calcularValorTotal(consumo, tipoUso, fundador, precios);

                valorFacturaInput.value = resultado.valorTotal;
                document.getElementById('valor_basico').value = resultado.cobroBasico;
                document.getElementById('valor_consumo').value = resultado.cobroConsumo;
                const total = resultado.valorTotal + deudaInput;
                totalInput.value = total;
            }
        }

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

        document.getElementById('modify-invoice-form').addEventListener('submit', function(event) {
            // Validar que todos los campos estén llenos, excepto el campo de anotaciones
            const fields = document.querySelectorAll('#modify-invoice-form input:not(#anotaciones)');
            for (let field of fields) {
                if (field.value.trim() === '') {
                    alert('Por favor, rellena todos los campos o revisa si todo esta correctamente digitado.');
                    event.preventDefault(); // Detener el envío del formulario
                    return;
                }
            }

            // Validar que la lectura anterior sea menor que la actual
            const lecturaAnterior = parseFloat(document.getElementById('lectura-anterior').value);
            const lecturaActual = parseFloat(document.getElementById('lectura-actual').value);
            if (lecturaAnterior >= lecturaActual) {
                alert('La lectura actual debe ser mayor que la lectura anterior.');
                event.preventDefault(); // Detener el envío del formulario
                return;
            }
        });
        
    function cerrar(){    
        setTimeout(function(){ window.location="<?= 'logout.php' ?>"; }, 0000); // Aquí es donde se "redirecciona" luego de trancurridos los N segundos que indiques
    }
    </script>
</body>
</html>
