
$(document).ready(function () {
    $("#switch-by-name").prop("checked", true);
    $("#switch-by-name").change(function () {
        var isChecked = $(this).is(":checked");
        $("#guestName").prop("disabled", !isChecked);
    });
    $("#switch-by-phone").change(function () {
        var isChecked = $(this).is(":checked");
        $("#phoneNumber").prop("disabled", !isChecked);
    });
    $("#guests-table").DataTable({
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
});
