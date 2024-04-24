$(function () {
    var roomTypes = ['Standard', 'Deluxe', 'Suite', 'Penthouse'];
    var room_data = $('#room_data').html();
    room_data = room_data.slice(1, -1);
    var roomSalesData = room_data.split(',').map(Number);

    var data = {
        labels: roomTypes,
        datasets: [{
            label: 'Count of bookings',
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)'
            ],
            data: roomSalesData
        }]
    };

    var options = {
        responsive: true,
        title: {
            display: true,
            text: ''
        }
    };

    var ctx = $('#roomSalesChart')[0].getContext('2d');
    var roomSalesChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: options
    });

    roomSalesChart.canvas.style.width = '350px';
    roomSalesChart.canvas.style.height = '300px';
});
