$(document).ready(function(){$("#switch-by-room").prop("checked",!0),$("#switch-by-date").change(function(){var e=$(this).is(":checked");$("#startDate").prop("disabled",!e),$("#endDate").prop("disabled",!e)}),$("#switch-by-name").change(function(){var e=$(this).is(":checked");$("#guestName").prop("disabled",!e)}),$("#switch-by-room").change(function(){var e=$(this).is(":checked");$("#roomNumber").prop("disabled",!e)}),$("#switch-by-phone").change(function(){var e=$(this).is(":checked");$("#phoneNumber").prop("disabled",!e)}),$("#result-table").DataTable({responsive:!0,lengthChange:!1,autoWidth:!1,searching:!1,paging:!0,ordering:!0,info:!1,order:[[5,"asc"]]})});
