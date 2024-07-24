<?php
session_start();

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //obtencion de datos
    $username = $_POST['user'];
    $password = $_POST['password'];

    try {
        //buscar el usuario en la base de datos
        $stmt = $conn->prepare("SELECT * FROM login WHERE usuario = ? AND contraseña = ?");
        $stmt->execute([$username, $password]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            //verificar contraseña

            if ($password == $usuario['contraseña']) {
                //Iniciar sesion
                $_SESSION['username'] = $username;
                header("location: principal.php");
                exit;
            }
        } else {
            header("location: login.php");
        }
    } catch (PDOException $e) {
        echo json_encode([]);
    }

}

mysqli_close($conexion);

?>