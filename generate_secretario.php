<?php
require('fpdf/fpdf.php');
require 'db.php'; // Asegúrate de que este archivo contiene la configuración de la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sector = $_POST['sector'];
    $mes = $_POST['mes'];
    $año = $_POST['año'];

    // Obtener los datos de la base de datos
    try {
        // Clientes que no han pagado
        $stmt_no_pagados = $conn->prepare("
            SELECT c.codigo, c.nombre, c.apellido, f.cod_factura AS factura, f.consumo_m3 AS m3, f.valor_total AS valor_ingreso, f.valor_deuda AS deuda, c.fundador
            FROM clientes c
            JOIN factura f ON c.codigo = f.cod_cliente
            WHERE c.sector = ? AND f.mes_cobrado = ? AND YEAR(f.fecha_inicio_cobro) = ? AND f.estado_pago = 'no'");
        $stmt_no_pagados->execute([$sector, $mes, $año]);
        $no_pagados = $stmt_no_pagados->fetchAll(PDO::FETCH_ASSOC);

        // Clientes que han pagado
        $stmt_pagados = $conn->prepare("
            SELECT c.codigo, c.nombre, c.apellido, f.cod_factura AS factura, f.consumo_m3 AS m3, f.valor_total AS valor_ingreso, f.valor_deuda AS deuda, c.fundador
            FROM clientes c
            JOIN factura f ON c.codigo = f.cod_cliente
            WHERE c.sector = ? AND f.mes_cobrado = ? AND YEAR(f.fecha_inicio_cobro) = ? AND f.estado_pago = 'si'");
        $stmt_pagados->execute([$sector, $mes, $año]);
        $pagados = $stmt_pagados->fetchAll(PDO::FETCH_ASSOC);

        // Calcular total recaudado
        $stmt_total_recaudado = $conn->prepare("
            SELECT SUM(f.valor_total) AS total_recaudado
            FROM factura f
            JOIN clientes c ON f.cod_cliente = c.codigo
            WHERE c.sector = ? AND f.mes_cobrado = ? AND YEAR(f.fecha_inicio_cobro) = ? AND f.estado_pago = 'si'");
        $stmt_total_recaudado->execute([$sector, $mes, $año]);
        $total_recaudado = $stmt_total_recaudado->fetch(PDO::FETCH_ASSOC)['total_recaudado'];

        // Calcular total de la deuda
        $stmt_total_deuda = $conn->prepare("
            SELECT SUM(f.valor_deuda) AS total_deuda
            FROM factura f
            JOIN clientes c ON f.cod_cliente = c.codigo
            WHERE c.sector = ? AND f.mes_cobrado = ? AND YEAR(f.fecha_inicio_cobro) = ? AND f.estado_pago = 'no'");
        $stmt_total_deuda->execute([$sector, $mes, $año]);
        $total_deuda = $stmt_total_deuda->fetch(PDO::FETCH_ASSOC)['total_deuda'];

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    class PDF extends FPDF
    {
        function Header()
        {
            // Agregar el logo
            $this->Image('img/logo.png', 10, 10, 30);
            $this->SetFont('Arial', 'B', 12);
            // Título
            $this->Cell(40); // Espacio para el logo
            $this->Cell(100, 10, 'Lista de Recaudo', 0, 1, 'C');
            $this->Cell(40);
            $this->Cell(100, 10, 'Empresa de Acueducto | NIT: 123456789', 0, 1, 'C');
            $this->Cell(40);
            $this->Cell(100, 10, 'Sector: ' . htmlspecialchars($_POST['sector']) . ' | Mes: ' . htmlspecialchars($_POST['mes']) . ' | Año: ' . htmlspecialchars($_POST['año']), 0, 1, 'C');
            $this->Ln(10); // Salto de línea
        }

        function Footer()
        {
            // Posición a 1.5 cm del final
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            // Número de página
            $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
        }

        function ImprovedTable($header, $data, $title)
        {
            // Mostrar título
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 10, $title, 0, 1, 'C');
            $this->SetFont('Arial', 'B', 10);

            // Anchuras de las columnas
            $w = array(20, 30, 30, 20, 15, 30, 30, 20);
            // Cabeceras
            for ($i = 0; $i < count($header); $i++) {
                $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
            }
            $this->Ln();
            // Datos
            foreach ($data as $row) {
                $this->Cell($w[0], 6, $row['codigo'], 'LR', 0, 'C');
                $this->Cell($w[1], 6, $row['nombre'], 'LR', 0, 'C');
                $this->Cell($w[2], 6, $row['apellido'], 'LR', 0, 'C');
                $this->Cell($w[3], 6, $row['factura'], 'LR', 0, 'C');
                $this->Cell($w[4], 6, $row['m3'], 'LR', 0, 'C');
                $this->Cell($w[5], 6, $row['valor_ingreso'], 'LR', 0, 'C');
                $this->Cell($w[6], 6, $row['deuda'], 'LR', 0, 'C');
                $this->Cell($w[7], 6, $row['fundador'], 'LR', 0, 'C');
                $this->Ln();
            }
            // Línea de cierre
            $this->Cell(array_sum($w), 0, '', 'T');
            $this->Ln(10);
        }
    }

    // Crear el PDF
    $pdf = new PDF('P', 'mm', 'Letter');
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    // Cabeceras de la tabla
    $header = ['Codigo', 'Nombre', 'Apellido', 'Factura', 'M3', 'Valor Ingreso', 'Deuda', 'Fundador'];
    // Datos de la tabla
    $pdf->ImprovedTable($header, $pagados, 'Clientes que han pagado');
    $pdf->ImprovedTable($header, $no_pagados, 'Clientes que no han pagado');

    // Mostrar total recaudado
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Total Recaudado: ' . number_format($total_recaudado, 2), 0, 1, 'C');

    // Mostrar total de la deuda
    $pdf->Cell(0, 10, 'Total Deuda: ' . number_format($total_deuda, 2), 0, 1, 'C');

    // Generar el PDF
    $pdf->Output('I', 'lista_recaudo_secretario.pdf');
}
?>
