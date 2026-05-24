<?php
require_once '../C:\xampp\htdocs\Facturacion_Aranda/app/config/database.php';

if (isset($_GET['sector'])) {
    $sector = $_GET['sector'];

    $sql = "SELECT orden FROM clientes WHERE sector = :sector ORDER BY orden ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sector', $sector);
    $stmt->execute();
    $ordenes = $stmt->fetchAll(PDO::FETCH_COLUMN); // devuelve array de órdenes

    echo json_encode($ordenes);
} else {
    echo json_encode([]);
}
