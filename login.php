<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="login-styles.css">
</head>
<body>
    <div class="container">
        <div class="form-box1" id="login-box">
            <h2><i class="fa fa-sign-in" aria-hidden="true"></i> Inicio de Sesión</h2><br>
            <?php
            session_start();
            $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
            $old_data = isset($_SESSION['old_data']) ? $_SESSION['old_data'] : [];
            unset($_SESSION['errors'], $_SESSION['old_data']);
            ?>
            <form action="authenticate.php" method="post">
                <div class="input-box">
                    <label for="login-username">Nombre de Usuario</label>
                    <input name="user" type="text" id="login-username" placeholder="Tu Nombre de Usuario" value="<?= isset($old_data['user']) ? htmlspecialchars($old_data['user']) : '' ?>"><br>
                    <?php if (isset($errors['user'])): ?>
                        <p class='error'><?= $errors['user'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="input-box">
                    <label for="login-password">Contraseña</label>
                    <input name="password" type="password" id="login-password" placeholder="********"><br>
                    <?php if (isset($errors['password'])): ?>
                        <p class='error'><?= $errors['password'] ?></p>
                    <?php endif; ?>
                </div><br>
                <div class="actions">
                    <button type="submit" name="login">Iniciar Sesión</button>
                </div><br>
                <?php if (isset($errors['general'])): ?>
                    <p class='error'><?= $errors['general'] ?></p>
                <?php endif; ?>
                <div class="switch">
                    <button type="button" onclick="location.href='register.php'">Registrar Nueva Cuenta</button>
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
