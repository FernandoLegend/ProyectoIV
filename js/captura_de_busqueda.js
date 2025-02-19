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
