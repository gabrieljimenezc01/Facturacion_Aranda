
<?php
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
require 'db.php';

$add_msg = isset($_GET['msg']) ? $_GET['msg'] : '';

// Filtrado de clientes
$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$sector = isset($_POST['sector']) ? $_POST['sector'] : '';

$sql = "SELECT * FROM clientes WHERE (codigo LIKE :codigo) AND (nombre LIKE :nombre) AND (sector LIKE :sector)";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':codigo', "%$codigo%", PDO::PARAM_STR);
$stmt->bindValue(':nombre', "%$nombre%", PDO::PARAM_STR);
$stmt->bindValue(':sector', "%$sector%", PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_GET['modificar_id'])) {
    $id = $_GET['modificar_id'];
    $sql = "SELECT * FROM clientes WHERE (codigo LIKE :codigo) LIMIT 1";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="modificar-usuario-styles.css">
</head>
<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">Sistema de Facturación</div>
            <div>
                <button class="logout-button">Cerrar Sesión</button>
            </div>
        </nav>
        <div class="content">
            <aside class="sidebar">
                <ul class="menu-list">
                    <li><a href="agregar-usuario.php"><i class="fa fa-user-plus" aria-hidden="true"></i><br> Agregar Usuario</a></li>
                    <li><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><br> Modificar Datos Usuario</a></li>
                    <li><a href="eliminar-usuario.php"><i class="fa fa-user-times" aria-hidden="true"></i><br> Eliminar Usuario</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <h2>Modificar Usuario</h2>
                <?php if ($add_msg): ?>
                    <p class="msg"><?php echo htmlspecialchars($add_msg); ?></p>
                <?php endif; ?>
                <div class="mensajes"></div>
                <form class="form-modificar" method="POST" action="procesar_modificacion.php" onsubmit="return validarFormulario()">
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
                            <select id="estrato" name="estrato" required >
                                <option value="" disabled selected>Seleccione un estrato</option>
                                <option value="1" <?php echo $estrato == 1 ? 'selected' : ''; ?> >1</option>
                                <option value="2" <?php echo $estrato == 2 ? 'selected' : ''; ?> >2</option>
                                <option value="3" <?php echo $estrato == 3 ? 'selected' : ''; ?> >3</option>
                                <option value="4" <?php echo $estrato == 4 ? 'selected' : ''; ?> >4</option>
                                <option value="5" <?php echo $estrato == 5 ? 'selected' : ''; ?> >5</option>
                                <option value="6" <?php echo $estrato == 6 ? 'selected' : ''; ?> >6</option>
                                <option value="7" <?php echo $estrato == 7 ? 'selected' : ''; ?> >7</option>
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
                                <option value="" disabled selected>Seleccione un uso</option>
                                <option value="Residencial" <?php echo $uso === 'Residencial' ? 'selected' : ''; ?> >Residencial</option>
                                <option value="Comercial" <?php echo $uso === 'Comercial' ? 'selected' : ''; ?> >Comercial</option>
                                <option value="Industrial" <?php echo $uso === 'Industrial' ? 'selected' : ''; ?> >Industrial</option>
                            </select>
                            <span class="error-message" id="error-uso"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="codigo_medidor">Código del Medidor:</label>
                            <input type="text" id="codigo_medidor" name="codigo_medidor" required value="<?php echo htmlspecialchars($codigo_medidor); ?>"  maxlength="50">
                            <span class="error-message" id="error-codigo-medidor"></span>
                        </div>
                        <div class="form-group">
                            <label for="diametro_medidor">Diámetro del Medidor:</label>
                            <input type="text" id="diametro_medidor" name="diametro_medidor" required value="<?php echo htmlspecialchars($diametro_medidor); ?>" maxlength="50">
                            <span class="error-message" id="error-diametro-medidor"></span>
                        </div>
                        <div class="form-group checkbox-group center-row">
                            <label for="fundador">Fundador:</label>
                            <input type="checkbox" id="fundador" name="fundador" <?php echo $fundador === 'SI' ? 'checked' : ''; ?> >
                        </div>
                    </div>
                    <div class="btn-modificar">
                        <button type="submit">Modificar</button>
                    </div>
                    
                </form>
                
                <div class="user-list">
                    <h2>Lista de Usuarios</h2>
                    <div class="filtro"> 
                        <!-- Formulario de filtrado -->
                        <form class="form-filtro" method="POST" action="modificar-usuario.php">
                            <label >Filtrar Por: </label>
                            <input type="text" id="codigo" name="codigo" placeholder="Codigo" value="<?php echo htmlspecialchars($codigo); ?>">
                            <input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo htmlspecialchars($nombre); ?>">
                            <input type="text" id="sector" name="sector" placeholder="Sector"value="<?php echo htmlspecialchars($sector); ?>">
                            <button type="submit">Filtrar</button>
                        </form>
                    </div>
                    <table>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Dirección</th>
                        <th>Sector</th>
                        <th>Fundador</th>
                        <th>Acciones</th>
                    </tr>
                    <?php
                    if (count($result) > 0) {
                        foreach ($result as $row) {
                            echo "<tr>
                            <td> ". $row["codigo"] ."</td>
                            <td> ". $row["nombre"] ."</td>
                            <td> ". $row["apellido"] ."</td>
                            <td> ". $row["direccion"] ."</td>
                            <td> ". $row["sector"] ."</td>
                            <td> ". $row["fundador"] ."</td>
                            <td>
                                <a href='modificar-usuario.php?modificar_id=" . $row["codigo"] . "'  onclick='return confirm(\"¿Estás seguro de que deseas modificar este registro?\")'>
                                <img class='img-modificar' src='./img/editar.png' alt='Eliminar'>
                                </a>
                            </td>
                          </tr>";
                        }
                    }
                    ?>
                </table>
                </div>
            </main>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const nombre = document.getElementById('nombre');
        const apellido = document.getElementById('apellido');
        const direccion = document.getElementById('direccion');
        const estrato = document.getElementById('estrato');
        const sector = document.getElementById('sector');
        const uso = document.getElementById('uso');
        const codigo_medidor = document.getElementById('codigo_medidor');
        const diametro_medidor = document.getElementById('diametro_medidor');
        
        const errorNombre = document.getElementById('error-nombre');
        const errorApellido = document.getElementById('error-apellido');
        const errorDireccion = document.getElementById('error-direccion');
        const errorEstrato = document.getElementById('error-estrato');
        const errorSector = document.getElementById('error-sector');
        const errorUso = document.getElementById('error-uso');
        const errorCodigoMedidor = document.getElementById('error-codigo-medidor');
        const errorDiametroMedidor = document.getElementById('error-diametro-medidor');

        nombre.addEventListener('input', function () {
            validarCampoVacio(nombre, errorNombre, 'El nombre es obligatorio.');
        });

        apellido.addEventListener('input', function () {
            validarCampoVacio(apellido, errorApellido, 'El apellido es obligatorio.');
        });

        direccion.addEventListener('input', function () {
            validarCampoVacio(direccion, errorDireccion, 'La dirección es obligatoria.');
        });

        estrato.addEventListener('change', function () {
            validarCampoVacio(estrato, errorEstrato, 'El estrato es obligatorio.');
        });

        sector.addEventListener('input', function () {
            validarCampoNumerico(sector, errorSector, 'El sector es obligatorio.', 'El sector debe ser un número.');
        });

        uso.addEventListener('change', function () {
            validarCampoVacio(uso, errorUso, 'El uso es obligatorio.');
        });

        codigo_medidor.addEventListener('input', function () {
            validarCampoCodigoMedidor(codigo_medidor, errorCodigoMedidor, 'El código del medidor es obligatorio.', 'El código del medidor solo puede contener letras y números.', 'El código del medidor no puede tener más de 50 caracteres.');
        });

        diametro_medidor.addEventListener('input', function () {
            validarCampoVacio(diametro_medidor, errorDiametroMedidor, 'El diámetro del medidor es obligatorio.');
        });

        form.addEventListener('submit', function (event) {
            if (!validarFormulario()) {
                event.preventDefault();
            }
        });
    });

    function validarCampoVacio(campo, errorElement, mensajeError) {
        if (!campo.value.trim()) {
            errorElement.textContent = mensajeError;
        } else {
            errorElement.textContent = '';
        }
    }

    function validarCampoCodigoMedidor(campo, errorElement, mensajeVacio, mensajeInvalido, mensajeLongitud) {
        const regex = /^[a-zA-Z0-9]*$/;
        if (!campo.value.trim()) {
            errorElement.textContent = mensajeVacio;
        } else if (!regex.test(campo.value)) {
            errorElement.textContent = mensajeInvalido;
        } else if (campo.value.length > 50) {
            errorElement.textContent = mensajeLongitud;
        } else {
            errorElement.textContent = '';
        }
    }

    function validarCampoNumerico(campo, errorElement, mensajeVacio, mensajeTipo) {
        if (!campo.value.trim()) {
            errorElement.textContent = mensajeVacio;
        } else if (isNaN(campo.value)) {
            errorElement.textContent = mensajeTipo;
        } else {
            errorElement.textContent = '';
        }
    }

    function validarFormulario() {
        let valido = true;

        if (!document.getElementById('nombre').value.trim()) {
            document.getElementById('error-nombre').textContent = 'El nombre es obligatorio.';
            valido = false;
        }
        if (!document.getElementById('apellido').value.trim()) {
            document.getElementById('error-apellido').textContent = 'El apellido es obligatorio.';
            valido = false;
        }
        if (!document.getElementById('direccion').value.trim()) {
            document.getElementById('error-direccion').textContent = 'La dirección es obligatoria.';
            valido = false;
        }
        if (!document.getElementById('estrato').value.trim()) {
            document.getElementById('error-estrato').textContent = 'El estrato es obligatorio.';
            valido = false;
        }
        if (!document.getElementById('sector').value.trim()) {
            document.getElementById('error-sector').textContent = 'El sector es obligatorio.';
            valido = false;
        } else if (isNaN(document.getElementById('sector').value)) {
            document.getElementById('error-sector').textContent = 'El sector debe ser un número.';
            valido = false;
        }
        if (!document.getElementById('uso').value.trim()) {
            document.getElementById('error-uso').textContent = 'El uso es obligatorio.';
            valido = false;
        }
        if (!document.getElementById('codigo_medidor').value.trim()) {
            document.getElementById('error-codigo-medidor').textContent = 'El código del medidor es obligatorio.';
            valido = false;
        } else if (!/^[a-zA-Z0-9]*$/.test(document.getElementById('codigo_medidor').value)) {
            document.getElementById('error-codigo-medidor').textContent = 'El código del medidor solo puede contener letras y números.';
            valido = false;
        }
        if (!document.getElementById('diametro_medidor').value.trim()) {
            document.getElementById('error-diametro-medidor').textContent = 'El diámetro del medidor es obligatorio.';
            valido = false;
        }

        return valido;
    }
</script>
</html>
