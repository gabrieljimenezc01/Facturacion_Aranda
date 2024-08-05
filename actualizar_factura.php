<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores enviados desde el formulario
    $cod_factura = $_POST['cod_factura'];
    $lectura_anterior = $_POST['lectura-anterior'];
    $lectura_actual = $_POST['lectura-actual'];
    $consumo = $_POST['consumo'];
    $valor_base = $_POST['valor_basico'];
    $valor_consumo = $_POST['valor_consumo'];
    $valor_factura = $_POST['valor_factura'];
    $valor_total = $_POST['total'];
    $anotaciones = $_POST['anotaciones'];

    // Validar los datos según sea necesario
    if ($lectura_anterior > $lectura_actual) {
        die('La lectura actual debe ser mayor que la lectura anterior.');
    }

    // Actualizar la factura en la base de datos
    $query = "UPDATE factura SET 
                lectura_inicial = :lectura_anterior,
                lectura_final = :lectura_actual,
                consumo_m3 = :consumo,
                valor_total = :valor_total,
                valor_consumo = :valor_consumo,
                valor_basico = :valor_base,
                valor_factura = :valor_factura,
                Anotaciones = :anotaciones
              WHERE cod_factura = :cod_factura";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':lectura_anterior', $lectura_anterior);
    $stmt->bindParam(':lectura_actual', $lectura_actual);
    $stmt->bindParam(':consumo', $consumo);
    $stmt->bindParam(':valor_total', $valor_total);
    $stmt->bindParam(':valor_base', $valor_base);
    $stmt->bindParam(':valor_consumo', $valor_consumo);
    $stmt->bindParam(':valor_factura', $valor_factura);
    $stmt->bindParam(':anotaciones', $anotaciones);
    $stmt->bindParam(':cod_factura', $cod_factura);

    if ($stmt->execute()) {
        // Redirigir al usuario o mostrar un mensaje de éxito
        header('Location: modificar_factura.php?success=1');
        exit;
    } else {
        die('Error al actualizar la factura.');
    }
}
?>
