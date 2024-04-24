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

    var revenueDataString = $('#sum_by_day').val();
    var revenueData = JSON.parse(revenueDataString);
    var totalRevenue = revenueData.reduce((acc, currentValue) => acc + currentValue, 0);
    var todayRevenue = revenueData[currentDay - 1];
    var data = {
        labels: labels,
        datasets: [{
            label: 'Daily income',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            tension: 0.4,
            fill: false,
            data: revenueData,
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

    var ctx = $('#lineChart')[0].getContext('2d');
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });
    $('#total_income').html("Total for month: " + totalRevenue);
    $('#today_income').html("Total for today: " + todayRevenue);
});
