<?php include("../template/sesion.php") ?>
<?php
require('../../fpdf/fpdf.php');

date_default_timezone_set('America/Caracas');

$GLOBALS['fecha']=date(" d / m / Y");

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
	
    // Arial bold 15
    $this->SetFont('Arial','B',11);
    // Movernos a la derecha
    $this->Cell(105);
    // Título
    $this->Cell(70,10,'Gestion ' . $GLOBALS['fecha'],0,0,'C');
    // Salto de línea
    $this->Ln(20);

    $this->Cell(15,10,'ID',1,0,'C',0);
	$this->Cell(25,10,'Cedula',1,0,'C',0);
	$this->Cell(35,10,'Apellidos',1,0,'C',0);
    $this->Cell(35,10,'Nombres',1,0,'C',0);
	$this->Cell(35,10,'Trabajo',1,0,'C',0);
    $this->Cell(20,10,'Nomina',1,0,'C',0);
    $this->Cell(30,10,'Ingreso',1,0,'C',0);
    $this->Cell(30,10,'Retiro',1,0,'C',0);
	$this->Cell(25,10,'Descuento',1,0,'C',0);
	$this->Cell(25,10,'Saldo',1,1,'C',0);
  
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página') .$this->PageNo().'/{nb}',0,0,'C');
}
}

// Conexion a la base de dato
include("bd.php");
$con=conectar();
//

$sql=$_POST['sql'];

$query=mysqli_query($con, $sql);
//

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('LANDSCAPE');
$pdf->SetFont('Arial','B',10);

while ($row=$query->fetch_assoc()) {
	$pdf->Cell(15,10,$row['id'],1,0,'C',0);
	$pdf->Cell(25,10,$row['cedula'],1,0,'C',0);
    $pdf->Cell(35,10,utf8_decode($row['apellidos']),1,0,'C',0);
	$pdf->Cell(35,10,$row['nombres'],1,0,'C',0);
    $pdf->Cell(35,10,$row['trabajo'],1,0,'C',0);
	$pdf->Cell(20,10,$row['nomina'],1,0,'C',0);
    $pdf->Cell(30,10,$row['ingreso'],1,0,'C',0);
    $pdf->Cell(30,10,$row['retiro'],1,0,'C',0);
	$pdf->Cell(25,10,$row['descuento'],1,0,'C',0);
	$pdf->Cell(25,10,$row['Saldo'],1,1,'C',0);

}


	$pdf->Output();
?>