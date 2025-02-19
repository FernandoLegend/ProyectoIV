<?php
require('../fpdf/fpdf.php');

date_default_timezone_set('America/Caracas');

$GLOBALS['fecha'] = date(" d / m / Y");

$clave22 = $_POST['clave22'];

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial', 'B', 11);
        // Movernos a la derecha
        $this->Cell(105);
        // Logo
        $this->Image('logo.png', 14, 8, 80);
        // Título
        $this->Cell(70, 10, 'Acta de Cierre' . $GLOBALS['fecha'], 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);
        $this->SetX(-30);
        $this->SetY(30);
        $this->MultiCell(19, 6, "Nro. Personal", 1, 'C');
        $this->SetY(30);
        $this->SetX(29);
        $this->Cell(80, 12, 'Nombres y Apellidos', 1, 0, 'C', 0);
        $this->Cell(20, 12, utf8_decode('Cedúla'), 1, 0, 'C', 0);
        $this->MultiCell(38, 6, utf8_decode('Denominación del proceso formativo'), 1, 'C');
        $this->SetY(30);
        $this->SetX(167);
        $this->Cell(12, 12, 'Horas', 1, 0, 'C', 0);
        $this->MultiCell(30, 4, utf8_decode('Inicio y Culminación'), 1, 'C');
        $this->SetX(179);
        $this->MultiCell(15, 4, 'Desde', 1, 'C');
        $this->SetY(38);
        $this->SetX(194);
        $this->MultiCell(15, 4, 'Hasta', 1, 'C');
        $this->SetY(30);
        $this->SetX(209);
        $this->MultiCell(43, 6, 'Resumen del metodo de evaluacion', 1, 'C');
        $this->SetY(30);
        $this->SetX(252);
        $this->MultiCell(20, 12, 'Firma', 1, 'C');
    }

//     Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Conexion a la base de datos usando PDO
include("config/bd.php");

try {
    $conexion = openbd();
    
    // Convertir $clave22 en un array y escapar cada elemento
    $claves = explode(',', $clave22);
    $clavesEscapadas = array_map(array($conexion, 'quote'), $claves);
    $clavesString = implode(',', $clavesEscapadas);
    
    // Consulta SQL con los valores de $clave22 directamente
    $sql = "SELECT datos_personales.*, empresa.* FROM datos_personales LEFT JOIN empresa ON datos_personales.id_2 = empresa.id WHERE datos_personales.cedula IN ($clave22)";
    
    // Ejecutar la consulta
    $resultado = $conexion->query($sql);
    
    if (!$resultado) {
        // Manejar el error de la base de datos
        $errorInfo = $conexion->errorInfo();
        throw new Exception("Error en la consulta SQL: " . $errorInfo[2]);
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

closebd($conexion);

$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage('LANDSCAPE');
$pdf->SetFont('Arial', 'B', 10);

while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(19, 10, $fila['nro_personal'], 1, 0, 'C', 0);
    $pdf->Cell(35, 10, utf8_decode($fila['nombres']), 'LTB', 0, 'R', 0);
    $pdf->Cell(45, 10, utf8_decode($fila['apellidos']), 'TRB', 0, 'L', 0);
    $pdf->Cell(20, 10, $fila['cedula'], 1, 0, 'C', 0);
    $pdf->Cell(38, 10, "", 'RL', 0, 'C', 0);
    $pdf->Cell(12, 10, "", 'RL', 0, 'C', 0);
    $pdf->Cell(15, 10, "", 'RL', 0, 'C', 0);
    $pdf->Cell(15, 10, "", 'RL', 0, 'C', 0);
    $pdf->Cell(43, 10, "", 'RL', 0, 'C', 0);
    $pdf->Cell(20, 10, "", 'RL', 1, 'C', 0);
}
$pdf->Multicell(262, 0, "", 'T', 'L', 0);

$pdf->Output();
echo '<link rel="shortcut icon" href="./../img/logo1.png"/>';
?>
<html lang="es">
<link rel="shortcut icon" href="../img/logo1.png" />
<title>Reporte PDF</title>
