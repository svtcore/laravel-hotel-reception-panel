
$(document).ready(function () {
    $("#booking_table").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": false,
        "paging": true,
        "ordering": true,
        "info": false,
        "order": [
            [2, 'asc']
        ]
    });
});