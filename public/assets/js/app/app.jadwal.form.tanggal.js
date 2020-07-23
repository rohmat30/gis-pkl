$(document).ready(function () {
  $("input.datepicker").click(function () {
    $(this).blur();
  });

  $("#tanggal").datepicker({
    inputs: $("input.datepicker"),
    format: "dd/mm/yyyy",
    todayBtn: "linked",
    autoclose: true,
    language: "id",
  });
});
