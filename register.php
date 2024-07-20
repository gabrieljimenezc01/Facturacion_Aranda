<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="login-styles.css">
</head>
<body>
    <div class="container">
        <div class="form-box2" id="register-box">
            <h2><i class="fa fa-user-plus" aria-hidden="true"></i> Registro de Usuario</h2>
            <?php
            session_start();
            $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
            $old_data = isset($_SESSION['old_data']) ? $_SESSION['old_data'] : [];
            unset($_SESSION['errors'], $_SESSION['old_data']);
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($errors) && !empty($errors)) {
                echo "<p class='error'>" . implode("<br>", $errors) . "</p>";
            }
            ?>
            <form action="create_users.php" method="post">
                <div class="input-box">
                    <label for="register-username-nombre">Nombre</label>
                    <input name="nombre" type="text" id="register-username-nombre" placeholder="Tu Nombre" value="<?= isset($old_data['nombre']) ? htmlspecialchars($old_data['nombre']) : '' ?>">
                </div>
                <div class="input-box">
                    <label for="register-username-apellido">Apellido</label>
                    <input name="apellido" type="text" id="register-username-apellido" placeholder="Tu Apellido" value="<?= isset($old_data['apellido']) ? htmlspecialchars($old_data['apellido']) : '' ?>">
                </div>
                <div class="input-box">
                    <label for="register-username-user">Nombre de Usuario</label>
                    <input name="user" type="text" id="register-username-user" placeholder="Tu Nombre de Usuario" value="<?= isset($old_data['user']) ? htmlspecialchars($old_data['user']) : '' ?>">
                </div>
                <div class="input-box">
                    <label for="register-password">Contraseña</label>
                    <input name="password" type="password" id="register-password" placeholder="********">
                </div>
                <div class="input-box">
                    <label for="special-password">Contraseña Especial</label>
                    <input name="special" type="password" id="special-password" placeholder="Contraseña Especial">
                    <?php if (isset($errors['special'])): ?>
                        <p class='error'><?= $errors['special'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="actions">
                    <button type="submit" name="register">Registrarse</button>
                </div>
                <div class="switch">
                    <button type="button" onclick="location.href='login.php'">Iniciar Sesión</button>
                </div>
            </form>
        </div>
        <div class="image-container">
            <img src="img/prueba1.jpg" alt="Imagen de la Empresa1">
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Acueducto de Aranda. Todos los derechos reservados. | <a href="#">Términos de Servicio</a> | <a href="#">Política de Privacidad</a> | <a href="#">Contacto</a></p>
    </footer>
</body>
</html>
