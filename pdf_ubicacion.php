<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

// Verificar valores enviados por POST
$names = isset($_POST['names']) ? htmlspecialchars($_POST['names'], ENT_QUOTES, 'UTF-8') : 'Nombre no proporcionado';
$surnames = isset($_POST['surnames']) ? htmlspecialchars($_POST['surnames'], ENT_QUOTES, 'UTF-8') : 'Apellido no proporcionado';
$ci = isset($_POST['ci']) ? htmlspecialchars($_POST['ci'], ENT_QUOTES, 'UTF-8') : 'Cédula no proporcionada';
$cargo = isset($_POST['cargo']) ? htmlspecialchars($_POST['cargo'], ENT_QUOTES, 'UTF-8') : 'Cargo no especificado';

// Obtener la fecha actual en español
$dia = date('d');
$meses = [
    'January' => 'Enero', 'February' => 'Febrero', 'March' => 'Marzo', 'April' => 'Abril',
    'May' => 'Mayo', 'June' => 'Junio', 'July' => 'Julio', 'August' => 'Agosto',
    'September' => 'Septiembre', 'October' => 'Octubre', 'November' => 'Noviembre', 'December' => 'Diciembre'
];
$mes_es = $meses[date('F')];
$anio = date('Y');

// Crear PDF con TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Gobernación del Estado Delta Amacuro');
$pdf->SetTitle('Constancia de Ubicación');
$pdf->SetSubject('Constancia de Ubicación');

// Márgenes y configuración de la página
$pdf->SetMargins(20, 20, 20);
$pdf->SetAutoPageBreak(FALSE, 20);
$pdf->AddPage();

// Agregar logo en la parte superior izquierda
$pdf->Image('./sources/logo_izquierda.png', 10, 10, 55, 35, '', '', '', false, 300, '', false, false, 0, false, false, false);

// Agregar logo en la parte superior derecha
$pdf->Image('./sources/logo_derecha.jpg', 150, 10, 40, 40, '', '', '', false, 300, '', false, false, 0, false, false, false);

// Imagen de fondo con opacidad baja
$img_file = './sources/logo_fondo.png';
$pdf->Image($img_file, 30, 50, 150, 150, '', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->setPageMark(); 

// Fuente y contenido
$pdf->SetFont('times', '', 12);
$html = <<<EOD
<style>
    body { font-size: 12px; }
    h2, h3, h4 { font-size: 12px; }
    footer { font-size: 10px; }
</style>

<h2 style="text-align: center;">República Bolivariana de Venezuela</h2>
<h3 style="text-align: center;">Gobernación del Estado Delta Amacuro</h3>
<h3 style="text-align: center;">Fundación Regional El Niño Simón</h3>
<h4 style="text-align: center; color: #555;">Recursos Humanos</h4>

<h3 style="text-align: center;">CONSTANCIA DE UBICACIÓN</h3>

<p>Quien suscribe, LCD(A). ______________________________, titular de la cédula de identidad Nº ____________,
Jefe(a) de la División de Recursos Humanos de la Fundación Regional El Niño Simón en el Estado Delta Amacuro, 
mediante la presente hago constar que el(la) ciudadano(a) <strong>$names $surnames</strong>, titular de la cédula de identidad Nº V-<strong>$ci</strong>, 
presta sus servicios en esta institución ocupando el cargo de <strong>$cargo</strong>.</p>

<p>Constancia que se expide a petición de la parte interesada en Tucupita a los <strong>$dia</strong> días del mes 
<strong>$mes_es</strong> de <strong>$anio</strong>.</p>

<p style="text-align: center; margin-top: 50px;">Atentamente,<br><br><br>
<strong>_________________________</strong><br>
LCDA. ______________________________<br>
PRESIDENTE <br>
DESIGNADA SEGÚN RESOLUCIÓN N° ______________, FECHA 01/02/2024</p>

<p style="text-align: center; font-size: 10px; color: #555; margin-top: 50px;">
"GARANTIZANDO EL DESARROLLO INTEGRAL DE NUESTROS NIÑOS"<br>
Correo electrónico: fundaciondeltaq@gmail.com<br>
Calle Pedro León Torres al lado del Comando de la Guardia Nacional
</p>
EOD;

// Escribir el contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Salida del archivo PDF
$pdf->Output('constancia_de_ubicacion.pdf', 'I');
?>
