
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
    $.ajax({
        url: 'https://restcountries.com/v3.1/all',
        method: 'GET',
        success: function(data) {
            const selectCountryCode = $('#countryCode');
            $.each(data, function(index, country) {
                const option = $('<option>').val(country.cca2).text(country.name.common + ' (+' + country.callingCodes[0] + ')');
                selectCountryCode.append(option);
            });

            const countryCode = "{{ $guest->guest_document->document_country }}";
            if (countryCode) {
                selectCountryCode.val(countryCode);
            }
        },
        error: function(error) {
            console.error('Error fetching countries:', error);
        }
    });
});
