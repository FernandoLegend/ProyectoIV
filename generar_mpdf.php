<?php
require_once __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;

// Crear instancia de Mpdf
$mpdf = new Mpdf(['format' => 'Letter']);

// Agregar marca de agua como fondo
$mpdf->SetDefaultBodyCSS('background', "url('ruta_de_marca_de_agua.png')");
$mpdf->SetDefaultBodyCSS('background-image-resize', 6);

// Contenido del PDF
$html = "<div style='text-align: center;'>
    <img src='ruta_logo_izquierdo.png' style='width: 100px; float: left;'>
    <img src='ruta_logo_derecho.png' style='width: 100px; float: right;'>
    <h3 style='font-size: 14px; font-weight: bold; margin-bottom: 0;'>República Bolivariana de Venezuela</h3>
    <h4 style='font-size: 13px; font-weight: bold; margin-bottom: 0;'>Gobernación del Estado Delta Amacuro</h4>
    <h4 style='font-size: 13px; font-weight: bold; margin-bottom: 10px;'>Fundación Regional El Niño Simón</h4>
    <h4 style='font-size: 12px; font-weight: bold; margin-bottom: 20px;'>Recursos Humanos</h4>
</div>

<p style='text-align: left; font-size: 12px;'>
Señor(a):<br>
<strong>Licda. __________</strong><br>
<strong>Directora De La Institución</strong><br>
Presente.-
</p>

<div style='text-align: center; margin-top: 10px; margin-bottom: 10px;'>
    <h3 style='text-decoration: underline; font-size: 14px;'>CONSTANCIA DE TRABAJO</h3>
</div>

<p style='text-align: justify; font-size: 12px; line-height: 1.5;'>
Por medio de la presente hace constar que la ciudadana <strong>______________________</strong>, titular de la cédula de identidad V-__________, presta servicios en la Fundación Regional El Niño Simón desde el 15 de abril del año 2008 hasta la presente fecha desempeñando funciones como Asistente Administrativo, en un horario comprendido de 7:30 am hasta las 12:30 pm.
</p>

<p style='text-align: justify; font-size: 12px; line-height: 1.5;'>
Constancia que se expide a petición de la parte interesada a fines consiguientes, Tucupita a los 08 días del mes de Octubre año 2024.
</p>

<div style='text-align: center; margin-top: 40px;'>
    <p style='font-size: 12px;'>Atentamente,</p>
    <p style='margin-top: 50px; font-size: 12px;'>
        _____________________________<br>
        <strong>Licda. ________________________</strong><br>
        Jefa de la División de Recursos Humanos F.R.N.S<br>
        Designada según resolución Nº 470-2024
    </p>
</div>

<div style='text-align: center; margin-top: 30px; font-size: 10px; color: #555;'>
    <p>GARANTIZANDO EL DESARROLLO INTEGRAL DE NUESTROS NIÑOS</p>
    <p>Correo electrónico: fundacionsitefad@gmail.com</p>
    <p>Calle Pedro León Torres al lado del Comando de la Guardia Nacional</p>
</div>";

// Escribir el contenido en el PDF
$mpdf->WriteHTML($html);

// Generar y enviar el PDF al navegador
$mpdf->Output('constancia_trabajo.pdf', 'I');