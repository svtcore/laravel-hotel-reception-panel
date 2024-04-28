
$(document).ready(function () {
    $("#guests_table").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": false,
        "paging": true,
        "ordering": true,
        "info": false,
        "order": [
            [3, 'desc']
        ]
    });
});