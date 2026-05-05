<?php
require('fpdf/fpdf.php');
require 'db.php';

if (isset($_GET['cod_factura'])) {
    $cod_factura = $_GET['cod_factura'];

    // Obtener los datos de la factura y del cliente de la base de datos
    try {
        $stmt = $conn->prepare("SELECT factura.*, clientes.* 
                                FROM factura 
                                JOIN clientes ON factura.cod_cliente = clientes.codigo 
                                WHERE factura.cod_factura = ?");
        $stmt->execute([$cod_factura]);
        $factura = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$factura) {
            die("Factura no encontrada.");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("Código de factura no especificado.");
}

class PDF extends FPDF
{
    private $factura;

    public function __construct($factura)
    {
        parent::__construct('L', 'mm', 'Letter'); // Definir el tamaño de la hoja (media carta)
        $this->factura = $factura;
    }

    // Información de la factura
    function datosFactura($x, $y)
    {
        $this->SetXY($x, $y);
        // Logo
        $this->Image('img/logo.png', $x, 5, 30); // 150px de ancho (convertido a mm)  

        // Número de Factura
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(26);
        $this->MultiCell(60, 8, "JUNTA ADMINISTRADORA\nACUEDUCTO ARANDA", 0,'C');
        $this->SetXY($x+85,$y); 
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(43, 8, 'Factura de Agua', 1, 1, 'C');
        $this->SetX($x);
        $this->SetFont('Arial', '', 10);
        $this->Cell(85); // Movernos a la derecha
        $this->Cell(43, 8, 'No: ' . $this->factura['cod_factura'], 1, 1, 'C');
        $this->Ln(2);

        //mensaje datos personales
        $this->SetX($x);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(48);
        $this->Cell(25, 10, 'Datos personales', 0, 1);

        // Información del Cliente
        $this->SetX($x);
        $this->SetFont('Arial', '', 10);
        $this->Cell(100, 6, 'Nombre: ' . utf8_decode($this->factura['nombre']) . ' ' . utf8_decode($this->factura['apellido']), 1);
        $this->Cell(25, 6, utf8_decode('Código: ') . $this->factura['cod_cliente'], 1, 1);

        $this->SetX($x);
        $this->Cell(70, 6, utf8_decode('Dirección: ') . utf8_decode($this->factura['direccion']), 1);
        $this->Cell(25, 6, 'Sector: ' . $this->factura['sector'], 1);
        $this->Cell(30, 6, 'Uso: ' . utf8_decode($this->factura['uso']), 1, 1);

        $this->SetX($x);
        $this->Cell(25, 6, 'Fundador: ' . $this->factura['fundador'], 1);
        $this->Cell(45, 6, 'Medidor No: ' . $this->factura['codigo_medidor'], 1);
        $this->Cell(55, 6, utf8_decode('Diámetro Med: ') . $this->factura['diametro_medidor'], 1, 1);
        $this->Ln(2);

        //Informacion de consumo
        $this->SetX($x);
        $this->Cell(45, 6, 'Lec.Anterior: ' . $this->factura['lectura_inicial'], 1);
        $this->Cell(45, 6, 'Lec.Actual: ' . $this->factura['lectura_final'], 1);
        $this->Cell(35, 6, 'Consumo: ' . $this->factura['consumo_m3'] . ' m3', 1, 1);
        $this->Ln(2);

        $this->SetX($x);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(45);
        $this->Cell(0, 10, 'Conceptos del cobro', 0, 1);

        $this->SetX($x);
        //concepto de porque se cobra
        $this->Cell(75, 6, 'Concepto ', 1, 0);
        $this->Cell(25, 6, 'Unidades ', 1, 0);
        $this->Cell(25, 6, 'Val. Total ', 1, 1);

        $this->SetFont('Arial', '', 10);

        $this->SetX($x);
        $this->Cell(75, 6, utf8_decode('Recaudo Básico '), 1, 0);
        $this->Cell(25, 6, '', 1, 0);
        $this->Cell(25, 6, $this->factura['valor_basico'], 1, 1, 'R');

        $this->SetX($x);
        $this->Cell(75, 6, 'Consumo M3 ', 1, 0);
        $this->Cell(25, 6, $this->factura['consumo_m3'], 1, 0, 'R');
        $this->Cell(25, 6, $this->factura['valor_consumo'], 1, 1, 'R');

        $this->SetX($x);
        $this->Cell(75, 6, 'Deuda ', 1, 0);
        $this->Cell(25, 6, '', 1, 0);
        $this->Cell(25, 6, '' . number_format($this->factura['valor_deuda']), 1, 1, 'R');

        $this->SetX($x);
        $this->Cell(100, 6, 'Valor del recibo ', 1, 0);
        $this->Cell(25, 6, '' . number_format($this->factura['valor_factura']), 1, 1, 'R');
        $this->Ln(4);

        $this->SetX($x);
        $this->Cell(125, 6, 'Anotaciones: ' . $this->factura['Anotaciones'], 1, 1);
        $this->SetX($x);
        $this->Cell(125, 6, utf8_decode('Fecha límite de pago:  ') . $this->factura['fecha_limite_pago'].'  y  '.$this->factura['fecha_limite_pago_2'], 1, 1);
        $this->Ln(4);

        $this->SetX($x);
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(191, 229, 250);
        $this->Cell(100, 6, 'TOTAL A PAGAR ', 1, 0,'l','true');
        $this->Cell(25, 6, '' . number_format($this->factura['valor_total']), 1, 1, 'C','true');
        $this->Ln(5);


        $this->Image('img/gota_feliz.png', $x + 0, 135, 40);
        $this->SetXY(50, 135); // Ajustar la posición para que el texto esté centrado debajo de la imagen
        $this->SetFont('Arial', 'B', 12);
        $this->SetX($x);
        $this->Cell(35);
        $this->MultiCell(40, 6, "EL AGUA ES VIDA\nUNIDOS TODOS\nTRABAJAREMOS PARA\nCUIDARLA", 0, 'C');
        $this->SetXY($x + 75, 135);
        $this->Cell(50, 35, '', 1, 0);

        $this->SetY(-44);
        $this->SetX($x);
        $this->SetFont('Arial', '', 10);
        $this->Cell(80, 6, utf8_decode('Período Facturado De: ') . $this->factura['fecha_inicio_cobro'] . ' A ' . $this->factura['fecha_fin_cobro'], 1);
        $this->Cell(45, 6, 'Mes Facturado: ' . $this->factura['mes_cobrado'], 1, 1);
        $this->SetFont('Arial', 'I', 8);
        $this->Ln(2);
        $this->SetX($x);
        $this->MultiCell(125, 5, utf8_decode("Los pagos se atenderán únicamente en la oficina del acueducto\nHorario de atención al público: sábado de 2 a 6 pm y domingo de 8 a 12pm.\nNúmero del cel. fontanero: 3162507515 - presidente: 3206401175"), 0, 'C');
    }
    function FacturaInfo()
    {
        $this->datosFactura(10, 10);
        $this->SetXY(140, 10);
        $this->Cell(0.1, 182, '', 1, 0);
        $this->datosFactura(145, 10);
    }
}

// Crear el PDF
$pdf = new PDF($factura);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->FacturaInfo();
$pdf->Output('I', 'Factura_' . $factura['cod_factura'] . '_' . $factura['cod_cliente'] . '.pdf');
//$pdf->Output('D', 'Factura_'.$factura['cod_factura'].' ' . $factura['cod_cliente'] . '.pdf');
