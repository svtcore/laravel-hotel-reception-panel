$(document).ready(function(){$("#employees-table").DataTable({responsive:!0,lengthChange:!1,autoWidth:!1,searching:!0,paging:!0,ordering:!0,info:!1,order:[[0,"asc"]],dom:'<"top"fl>rt<"bottom"ip>',language:{search:"",searchPlaceholder:"Search"}}),$(".dt-search").addClass("text-left mb-4 mt-4 mr-3"),$("#dt-search-1").removeClass("form-control-sm"),$("#dt-search-1").css("width","30%")});