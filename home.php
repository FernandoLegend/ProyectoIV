<?php
session_start();
include("./template/head.php");
include('config/verify_token.php');
include('config/functions.php');

$staff_list = get_staff_list();
$assignments = get_assignments(); // Obtener los nombres desde la tabla "assignament"

// Crear un mapa de ID a nombres de "assignament"
$assignment_map = [];
foreach ($assignments as $assignment) {
    $assignment_map[$assignment['id']] = $assignment['adress']; // Usar 'adress' como nombre a mostrar
}

?>

<title>Menú</title>
<link rel="stylesheet" type="text/css" href="./css/datatables.min.css">
<script type="text/javascript" charset="utf8" src="js/jquery.js"></script>
<script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
<script src="js/captura_de_busqueda"></script>
<section class="home">
    <h1 class="text">Informe de estadística de trabajadores</h1>
    <form id="pdfForm" action="generate_table_pdf.php" method="POST" target="_blank">
    <input type="hidden" id="search_query" name="search_query" value="">
    <button type="submit" class="btn btn-primary">Generar PDF</button>
</form>
    <div class="table">
        <table id="data_table">
            <thead>
                <tr>
                    <th class="text-center">Id</th>
                    <th class="text-center">Nombres</th>
                    <th class="text-center">Apellidos</th>
                    <th class="text-center">Cédula</th>
                    <th class="text-center">Nomina</th>
                    <th class="text-center">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($staff_list as $staff): ?>
                    <tr>
                        <td class="text-center"><?= $staff['id']; ?></td>
                        <td class="text-center"><?= $staff['names']; ?></td>
                        <td class="text-center"><?= $staff['surnames']; ?></td>
                        <td class="text-center"><?= $staff['identity_card_number']; ?></td>
                        <td class="text-center">
                            <span class="hidden-data" style="display: none"><?= $staff['assignment_id']; ?></span>
                            <?= isset($assignment_map[$staff['assignment_id']]) ? $assignment_map[$staff['assignment_id']] : 'No asignado'; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="view_hiring.php?id=<?= $staff['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-file-text"></i>
                                </a>
                                <a href="info.php?id=<?= $staff['id']; ?>" class="btn btn-info btn-sm">
                                    <i class="fa fa-search"></i>
                                </a>
                                <a href="edit_form.php?id=<?= $staff['id']; ?>" class="btn btn-success btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="delete_record.php?id=<?= $staff['id']; ?>" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
$(document).ready(function() {
    var table = $('#data_table').DataTable({
        columnDefs: [
            { width: '19%', targets: 1 },
            { width: '19%', targets: 2 },
            { width: '15%', targets: 3 },
            { width: '10%', targets: 4 },
            { width: '12%', targets: 0 }
        ],
        language: { search: "Buscar " },
        infoCallback: function(settings, start, end, max, total, pre) {
            return ' Mostrando ' + end + ' registro(s)';
        },
        paging: false,
        scrollY: 505,
        searching: true,
    });

    // Capturar búsqueda y enviarla al formulario del PDF
    $('#pdfForm').submit(function() {
        var searchValue = $('.dataTables_filter input').val().toLowerCase();
        $('#search_query').val(searchValue);
    });
});
    </script>
</section>
</body>
<?php include("./template/foot.php"); ?>

</html>