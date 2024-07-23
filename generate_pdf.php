<?php
require 'fpdf/fpdf.php';
require 'db.php';

if (isset($_GET['cod_factura'])) {
    $cod_factura = $_GET['cod_factura'];

    // Obtener los datos de la factura y del cliente de la base de datos
    try {
        $stmt = $conn->prepare("SELECT factura.*, clientes.nombre, clientes.apellido, clientes.direccion, clientes.sector, clientes.fundador, clientes.uso 
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
    // Datos del cliente y factura
    private $factura;

    public function __construct($factura)
    {
        parent::__construct();
        $this->factura = $factura;
    }

    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('img/logo.png', 10, 8, 33); 
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, 'Recibo de Pago', 0, 0, 'C');
        $this->Ln(20);

        // Tabla con los datos del cliente
        $this->SetFont('Arial', '', 12);
        $this->Cell(40, 10, 'Codigo Factura: ', 1);
        $this->Cell(50, 10, $this->factura['cod_factura'], 1);
        $this->Ln();
        $this->Cell(40, 10, 'Nombre Completo: ', 1);
        $this->Cell(50, 10, $this->factura['nombre'] . ' ' . $this->factura['apellido'], 1);
        $this->Ln();
        $this->Cell(40, 10, 'Direccion: ', 1);
        $this->Cell(50, 10, $this->factura['direccion'], 1);
        $this->Ln();
        $this->Cell(40, 10, 'Sector: ', 1);
        $this->Cell(50, 10, $this->factura['sector'], 1);
        $this->Ln();
        $this->Cell(40, 10, 'Fundador: ', 1);
        $this->Cell(50, 10, $this->factura['fundador'], 1);
        $this->Ln();
        $this->Cell(40, 10, 'Uso: ', 1);
        $this->Cell(50, 10, $this->factura['uso'], 1);
        $this->Ln(20); // Salto de línea
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Información de la factura
    function FacturaInfo()
    {
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Consumo m3: ' . $this->factura['consumo_m3'], 0, 1);
        $this->Cell(0, 10, 'Valor Deuda: $' . number_format($this->factura['valor_deuda'], 2), 0, 1);
        $this->Cell(0, 10, 'Valor Factura: $' . number_format($this->factura['valor_total'], 2), 0, 1);
    }
}

// Crear el PDF
$pdf = new PDF($factura);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->FacturaInfo();
$pdf->Output();
?>
