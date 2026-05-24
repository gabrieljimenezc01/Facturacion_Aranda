<?php
require_once '../C:\xampp\htdocs\Facturacion_Aranda/app/config/database.php';
require_once '../C:\xampp\htdocs\Facturacion_Aranda/app/includes/encryption.php';
require_once '../C:\xampp\htdocs\Facturacion_Aranda/app/includes/Validator.php';
session_start();

$key = 'secure_key_Facturacion_Aranda'; // Use the same secret key for encryption and decryption

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $username = trim($_POST['user']);
    $password = trim($_POST['password']);
    $special = trim($_POST['special']);
    
    $errors = [];
    $validator = new Validator();
    $validator->validateSpecialPassword($special);
    $validator->validatePassword($password);
    $validator->validateUsername($username);
    $validator->validateName($nombre);
    $validator->validateSurname($apellido);

    if ($validator->hasErrors()) {
        $errors = $validator->getErrors();
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header("Location: register.php");
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

            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
