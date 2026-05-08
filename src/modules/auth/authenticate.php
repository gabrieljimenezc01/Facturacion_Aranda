<?php
require_once '../../config/db.php';
require_once '../../includes/encryption.php';
require_once '../../includes/Validator.php';

session_start();

$key = 'secure_key_Facturacion_Aranda'; // Use the same secret key for encryption and decryption

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['user']);
    $password = trim($_POST['password']);
    
    $validator = new Validator();
    $validator->validateUsername($username)
              ->validatePassword($password);

    if ($validator->hasErrors()) {
        $_SESSION['errors'] = $validator->getErrors();
        $_SESSION['old_data'] = $_POST;
        header("Location: login.php");
        exit();
    } else {
        $stmt = $conn->prepare("SELECT usuario, contraseña FROM login WHERE usuario = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && decrypt($user['contraseña'], $key) === $password) {
            $_SESSION['user'] = $user['usuario'];
            $_SESSION['password'] = $user['contraseña'];
            header("Location: ../reportes/principal.php");
            exit();
        } else {
            $_SESSION['errors'] = ["general" => "Usuario o contraseña incorrectos."];
            $_SESSION['old_data'] = $_POST;
            header("Location: login.php");
            exit();
        }
    }
}
?>
