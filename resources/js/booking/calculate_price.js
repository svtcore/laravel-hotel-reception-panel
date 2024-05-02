function dateDiffInDays(date1, date2) {
    var parts1 = date1.split("-");
    var parts2 = date2.split("-");
    var d1 = new Date(parseInt(parts1[0]), parseInt(parts1[1]) - 1, parseInt(parts1[2]));
    var d2 = new Date(parseInt(parts2[0]), parseInt(parts2[1]) - 1, parseInt(parts2[2]));
    var diff = d1 - d2;
    var daysDiff = Math.floor(diff / (1000 * 60 * 60 * 24));
    if (daysDiff < 0) return -1;
    else return daysDiff;
}

$(document).ready(function () {
    $("#checkInDate, #checkOutDate, .additionalServices").change(function () {
        var startDate = $('#checkInDate').val();
        var endDate = $('#checkOutDate').val();
        var price_per_night = $('#price_per_night').val();
        var difference = dateDiffInDays(endDate, startDate);
        var additionaltotalPrice = 0;
        if (difference != -1) {
            $('.additionalServices').each(function () {
                if ($(this).is(':checked')) {
                    additionaltotalPrice += parseFloat($(this).data('price'));
                }
            });
        }
        var total_result = (parseFloat(price_per_night) * difference) + additionaltotalPrice;
        $('#totalCost').val(total_result);
    });
});
