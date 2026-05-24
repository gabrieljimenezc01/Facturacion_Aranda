<?php
// authenticate.php - Versión corregida para la nueva estructura

// Cargar configuración central (esto reemplaza los require individuales)
require_once dirname(__DIR__, 2) . '/config/app.php';

// Asegurar conexión a base de datos
if (!isset($conn)) {
    require_once APP_PATH . '/config/database.php';
}

session_start();

$key = 'secure_key_Facturacion_Aranda';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['user']);
    $password = trim($_POST['password']);
    
    $validator = new Validator();
    $validator->validateUsername($username)
              ->validatePassword($password);

    if ($validator->hasErrors()) {
        $_SESSION['errors'] = $validator->getErrors();
        $_SESSION['old_data'] = $_POST;
        header("Location: " . PUBLIC_URL . "/index.php?page=login");
        exit();
    } else {
        $stmt = $conn->prepare("SELECT usuario, contraseña FROM login WHERE usuario = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && decrypt($user['contraseña'], $key) === $password) {
            $_SESSION['user'] = $user['usuario'];
            $_SESSION['password'] = $user['contraseña'];
            header("Location: " . PUBLIC_URL . "/index.php?page=dashboard");
            exit();
        } else {
            $_SESSION['errors'] = ["general" => "Usuario o contraseña incorrectos."];
            $_SESSION['old_data'] = $_POST;
            header("Location: " . PUBLIC_URL . "/index.php?page=login");
            exit();
        }
    }
}
?>