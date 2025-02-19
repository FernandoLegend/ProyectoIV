<?php
require_once('tcpdf/tcpdf.php');
include('config/bd.php');
include('config/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_query = trim($_POST['search_query']);

    // Conectar a la base de datos usando tu función openbd()
    $conexion = openbd();

    // Obtener la lista de trabajadores
    $stmt = $conexion->prepare("SELECT id, names, surnames, identity_card_number, assignment_id FROM staff_list");
    $stmt->execute();
    $staff_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener los datos de la tabla assignament
    $stmt = $conexion->prepare("SELECT id, adress FROM assignament");
    $stmt->execute();
    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Cerrar la conexión
    closebd($conexion);

    // Mapear los IDs de assignament a sus direcciones
    $assignment_map = [];
    foreach ($assignments as $assignment) {
        $assignment_map[$assignment['id']] = $assignment['adress'];
    }

    // Filtrar resultados según la búsqueda
    $filtered_staff = [];
    foreach ($staff_list as $staff) {
        $nomina = isset($assignment_map[$staff['assignment_id']]) ? $assignment_map[$staff['assignment_id']] : 'No asignado';
        $row_text = strtolower("{$staff['id']} {$staff['names']} {$staff['surnames']} {$staff['identity_card_number']} $nomina");

        // Comparar con el término de búsqueda
        if ($search_query === '' || stripos($row_text, $search_query) !== false) {
            $filtered_staff[] = $staff;
        }
    }

    // Crear una clase personalizada para gestionar encabezado y pie de página
    class MYPDF extends TCPDF {
        // Encabezado personalizado
        public function Header() {
            $this->SetFont('helvetica', 'B', 14);
            $this->Cell(0, 10, 'Informe de Estadística de Trabajadores', 0, 1, 'C');
            $this->Ln(5);
        }

        // Pie de página personalizado
        public function Footer() {
            $this->SetY(-15);
            $this->SetFont('helvetica', 'I', 8);
            $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, 0, 'C');
        }
    }

    // Crear instancia del PDF con formato Carta (Letter) y orientación vertical (P)
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Tu Sistema');
    $pdf->SetTitle('Informe de Trabajadores');
    $pdf->SetSubject('Reporte generado automáticamente');
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(TRUE, 20);
    $pdf->AddPage();
    
    // Encabezado de la tabla
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(15, 8, 'ID', 1, 0, 'C');
    $pdf->Cell(50, 8, 'Nombres', 1, 0, 'C');
    $pdf->Cell(50, 8, 'Apellidos', 1, 0, 'C');
    $pdf->Cell(30, 8, 'Cédula', 1, 0, 'C');
    $pdf->Cell(40, 8, 'Nómina', 1, 1, 'C');

    // Cuerpo de la tabla
    $pdf->SetFont('helvetica', '', 10);
    foreach ($filtered_staff as $staff) {
        $nomina = isset($assignment_map[$staff['assignment_id']]) ? $assignment_map[$staff['assignment_id']] : 'No asignado';
        
        $pdf->Cell(15, 7, $staff['id'], 1, 0, 'C');
        $pdf->Cell(50, 7, $staff['names'], 1, 0, 'C');
        $pdf->Cell(50, 7, $staff['surnames'], 1, 0, 'C');
        $pdf->Cell(30, 7, $staff['identity_card_number'], 1, 0, 'C');
        $pdf->Cell(40, 7, $nomina, 1, 1, 'C');
    }

    // Salida del PDF
    $pdf->Output('informe_trabajadores.pdf', 'D');
}
?>
