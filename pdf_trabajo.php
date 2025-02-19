<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

// Verificar que los valores se envían correctamente por POST
$date_in = isset($_POST['date_in']) ? htmlspecialchars($_POST['date_in'], ENT_QUOTES, 'UTF-8') : 'Fecha no proporcionada';
$off_date = isset($_POST['off_date']) ? htmlspecialchars($_POST['off_date'], ENT_QUOTES, 'UTF-8') : 'Fecha no proporcionada';
$names = isset($_POST['names']) ? htmlspecialchars($_POST['names'], ENT_QUOTES, 'UTF-8') : 'Nombre no proporcionado';
$surnames = isset($_POST['surnames']) ? htmlspecialchars($_POST['surnames'], ENT_QUOTES, 'UTF-8') : 'Apellido no proporcionado';
$ci = isset($_POST['ci']) ? htmlspecialchars($_POST['ci'], ENT_QUOTES, 'UTF-8') : 'Cédula no proporcionada';
$director = isset($_POST['director']) ? htmlspecialchars($_POST['director'], ENT_QUOTES, 'UTF-8') : 'Director no proporcionado';
$nivel_academico = isset($_POST['nivel_academico']) ? htmlspecialchars($_POST['nivel_academico'], ENT_QUOTES, 'UTF-8') : 'Nivel académico no proporcionado';

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
$pdf->SetAuthor('Nombre de la Institución');
$pdf->SetTitle('Constancia de Trabajo');
$pdf->SetSubject('Constancia de Trabajo');

// Márgenes y página
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
<h3 style="text-align: center;">Gobernación del Estado Delta Amacuro<br>Fundación Regional El Niño Simón</h3>
<h4 style="text-align: center; color: #555;">Recursos Humanos</h4>

<p>Señor (a)<br>
<strong>$nivel_academico</strong> <strong>$director</strong><br>
Director(a) de la Institución<br>
Presente.-</p>

<h3 style="text-align: center;">CONSTANCIA DE TRABAJO</h3>

<p>Por medio de la presente, se hace constar que la ciudadana <strong>$names</strong> <strong>$surnames</strong>, 
titular de la cédula de identidad <strong>$ci</strong>, presta servicios en la Fundación Regional El Niño Simón 
desde el <strong>$date_in</strong> hasta <strong>$off_date</strong>, desempeñando funciones como Asistente Administrativo, 
en un horario comprendido de 7:30 a.m. hasta 12:30 p.m.</p>

<p>Constancia que se expide a petición de la parte interesada a fines consiguientes, Tucupita a los <strong>$dia</strong> días del mes 
<strong>$mes_es</strong> de <strong>$anio</strong>.</p>

<p style="text-align: center; margin-top: 50px;">Atentamente,<br><br><br>
<strong>_________________________</strong><br>
Jefe(a) de la División de Recursos Humanos F.R.N.S<br>
Designada según resolución N° 470-2024</p>

<p style="text-align: center; font-size: 10px; color: #555; margin-top: 50px;">
"GARANTIZANDO EL DESARROLLO INTEGRAL DE NUESTROS NIÑOS"<br>
Correo electrónico: fundacionsimonfrd@gmail.com<br>
Calle Pedro León Torres al lado del Comando de la Guardia Nacional
</p>
EOD;

// Escribir el contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Salida del archivo PDF
$pdf->Output('constancia_de_trabajo.pdf', 'I');
?>
