$(function () {

    var currentDate = new Date();
    var currentDay = currentDate.getDate();
    var currentMonth = currentDate.getMonth();
    var currentYear = currentDate.getFullYear();
    var daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

    var labels = Array.from({ length: daysInMonth }, (_, i) => {
        var day = (i + 1).toLocaleString('en-US', { minimumIntegerDigits: 2 });
        var month = (currentMonth + 1).toLocaleString('en-US', { minimumIntegerDigits: 2 });
        return day + '-' + month;
    });

    var bookingsDataString = $('#bookings_by_day').val();
    var bookingsData = JSON.parse(bookingsDataString);
    var totalBookings = bookingsData.reduce((acc, currentValue) => acc + currentValue, 0);
    var todayBookings = bookingsData[currentDay - 1];
    var data = {
        labels: labels,
        datasets: [{
            label: 'Daily bookings',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            tension: 0.4,
            fill: false,
            data: bookingsData,
        }]
    }

    var options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    };

    var ctx = $('#lineChartBookings')[0].getContext('2d');
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });
    $('#total_bookings').html("Total bookings for month: " + totalBookings);
    $('#today_bookings').html("Bookings for today: " + todayBookings);
});
