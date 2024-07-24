<?php
session_start();

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //obtencion de datos
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $username = $_POST['user'];
    $password = $_POST['password'];
    $special = $_POST['special'];
    

    try {
        //Validar contraseña especial
        if($special!='12345'){
            echo'
            <script>
                alert("La clave especial no coincide"); 
            </script>';
            header("location: register.php");
            exit();
        } 

        //Agregar al usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO login (nombre,apellido,usuario,contraseña) VALUES (?,?,?,?)");
        $stmt->execute([$nombre,$apellido,$username,$password]);

        if ($stmt->rowCount()>0) {
                //Iniciar sesion
                $_SESSION['username'] = $username;
                header("location: principal.php");
                exit;
        } else {
            header("location: register.php");
        }
    } catch (PDOException $e) {
        echo json_encode([]);
    }

}

mysqli_close($conexion);

?>