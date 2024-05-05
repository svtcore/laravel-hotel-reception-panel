$(document).ready(function () {
    const countryCode = $('#documentCountry').val();
    if (countryCode) {
        $('#countryCode').val(countryCode);
    }

    $.ajax({
        url: 'https://restcountries.com/v3.1/all',
        method: 'GET',
        success: function (data) {
            const selectCountryCode = $('#countryCode');

            data.sort(function (a, b) {
                return a.name.common.localeCompare(b.name.common);
            });

            $.each(data, function (index, country) {
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
        error: function (error) {
            console.error('Error fetching countries:', error);
        }
    });
});
