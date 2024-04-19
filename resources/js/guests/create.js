
$(document).ready(function () {
    $('#roomNumber').on('input', function () {
        var route = $('#target_url').data('route');
        var roomNumber = $(this).val();
        if (roomNumber == "0" || roomNumber == ""){
            $('#selectedOrderId').val("");
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: route,
            method: 'POST',
            data: {
                roomNumber: roomNumber
            },
            success: function (response) {
                var resultList = $('#result');
                resultList.empty();

                if (response.length > 0) {
                    $.each(response, function (index, order) {
                        var checkInDate = new Date(order.check_in_date);
                        var formattedCheckInDate = ('0' + checkInDate.getDate()).slice(-2) + '-' + ('0' + (checkInDate.getMonth() + 1)).slice(-2) + '-' + checkInDate.getFullYear();

                        var listItem = '<li class="list-group-item" data-order-id="' + order.order_id + '"><b>' +
                            formattedCheckInDate + ' | ' + order.first_name + ' ' + order.last_name + '</b></li>';

                        resultList.append(listItem);
                    });
                } else {
                    resultList.append('<li class="list-group-item">No resuls found</li>');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    $(document).on('click', '#result .list-group-item', function () {
        $('#result .list-group-item').removeClass('active');
        $(this).addClass('active');
        var selectedOrderId = $(this).data('order-id');
        $('#selectedOrderId').val(selectedOrderId);
    });

    const countryCode = $('#documentCountry').val();
    if (countryCode) {
        $('#countryCode').val(countryCode);
    }

    $.ajax({
        url: 'https://restcountries.com/v3.1/all',
        method: 'GET',
        success: function(data) {
            const selectCountryCode = $('#countryCode');
            $.each(data, function(index, country) {
                const countryCode = country.callingCodes ? country.callingCodes[0] : ''; 
                const optionText = countryCode ? ` (+${countryCode})` : '';
                const option = $('<option>').val(country.cca2).text(country.name.common + optionText);
                selectCountryCode.append(option);
            });
            const countryCode = $('#documentCountry').val();
            if (countryCode) {
                selectCountryCode.val(countryCode);
            }
        },
        error: function(error) {
            console.error('Error fetching countries:', error);
        }
    });
});
