
$(document).ready(function () {
    $('#searchTopBlock').hide();
    $("#switch-by-number").change(function () {
        var isChecked = $(this).is(":checked");
        $("#roomNumber").prop("disabled", !isChecked);
        if (isChecked) {
            $("#startDate, #endDate, #roomType, #roomStatus, #roomAdult, #roomChildren, #guestName, #switch-by-guest, #searchButton").prop("disabled", true);
            $("[id^='property_']").prop("disabled", true);
            $("#baseSearch").hide();
            $('#searchTopBlock').show();
        } else {
            $("#startDate, #endDate, #roomType, #roomStatus, #roomAdult, #roomChildren, #switch-by-guest, #searchButton").prop("disabled", false);
            $("[id^='property_']").prop("disabled", false);
            $("#roomNumber").val("");
            $("#baseSearch").show();
            $('#searchTopBlock').hide();
        }
    });
    $("#switch-by-guest").change(function () {
        var isChecked = $(this).is(":checked");
        $("#guestName").prop("disabled", !isChecked);
        if (isChecked) {
            $("#startDate, #endDate, #roomType, #roomStatus, #roomAdult, #roomChildren, #roomNumber, #switch-by-number, #searchButton").prop("disabled", true);
            $("[id^='property_']").prop("disabled", true);
            $("#baseSearch").hide();
            $('#searchTopBlock').show();
        } else {
            $("#startDate, #endDate, #roomType, #roomStatus, #roomAdult, #roomChildren, #switch-by-number, #searchButton").prop("disabled", false);
            $("[id^='property_']").prop("disabled", false);
            $("#guestName").val("");
            $("#baseSearch").show();
            $('#searchTopBlock').hide();
        }
    });

    $("#free-rooms-table").DataTable({
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
});