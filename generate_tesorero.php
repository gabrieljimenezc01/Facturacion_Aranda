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

        // Calcular total esperado (suma de todos los valores de ingreso)
        $stmt_total_esperado = $conn->prepare("
            SELECT SUM(f.valor_total) AS total_esperado
            FROM factura f
            JOIN clientes c ON f.cod_cliente = c.codigo
            WHERE c.sector = ? AND f.mes_cobrado = ? AND YEAR(f.fecha_inicio_cobro) = ?");
        $stmt_total_esperado->execute([$sector, $mes, $año]);
        $total_esperado = $stmt_total_esperado->fetch(PDO::FETCH_ASSOC)['total_esperado'];

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    class PDF extends FPDF
    {
        function Header()
        {
            // Marco alrededor del encabezado
            $this->Rect(10, 10, 195, 30);
            // Agregar el logo
            $this->Image('img/logo.png', 15, 11, 28);
            $this->SetFont('Arial', 'B', 12);
            // Título
            $this->Cell(30); // Espacio para el logo
            $this->Cell(130, 10, 'Lista de Recaudo', 0, 1, 'C');
            $this->Cell(30);
            $this->Cell(130, 10, 'Empresa de Acueducto | NIT: 814005102-9', 0, 1, 'C');
            $this->Cell(30);
            $this->Cell(130, 10, utf8_decode('Sector: ' . htmlspecialchars($_POST['sector']) . ' | Mes: ' . htmlspecialchars($_POST['mes']) . ' | Año: ' . htmlspecialchars($_POST['año'])), 0, 1, 'C');
            $this->Ln(10); // Salto de línea
        }

        function Footer()
        {
            global $total_esperado;
            // Posición a 1.5 cm del final
            $this->SetY(-30);
            // Marco alrededor del pie de página
            $this->Rect(10, $this->GetY(), 195, 20);
            $this->SetFont('Arial', 'I', 12);
            // Número de página
            $this->Cell(95, 20, 'Pagina ' . $this->PageNo(), 0, 0, 'L');
            // Total esperado
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(95, 20, 'Total Esperado: ' . number_format($total_esperado, 2), 0, 1, 'R');
        }

        function ImprovedTable($header, $data)
        {
            // Anchuras de las columnas
            $w = array(15, 40, 40, 15, 15, 25, 25, 20);
            // Cabeceras
            $this->SetFont('Arial', 'B', 10);
            for ($i = 0; $i < count($header); $i++) {
                $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
            }
            $this->Ln();
            // Datos
            $this->SetFont('Arial', '', 10);
            foreach ($data as $row) {
                $this->CheckPageBreak($header);
                // Ajustar altura de la fila en función del contenido más grande
                $maxHeight = $this->getMaxRowHeight($w, $row);
                $this->Cell($w[0], $maxHeight, $row['codigo'], 'LR', 0, 'C');
                $this->Cell($w[1], 6, utf8_decode($row['nombre']), 'LR', 0, 'C');
                $this->Cell($w[2], 6, utf8_decode($row['apellido']), 'LR', 0, 'C');
                $this->Cell($w[3], $maxHeight, $row['factura'], 'LR', 0, 'C');
                $this->Cell($w[4], $maxHeight, $row['m3'], 'LR', 0, 'C');
                $this->Cell($w[5], $maxHeight, $row['valor_ingreso'], 'LR', 0, 'C');
                $this->Cell($w[6], $maxHeight, $row['deuda'], 'LR', 0, 'C');
                $this->Cell($w[7], $maxHeight, $row['fundador'], 'LR', 0, 'C');
                $this->Ln();
            }
            // Línea de cierre
            $this->Cell(array_sum($w), 0, '', 'T');
            $this->Ln(10);
        }

        function CheckPageBreak($header)
        {
            // Si la altura del contenido supera la altura de la página, añade una nueva página
            if ($this->GetY() > 240) {
                $this->AddPage();
                $this->SetFont('Arial', 'B', 10);
                // Anchuras de las columnas
                $w = array(15, 40, 40, 15, 15, 25, 25, 20);
                // Cabeceras
                for ($i = 0; $i < count($header); $i++) {
                    $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
                }
                $this->Ln();
                $this->SetFont('Arial', '', 10); // Mantener el mismo estilo de fuente para el contenido
            }
        }

        function getMaxRowHeight($w, $row)
        {
            // Calcular la altura de la fila en función del contenido más grande
            $maxHeight = 6; // Altura mínima de la fila
            $this->SetFont('Arial', '', 10);
            foreach ($row as $key => $col) {
                $numLines = $this->NbLines($w[array_search($key, array_keys($row))], $col);
                $maxHeight = max($maxHeight, $numLines * 6);
            }
            return $maxHeight;
        }

        function NbLines($w, $txt)
        {
            // Calcular el número de líneas que ocupa un texto
            $cw = &$this->CurrentFont['cw'];
            if ($w == 0)
                $w = $this->w - $this->rMargin - $this->x;
            $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
            $s = str_replace("\r", '', $txt);
            $nb = strlen($s);
            if ($nb > 0 and $s[$nb - 1] == "\n")
                $nb--;
            $sep = -1;
            $i = 0;
            $j = 0;
            $l = 0;
            $nl = 1;
            while ($i < $nb) {
                $c = $s[$i];
                if ($c == "\n") {
                    $i++;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $nl++;
                    continue;
                }
                if ($c == ' ')
                    $sep = $i;
                $l += $cw[$c];
                if ($l > $wmax) {
                    if ($sep == -1) {
                        if ($i == $j)
                            $i++;
                    } else
                        $i = $sep + 1;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $nl++;
                } else
                    $i++;
            }
            return $nl;
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
