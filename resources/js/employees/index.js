$(document).ready(function () {
    $("#employees-table").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": false,
        "paging": true,
        "ordering": true,
        "info": false,
        "order": [
            [0, 'asc']
        ]
    });
    $(".dt-search").addClass("text-left mb-4 mt-4 mr-3");
    $("#dt-search-1").removeClass("form-control-sm");
    $("#dt-search-1").css("width", "30%");
});