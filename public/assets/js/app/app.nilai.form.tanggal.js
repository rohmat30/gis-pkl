$(document).ready(function () {
  $("input.datepicker").datepicker({
    format: "dd/mm/yyyy",
    todayBtn: "linked",
    autoclose: true,
    todayHighlight: true,
    language: "id",
    endDate: "0d",
  });
  $("input.datepicker").click(function () {
    $(this).blur();
  });
});
