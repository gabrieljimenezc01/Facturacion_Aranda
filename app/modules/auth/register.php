<?php
// register.php - Registro de nuevos usuarios

// Cargar configuración central
if (!defined('BASE_PATH')) {
    require_once dirname(__DIR__, 3) . '/config/app.php';
}

require_once APP_PATH . '/middleware/AuthMiddleware.php';
checkGuest();

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$old_data = isset($_SESSION['old_data']) ? $_SESSION['old_data'] : [];
unset($_SESSION['errors'], $_SESSION['old_data']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario - Acueducto de Aranda</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo PUBLIC_URL; ?>/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo PUBLIC_URL; ?>/css/register-styles.css">
</head>
<body>
    <div class="container">
        <div class="form-box2" id="register-box">
            <h2><i class="fa fa-user-plus" aria-hidden="true"></i> Registro de Usuario</h2>
            
            <form action="<?php echo PUBLIC_URL; ?>/index.php?page=create_user" method="post">
                <div class="input-box">
                    <label for="register-username-nombre">Nombre</label>
                    <input name="nombre" type="text" id="register-username-nombre" placeholder="Tu Nombre" value="<?php echo isset($old_data['nombre']) ? htmlspecialchars($old_data['nombre']) : ''; ?>">
                    <?php if (isset($errors['nombre'])): ?>
                        <p class='error'><?php echo htmlspecialchars($errors['nombre']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="input-box">
                    <label for="register-username-apellido">Apellido</label>
                    <input name="apellido" type="text" id="register-username-apellido" placeholder="Tu Apellido" value="<?php echo isset($old_data['apellido']) ? htmlspecialchars($old_data['apellido']) : ''; ?>">
                    <?php if (isset($errors['apellido'])): ?>
                        <p class='error'><?php echo htmlspecialchars($errors['apellido']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="input-box">
                    <label for="register-username-user">Nombre de Usuario</label>
                    <input name="user" type="text" id="register-username-user" placeholder="Tu Nombre de Usuario" value="<?php echo isset($old_data['user']) ? htmlspecialchars($old_data['user']) : ''; ?>">
                    <?php if (isset($errors['user'])): ?>
                        <p class='error'><?php echo htmlspecialchars($errors['user']); ?></p>
                    <?php endif; ?>
                    <?php if (isset($errors['duplicate'])): ?>
                        <p class='error'><?php echo htmlspecialchars($errors['duplicate']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="input-box">
                    <label for="register-password">Contraseña</label>
                    <input name="password" type="password" id="register-password" placeholder="********">
                    <?php if (isset($errors['password'])): ?>
                        <p class='error'><?php echo htmlspecialchars($errors['password']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="input-box">
                    <label for="special-password">Contraseña Especial</label>
                    <input name="special" type="password" id="special-password" placeholder="Contraseña Especial">
                    <?php if (isset($errors['special'])): ?>
                        <p class='error'><?php echo htmlspecialchars($errors['special']); ?></p>
                    <?php endif; ?>
                </div>
                <div class="actions">
                    <button type="submit" name="register">Registrarse</button>
                </div>
                <?php if (isset($errors['general'])): ?>
                    <p class='error'><?php echo htmlspecialchars($errors['general']); ?></p>
                <?php endif; ?>
                <div class="switch">
                    <button type="button" onclick="location.href='<?php echo PUBLIC_URL; ?>/index.php?page=login'">Iniciar Sesión</button>
                </div>
            </form>
        </div>
        <div class="image-container">
            <img src="<?php echo PUBLIC_URL; ?>/img/prueba1.jpg" alt="Imagen de la Empresa1">
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Acueducto de Aranda. Todos los derechos reservados. | <a href="#">Términos de Servicio</a> | <a href="#">Política de Privacidad</a> | <a href="#">Contacto</a></p>
    </footer>
</body>
</html>