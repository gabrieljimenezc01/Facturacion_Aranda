<?php
require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $list_type = $_POST['list_type'];
    $sector = $_POST['sector'];
    $mes = $_POST['mes'];
    $año = $_POST['año'];

    // Reemplaza con la lógica para obtener los datos reales de la base de datos
    $data = [
        ['001', 'Juan', 'Perez', '1001', '15', '15000', '5000', 'No'],
        ['002', 'Maria', 'Lopez', '1002', '10', '10000', '2000', 'Si'],
        // Añade más datos según sea necesario
    ];

    // Generar contenido HTML para el PDF
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            .header {
                display: flex;
                align-items: center;
                padding: 10px;
                background-color: #f1f1f1;
            }

            .header img {
                max-width: 80px;
                margin-right: 20px;
            }

            .header div {
                text-align: center;
                flex-grow: 1;
            }

            .header h1 {
                margin: 5px 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }

            th,
            td {
                padding: 8px;
                text-align: left;
            }

            .footer {
                text-align: center;
                padding: 10px;
                background-color: #f1f1f1;
                position: fixed;
                bottom: 0;
                width: 100%;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <img src="img/logo.png" alt="Logo de la Empresa9">
            <div>
                <h1>Lista de Recaudo para <?php echo ucfirst($list_type); ?></h1>
                <p>Empresa de Acueducto | NIT: 123456789</p>
                <p>Sector: <?php echo htmlspecialchars($sector); ?> | Mes: <?php echo htmlspecialchars($mes); ?> | Año:
                    <?php echo htmlspecialchars($año); ?></p>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Factura</th>
                    <th>M3</th>
                    <th>Valor Ingreso</th>
                    <th>Deuda</th>
                    <th>Fundador</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row[0]); ?></td>
                        <td><?php echo htmlspecialchars($row[1]); ?></td>
                        <td><?php echo htmlspecialchars($row[2]); ?></td>
                        <td><?php echo htmlspecialchars($row[3]); ?></td>
                        <td><?php echo htmlspecialchars($row[4]); ?></td>
                        <td><?php echo htmlspecialchars($row[5]); ?></td>
                        <td><?php echo htmlspecialchars($row[6]); ?></td>
                        <td><?php echo htmlspecialchars($row[7]); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="footer">
            <p>Footer con información adicional</p>
        </div>
    </body>

    </html>
    <?php
    $html = ob_get_clean();

    // Inicializar DOMPDF y generar el PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('letter', 'portrait'); // Ajustar el tamaño del papel a carta
    $dompdf->render();
    $dompdf->stream('lista_recaudo.pdf', ['Attachment' => 0]);
}
?>