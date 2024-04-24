$(function () {
    var roomsAvailabilityData = JSON.parse($('#rooms_availability_data').val());

    var occupiedRooms = roomsAvailabilityData[0];
    var availableRooms = roomsAvailabilityData[1];

    var data = {
        labels: ["Occupied Rooms", "Available Rooms"],
        datasets: [
            {
                label: '',
                backgroundColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1,
                data: [occupiedRooms, availableRooms],
            }
        ]
    }

    var options = {
        scales: {
            xAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        indexAxis: 'y',
        elements: {
            bar: {
                borderWidth: 4,
            }
        },
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        }
    };

    var ctx = $('#lineChartAvailability')[0].getContext('2d');
    var lineChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
});
