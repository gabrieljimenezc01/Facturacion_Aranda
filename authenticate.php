<?php
require 'db.php';
require 'encryption.php'; // Include encryption functions
session_start();

$key = 'secure_key_Facturacion_Aranda'; // Use the same secret key for encryption and decryption

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user'];
    $password = $_POST['password'];

    echo "usuario y contraseña: ".$username ." ". $password;

    $stmt = $conn->prepare("SELECT usuario, contraseña FROM login WHERE usuario = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && decrypt($user['contraseña'], $key) === $password) {
        $_SESSION['user'] = $user['usuario'];
        $_SESSION['password'] = $user['contraseña'];
        header("Location: principal.php");
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
        header("Location: login.php");
    }
}
?>
