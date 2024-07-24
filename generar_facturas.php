<?php
require('fpdf/fpdf.php');
require 'db.php';

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
        $this->Image('img/logo.png', $x + 22, 5, 30); // 150px de ancho (convertido a mm)  

        // Número de Factura
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(80, 8, '', 0, 0); // Movernos a la derecha
        $this->Cell(43, 8, 'Factura de Agua', 1, 1, 'C');
        $this->SetX($x);
        $this->SetFont('Arial', '', 10);
        $this->Cell(80); // Movernos a la derecha
        $this->Cell(43, 8, 'No: ' . $this->factura['cod_factura'], 1, 1, 'C');
        $this->Ln(2);

        //mensaje
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
        $this->Cell(65, 6, 'Concepto ', 1, 0);
        $this->Cell(20, 6, 'Unidades ', 1, 0);
        $this->Cell(20, 6, 'Val. Unit ', 1, 0);
        $this->Cell(20, 6, 'Val. Total ', 1, 1);

        $this->SetFont('Arial', '', 10);

        $this->SetX($x);
        $this->Cell(65, 6, utf8_decode('Recaudo Básico '), 1, 0);
        $this->Cell(20, 6, '', 1, 0);
        $this->Cell(20, 6, '', 1, 0);
        $this->Cell(20, 6, '', 1, 1);

        $this->SetX($x);
        $this->Cell(65, 6, 'Consumo M3 ', 1, 0);
        $this->Cell(20, 6, '' . $this->factura['consumo_m3'], 1, 0);
        $this->Cell(20, 6, ' ', 1, 0);
        $this->Cell(20, 6, ' ', 1, 1);

        $this->SetX($x);
        $this->Cell(65, 6, 'Deuda ', 1, 0);
        $this->Cell(20, 6, ' ', 1, 0);
        $this->Cell(20, 6, ' ', 1, 0);
        $this->Cell(20, 6, '' . number_format($this->factura['valor_deuda']), 1, 1);

        $this->SetX($x);
        $this->Cell(105, 6, 'Total a Pagar ', 1, 0);
        $this->Cell(20, 6, '' . number_format($this->factura['valor_total']), 1, 1);
        $this->Ln(8);

        $this->SetX($x);
        $this->Cell(125, 6, 'Anotaciones: ' . $this->factura['Anotaciones'], 1, 1);
        $this->SetX($x);
        $this->Cell(125, 6, utf8_decode('Valor último pago: ') . number_format($this->factura['valor_ultima_factura']), 1, 1);
        $this->SetX($x);
        $this->Cell(125, 6, utf8_decode('Fecha límite de pago: ') . $this->factura['fecha_limite_pago'], 1, 1);
        $this->Ln(8);

        $this->SetX($x);
        $this->Cell(105, 6, 'Total a Pagar ', 1, 0);
        $this->Cell(20, 6, '' . number_format($this->factura['valor_total']), 1, 1);
        $this->Ln(10);


        $this->Image('img/gota_feliz.png', $x + 8, 148, 40);
        $this->SetXY(50, 150); // Ajustar la posición para que el texto esté centrado debajo de la imagen
        $this->SetFont('Arial', 'B', 12);
        $this->SetX($x);
        $this->Cell(45);
        $this->MultiCell(40, 6, "EL AGUA ES VIDA\nUNIDOS TODOS\nTRABAJAREMOS PARA\nCUIDARLA", 0, 'C');
        $this->SetXY($x + 85, 150);
        $this->Cell(40, 30, '', 1, 0);

        $this->SetY(-33);
        $this->SetX($x);
        $this->SetFont('Arial', '', 10);
        $this->Cell(80, 6, utf8_decode('Período Facturado De: ') . $this->factura['fecha_inicio_cobro'] . ' A ' . $this->factura['fecha_fin_cobro'], 1);
        $this->Cell(45, 6, 'Mes Facturado: ' . $this->factura['mes_cobrado'], 1, 1);
        $this->SetX($x + 55);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(20, 6, utf8_decode('Página') . $this->PageNo() . '/{nb}', 0, 0, 'C');
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sector = $_POST['sector'];
    $mes = $_POST['mes'];
    $año = $_POST['año'];
    try {
        // Construir la consulta SQL concatenando las cadenas
        $sql = "SELECT DISTINCT * FROM factura 
                JOIN clientes ON factura.cod_cliente = clientes.codigo 
                WHERE clientes.sector = '$sector' 
                AND factura.mes_cobrado = '$mes' 
                AND YEAR(factura.fecha_fin_cobro) = $año";
        $stmt = $conn->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    if ($result) {
        $pdfDir = 'facturas_pdfs/FACTURAS SECTOR '.$sector.' '.$mes.' '.$año;
        if (!is_dir($pdfDir)) {
            mkdir($pdfDir, 0777, true);
        }
        foreach ($result as $factura) {
            $pdf = new PDF($factura);
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->FacturaInfo();
            $file_path = $pdfDir.'/FACTURA No ' . $factura['cod_factura'].'_' .$factura['cod_cliente'].'.pdf';
            $pdf->Output('F', $file_path);
        }
        echo"Facturas Creadas con exito";
    } else {
        echo "consulta vacia";
    }
}
?>
<script>
// En la siguiente línea el parámetro final la unidad son milisegundos; en el ejemplo se indica esperar 3 segundos-
setTimeout(function(){ window.location="<?= 'facturas.php' ?>"; }, 3000); // Aquí es donde se "redirecciona" luego de trancurridos los N segundos que indiques
</script>