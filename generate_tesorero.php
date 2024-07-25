<?php
require('fpdf/fpdf.php');
require 'db.php'; // Asegúrate de que este archivo contiene la configuración de la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sector = $_POST['sector'];
    $mes = $_POST['mes'];
    $año = $_POST['año'];

    // Obtener los datos de la base de datos
    try {
        $stmt = $conn->prepare("
            SELECT c.codigo, c.nombre, c.apellido, f.cod_factura AS factura, f.consumo_m3 AS m3, f.valor_total AS valor_ingreso, f.valor_deuda AS deuda, c.fundador
            FROM clientes c
            JOIN factura f ON c.codigo = f.cod_cliente
            WHERE c.sector = ? AND f.mes_cobrado = ? AND YEAR(f.fecha_inicio_cobro) = ?");
        $stmt->execute([$sector, $mes, $año]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$data) {
            die("No se encontraron datos para el sector, mes y año especificados.");
        }

        // Calcular total recaudado
        $stmt_total_recaudado = $conn->prepare("
            SELECT SUM(f.valor_total) AS total_recaudado
            FROM factura f
            JOIN clientes c ON f.cod_cliente = c.codigo
            WHERE c.sector = ? AND f.mes_cobrado = ? AND YEAR(f.fecha_inicio_cobro) = ? AND f.estado_pago = 'si'");
        $stmt_total_recaudado->execute([$sector, $mes, $año]);
        $total_recaudado = $stmt_total_recaudado->fetch(PDO::FETCH_ASSOC)['total_recaudado'];

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    class PDF extends FPDF
    {
        function Header()
        {
            // Marco alrededor del encabezado
            $this->Rect(10, 10, 190, 30);
            // Agregar el logo
            $this->Image('img/logo.png', 15, 15, 20);
            $this->SetFont('Arial', 'B', 12);
            // Título
            $this->Cell(30); // Espacio para el logo
            $this->Cell(130, 10, 'Lista de Recaudo', 0, 1, 'C');
            $this->Cell(30);
            $this->Cell(130, 10, 'Empresa de Acueducto | NIT: 123456789', 0, 1, 'C');
            $this->Cell(30);
            $this->Cell(130, 10, 'Sector: ' . htmlspecialchars($_POST['sector']) . ' | Mes: ' . htmlspecialchars($_POST['mes']) . ' | Año: ' . htmlspecialchars($_POST['año']), 0, 1, 'C');
            $this->Ln(10); // Salto de línea
        }

        function Footer()
        {
            global $total_recaudado;
            // Posición a 1.5 cm del final
            $this->SetY(-30);
            // Marco alrededor del pie de página
            $this->Rect(10, $this->GetY(), 190, 20);
            $this->SetFont('Arial', 'I', 12);
            // Número de página
            $this->Cell(95, 20, 'Pagina ' . $this->PageNo(), 0, 0, 'L');
            // Total recaudado
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(95, 20, 'Total Recaudado: ' . number_format($total_recaudado, 2), 0, 1, 'R');
        }

        function ImprovedTable($header, $data)
        {
            // Anchuras de las columnas
            $w = array(20, 30, 30, 20, 15, 30, 30, 20);
            // Cabeceras
            for ($i = 0; $i < count($header); $i++) {
                $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
            }
            $this->Ln();
            // Datos
            foreach ($data as $row) {
                $this->CheckPageBreak($header);
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

        function CheckPageBreak($header)
        {
            // If the height of the content surpasses the page height, add a new page
            if($this->GetY() > 240)
            {
                $this->AddPage();
                $this->SetFont('Arial', 'B', 10);
                // Anchuras de las columnas
                $w = array(20, 30, 30, 20, 15, 30, 30, 20);
                // Cabeceras
                for ($i = 0; $i < count($header); $i++) {
                    $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
                }
                $this->Ln();
            }
        }
    }

    // Crear el PDF
    $pdf = new PDF('P', 'mm', 'Letter');
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    // Cabeceras de la tabla
    $header = ['Codigo', 'Nombre', 'Apellido', 'Factura', 'M3', 'Valor Ingreso', 'Deuda', 'Fundador'];
    // Datos de la tabla
    $pdf->ImprovedTable($header, $data);

    // Generar el PDF
    $pdf->Output('I', 'lista_recaudo.pdf');
}
?>
