$(function () {
    var roomsAvailabilityData = JSON.parse($("#rooms_availability_data").val());

    var occupiedRooms = roomsAvailabilityData[0];
    var availableRooms = roomsAvailabilityData[1];

    var data = {
        labels: ["Occupied Rooms", "Available Rooms"],
        datasets: [
            {
                label: "",
                backgroundColor: [
                    "rgba(255, 87, 34, 0.8)",
                    "rgba(76, 175, 80, 0.8)",
                ],
                borderColor: ["rgba(255, 87, 34, 1)", "rgba(76, 175, 80, 1)"],
                borderWidth: 1,
                data: [occupiedRooms, availableRooms],
            },
        ],
    };

    var options = {
        responsive: true,
        indexAxis: "y",
        elements: {
            bar: {
                borderWidth: 4,
            },
        },
        plugins: {
            legend: {
                display: false,
            },
        },
    };

    var ctx = $("#lineChartAvailability")[0].getContext("2d");
    var lineChart = new Chart(ctx, {
        type: "bar",
        data: data,
        options: options,
    });
});
