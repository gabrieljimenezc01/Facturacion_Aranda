<?php
require 'db.php';
require 'encryption.php'; // Include encryption functions

$key = 'secure_key_Facturacion_Aranda'; // Use the same secret key for encryption and decryption

// Datos de los usuarios a crear

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $username = $_POST['user'];
    $password = $_POST['password'];
    $special = $_POST['special'];
    //encriptar clave
    $encrypted_password = encrypt($password, $key);

    try {
        //validar la clave especial
        if($special!='12345'){
             header("location: login.php"); 
           
        } else{
            // insercion del nuevo usuario a la tabla login
            try {
                    $stmt = $conn->prepare("INSERT INTO login (nombre, apellido, usuario, contraseña) VALUES (:nombre, :apellido, :username, :password)");
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':apellido', $apellido);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $encrypted_password);
                    $stmt->execute();
                
                header("location: principal.php");
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

        }

    } catch (PDOException $e) {
        echo json_encode([]);
    }
}
?>