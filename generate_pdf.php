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
        parent::__construct('P', 'mm', array(140, 216)); // Definir el tamaño de la hoja (media carta)
        $this->factura = $factura;
    }

    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('img/logo.png', 22, 5, 30); // 150px de ancho (convertido a mm)   
        
        // Número de Factura
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(80); // Movernos a la derecha
        $this->Cell(43, 8, 'Factura de Agua', 1, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(80); // Movernos a la derecha
        $this->Cell(43, 8, 'No: ' . $this->factura['cod_factura'], 1, 1, 'C');
        $this->Ln(2);
        
        //mensaje
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(48);
        $this->Cell(25, 10, 'Datos personales' ,0, 1);

        // Información del Cliente
        $this->SetFont('Arial', '', 10);
        $this->Cell(100, 6, 'Nombre: ' . $this->factura['nombre'] . ' ' . $this->factura['apellido'], 1);
        $this->Cell(25, 6, 'Código: ' . $this->factura['cod_cliente'] , 1, 1);

        $this->Cell(70, 6, 'Direccion: ' . $this->factura['direccion'], 1);
        $this->Cell(25, 6, 'Sector: ' . $this->factura['sector'], 1);
        $this->Cell(30, 6, 'Uso: ' . $this->factura['uso'], 1,1);

        $this->Cell(25, 6, 'Fundador: ' . $this->factura['fundador'] , 1);
        $this->Cell(45, 6, 'Medidor No: ' . $this->factura['codigo_medidor'] , 1);
        $this->Cell(55, 6, 'Diametro Med: ' . $this->factura['diametro_medidor'] , 1,1);
        $this->Ln(2);
        
        //Informacion de consumo
        $this->Cell(45, 6, 'Lec.Anterior: ' . $this->factura['lectura_inicial'] , 1);
        $this->Cell(45, 6, 'Lec.Actual: ' . $this->factura['lectura_final'] , 1);
        $this->Cell(35, 6, 'Consumo: ' . $this->factura['consumo_m3'].' m3' , 1,1);
        $this->Ln(2);

    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-25);
        $this->SetFont('Arial', '', 10);
        $this->Cell(80, 6, 'Periodo Facturado De: ' . $this->factura['fecha_inicio_cobro'].' A '. $this->factura['fecha_fin_cobro'], 1);
        $this->Cell(45, 6, 'Mes Facturado: ' . $this->factura['mes_cobrado'], 1,1);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Información de la factura
    function FacturaInfo()
    {
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(45);
        $this->Cell(0, 10, 'Conceptos del cobro' , 0, 1);
        //concepto de porque se cobra
        $this->Cell(65, 6, 'Concepto ', 1, 0);
        $this->Cell(20, 6, 'Unidades ', 1, 0);
        $this->Cell(20, 6, 'Val.Unit ', 1, 0);
        $this->Cell(20, 6, 'Val.Total ', 1, 1);

        $this->SetFont('Arial', '', 10);

        $this->Cell(65, 6, 'Recaudo Basico ', 1, 0);
        $this->Cell(20, 6, '', 1, 0);
        $this->Cell(20, 6, '', 1, 0);
        $this->Cell(20, 6, '', 1, 1);

        $this->Cell(65, 6, 'Consumo M3 ', 1, 0);
        $this->Cell(20, 6, ''. $this->factura['consumo_m3'], 1, 0);
        $this->Cell(20, 6, ' ', 1, 0);
        $this->Cell(20, 6, ' ', 1, 1);

        $this->Cell(65, 6, 'Deuda ', 1, 0);
        $this->Cell(20, 6, ' ', 1, 0);
        $this->Cell(20, 6, ' ', 1, 0);
        $this->Cell(20, 6, ''. $this->factura['valor_deuda'], 1, 1);
        
        $this->Cell(105, 6, 'Total a Pagar ', 1, 0);
        $this->Cell(20, 6, ''. $this->factura['valor_total'], 1, 1);
        $this->Ln(8);

        $this->Cell(125, 6, 'Anotaciones: '. $this->factura['Anotaciones'], 1, 1);
        $this->Cell(125, 6, 'Valor ultimo pago: '. $this->factura['valor_ultima_factura'], 1, 1);
        $this->Cell(125, 6, 'Fecha limite de pago: '. $this->factura['fecha_limite_pago'], 1, 1);
        $this->Ln(8);

        $this->Cell(105, 6, 'Total a Pagar ', 1, 0);
        $this->Cell(20, 6, ''. $this->factura['valor_total'], 1, 1);
        $this->Ln(10);

        $this->Image('img/gota_feliz.png', 10, 155, 40); // 150px de ancho (convertido a mm)
        $this->Cell(39);
        $this->Cell(40, 6, 'EL AGUA ES VIDA', 0, 1,'C'); 
        $this->Cell(39);
        $this->Cell(40, 6, 'UNIDOS TODOS', 0, 1,'C');
        $this->Cell(39);
        $this->Cell(40, 6, 'TRABAJAREMOS PARA', 0, 1,'C');
        $this->Cell(39);
        $this->Cell(40, 6, 'CUIDARLA', 0, 0,'C');
        

       /* $this->Cell(0, 10, 'Lectura Anterior: ' . $this->factura['lectura_inicial'], 0, 1);
        $this->Cell(0, 10, 'Lectura Actual: ' . $this->factura['lectura_final'], 0, 1);
        $this->Cell(0, 10, 'Valor m3: $' . number_format($this->factura['valor_total'], 2), 0, 1);
        $this->Cell(0, 10, 'Valor Deuda: $' . number_format($this->factura['valor_deuda'], 2), 0, 1);
        $this->Cell(0, 10, 'Valor Factura: $' . number_format($this->factura['valor_total'], 2), 0, 1);*/
    }
}

// Crear el PDF
$pdf = new PDF($factura);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->FacturaInfo();
$pdf->Output();
?>
