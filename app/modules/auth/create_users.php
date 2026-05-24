<?php
// create_users.php - Procesa el registro de nuevos usuarios

// Cargar configuración central
if (!defined('BASE_PATH')) {
    require_once dirname(__DIR__, 3) . '/config/app.php';
}

// Asegurar conexión a base de datos
if (!isset($conn)) {
    require_once APP_PATH . '/config/database.php';
}

session_start();

$key = 'secure_key_Facturacion_Aranda';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $username = trim($_POST['user']);
    $password = trim($_POST['password']);
    $special = trim($_POST['special']);
    
    $validator = new Validator();
    $validator->validateSpecialPassword($special);
    $validator->validatePassword($password);
    $validator->validateUsername($username);
    $validator->validateDuplicateUsername($username);  // ← Verifica si ya existe
    $validator->validateName($nombre);
    $validator->validateSurname($apellido);

    if ($validator->hasErrors()) {
        $_SESSION['errors'] = $validator->getErrors();
        $_SESSION['old_data'] = $_POST;
        header("Location: " . PUBLIC_URL . "/index.php?page=register");
        exit();
    } else {
        $encrypted_password = encrypt($password, $key);

        try {
            $stmt = $conn->prepare("INSERT INTO login (nombre, apellido, usuario, contraseña) VALUES (:nombre, :apellido, :username, :password)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $encrypted_password);
            $stmt->execute();

            // Redirigir al login con mensaje de éxito
            $_SESSION['success'] = "Usuario registrado exitosamente. Ahora puedes iniciar sesión.";
            header("Location: " . PUBLIC_URL . "/index.php?page=login");
            exit();
        } catch (PDOException $e) {
            $_SESSION['errors'] = ["general" => "Error al registrar usuario: " . $e->getMessage()];
            $_SESSION['old_data'] = $_POST;
            header("Location: " . PUBLIC_URL . "/index.php?page=register");
            exit();
        }
    }
} else {
    header("Location: " . PUBLIC_URL . "/index.php?page=register");
    exit();
}
?>