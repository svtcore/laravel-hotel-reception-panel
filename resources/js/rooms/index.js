
$(document).ready(function () {
    $("#switch-by-number").change(function () {
        var isChecked = $(this).is(":checked");
        $("#roomNumber").prop("disabled", !isChecked);
        if (isChecked) {
            $("#startDate, #endDate, #roomType, #roomStatus, #roomAdult, #roomChildren, #guestName, #switch-by-guest, #searchButton").prop("disabled", true);
            $("[id^='property_']").prop("disabled", true);
            $("#baseSearch").addClass("d-none");
            $('#searchTopBlock').removeClass("d-none");
        } else {
            $("#startDate, #endDate, #roomType, #roomStatus, #roomAdult, #roomChildren, #switch-by-guest, #searchButton").prop("disabled", false);
            $("[id^='property_']").prop("disabled", false);
            $("#roomNumber").val("");
            $("#baseSearch").removeClass("d-none");
            $('#searchTopBlock').addClass("d-none");
        }
    });
    $("#switch-by-guest").change(function () {
        var isChecked = $(this).is(":checked");
        $("#guestName").prop("disabled", !isChecked);
        if (isChecked) {
            $("#startDate, #endDate, #roomType, #roomStatus, #roomAdult, #roomChildren, #roomNumber, #switch-by-number, #searchButton").prop("disabled", true);
            $("[id^='property_']").prop("disabled", true);
            $("#baseSearch").addClass("d-none");
            $('#searchTopBlock').removeClass("d-none");
        } else {
            $("#startDate, #endDate, #roomType, #roomStatus, #roomAdult, #roomChildren, #switch-by-number, #searchButton").prop("disabled", false);
            $("[id^='property_']").prop("disabled", false);
            $("#guestName").val("");
            $("#baseSearch").removeClass("d-none");
            $('#searchTopBlock').addClass("d-none");
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
    $('#free-rooms-table tbody').on('mouseenter', 'tr', function() {
        $(this).addClass('highlight');
    });
    
    $('#free-rooms-table tbody').on('mouseleave', 'tr', function() {
        $(this).removeClass('highlight');
    });
});