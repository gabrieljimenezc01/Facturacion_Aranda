<?php
require('fpdf/fpdf.php');
require 'db.php';

if (isset($_GET['cod_abono'])) {
    $cod_abono = $_GET['cod_abono'];
    // Obtener los datos del abono y del cliente de la base de datos
    try {
        $stmt = $conn->prepare("SELECT deudores.valor_total 
        FROM deudores JOIN abonos 
        ON deudores.cod_cliente=abonos.cod_cliente 
        WHERE abonos.cod_abono = ? ");
        $stmt->execute([$cod_abono]);
        $deuda = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($deuda) {
        $stmt = $conn->prepare("SELECT abonos.*, clientes.*, deudores.valor_total
        FROM abonos JOIN clientes JOIN deudores
        ON abonos.cod_cliente= clientes.codigo 
        AND deudores.cod_cliente=abonos.cod_cliente 
        WHERE abonos.cod_abono = ?");
        $stmt->execute([$cod_abono]);
        $abono = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$abono) {
            die("Abono no encontrado.");
        }
        } else {
            $stmt = $conn->prepare("SELECT abonos.*, clientes.*
            FROM abonos JOIN clientes
            ON abonos.cod_cliente= clientes.codigo 
            WHERE abonos.cod_abono = ?");
            $stmt->execute([$cod_abono]);
            $abono = $stmt->fetch(PDO::FETCH_ASSOC);
            $abono['valor_total'] = 0;
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("Código de abono no especificado.");
}

class PDF extends FPDF
{
    private $abono;

    public function __construct($abono)
    {
        parent::__construct('L', 'mm', array(140, 216)); // Definir el tamaño de la hoja (media carta)
        $this->abono = $abono;
    }
    function Header()
    {
        $this->Image('img/logo.png', 22, 5, 30); // 150px de ancho (convertido a mm)  
        
        // Número de abono
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(25);
        $this->MultiCell(150,8,"JUNTA ADMINISTRADORA\nACUEDUCTO ARANDA",0,'C'); 
        $this->SetXY(160,10);
        $this->Cell(43, 8, 'Nota de ingreso', 1, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(150); // Movernos a la derecha
        $this->Cell(43, 8, 'No: ' . $this->abono['cod_abono'], 1, 1, 'C');
        $this->Ln(2);
        
        //mensaje datos personales
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 10, 'Datos personales' ,0, 1,'C');

        // Información del Cliente
        $this->SetFont('Arial', '', 10);
        $this->Cell(25);
        $this->Cell(110, 6, 'Nombre: ' . utf8_decode($this->abono['nombre']) . ' ' .utf8_decode($this->abono['apellido']), 1);
        $this->Cell(35, 6, utf8_decode('Código: ') . $this->abono['cod_cliente'] , 1, 1);
        $this->Cell(25);
        $this->Cell(70, 6, utf8_decode('Dirección: '). utf8_decode($this->abono['direccion']), 1);
        $this->Cell(25, 6, 'Sector: ' . $this->abono['sector'], 1);
        $this->Cell(20, 6, 'Estrato: ' . $this->abono['estrato'], 1);
        $this->Cell(30, 6, 'Uso: ' . utf8_decode($this->abono['uso']), 1,1);
        $this->Cell(25);
        $this->Cell(30, 6, 'Fundador:  ' . $this->abono['fundador'] , 1);
        $this->Cell(55, 6, 'Medidor No: ' . $this->abono['codigo_medidor'] , 1);
        $this->Cell(60, 6, utf8_decode('Diámetro Med: ') . $this->abono['diametro_medidor'] , 1,1);
        $this->Ln(5);
       
    }

    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 6, utf8_decode('Página') . $this->PageNo() . '/{nb}', 0, 1, 'C');
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(0,6,utf8_decode('fecha de impresión  ').date('d/m/y'),0,1,'C');
    }
    // Información de la abono
    function abonoInfo()
    {
        $this->SetFont('Arial', '', 9);
        $this->Cell(25);
        $this->Cell(85,6,'Fecha de ingreso: ',1,0);
        $this->Cell(60,6, date($this->abono['fecha']) ,1,1,'C');

        $this->Cell(0,8,'Concepto de ingreso',0,1,'C');

        $this->SetFont('Arial', '', 10);
        $this->Cell(25);
        $this->Cell(145, 6, 'DATOS', 1,1,'C');
        $this->Cell(25);
        $this->Cell(110, 6,' '. $this->abono['concepto'] ,1, 0);
        $this->Cell(35,6,number_format($this->abono['valor']),1,1,'R');
        $this->Ln(10);
        $this->Cell(25);
        $this->Cell(100,6,'valor del abono:','LTB',0);
        $this->Cell(45,6,number_format($this->abono['valor']),'RTB',1,'C');
        $this->Cell(25);
        $this->Cell(100,6,'valor de la deuda:','LTB',0);
        $this->Cell(45,6,number_format($this->abono['valor_total']),'RTB',1,'C');

    }
}

// Crear el PDF
$pdf = new PDF($abono);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->abonoInfo();
$pdf->Output('I','Nota_de_ingreso_'.$abono['cod_abono'].'_'.$abono['cod_cliente'].'.pdf');
//$pdf->Output('D', 'abono_'.$abono['cod_abono'].' ' . $abono['cod_cliente'] . '.pdf');
