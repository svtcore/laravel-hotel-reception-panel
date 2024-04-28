
$(document).ready(function () {
    $("#switch-by-room").prop("checked", true);
    $("#switch-by-date").change(function () {
        var isChecked = $(this).is(":checked");
        $("#startDate").prop("disabled", !isChecked);
        $("#endDate").prop("disabled", !isChecked);
    });
    $("#switch-by-name").change(function () {
        var isChecked = $(this).is(":checked");
        $("#guestName").prop("disabled", !isChecked);
    });
    $("#switch-by-room").change(function () {
        var isChecked = $(this).is(":checked");
        $("#roomNumber").prop("disabled", !isChecked);
    });
    $("#switch-by-phone").change(function () {
        var isChecked = $(this).is(":checked");
        $("#phoneNumber").prop("disabled", !isChecked);
    });
});
$("#check-in-table").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "searching": false,
    "paging": true,
    "ordering": true,
    "info": false,
    "order": [
        [5, 'asc']
    ]
});
$("#check-out-table").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "searching": false,
    "paging": true,
    "ordering": true,
    "info": false,
    "order": [
        [5, 'asc']
    ]
});
