$(document).ready(function(){$("#switch-by-name").prop("checked",!0),$("#switch-by-name").change(function(){var e=$(this).is(":checked");$("#guestName").prop("disabled",!e)}),$("#switch-by-phone").change(function(){var e=$(this).is(":checked");$("#phoneNumber").prop("disabled",!e)}),$("#guests-table").DataTable({responsive:!0,lengthChange:!1,autoWidth:!1,searching:!1,paging:!0,ordering:!0,info:!1,order:[[0,"asc"]]})});