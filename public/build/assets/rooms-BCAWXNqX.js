$(function(){var e=["Standard","Deluxe","Suite","Penthouse"],a=$("#room_data").html();a=a.slice(1,-1);var o=a.split(",").map(Number),r={labels:e,datasets:[{label:"Count of bookings",backgroundColor:["rgba(255, 99, 132, 0.6)","rgba(54, 162, 235, 0.6)","rgba(255, 206, 86, 0.6)","rgba(75, 192, 192, 0.6)"],data:o}]},s={responsive:!0,title:{display:!0,text:""}},l=$("#roomSalesChart")[0].getContext("2d"),t=new Chart(l,{type:"pie",data:r,options:s});t.canvas.style.width="350px",t.canvas.style.height="300px"});
