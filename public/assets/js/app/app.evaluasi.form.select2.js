$(document).ready(function () {
  let URL = $("#nilai_id").data("url");
  $("#nilai_id").select2({
    width: "100%",
    placeholder: $("#nilai_id").attr("placeholder"),
    delay: 200,
    theme: "bootstrap4",
    ajax: {
      url: URL,
      dataType: "json",
      type: "GET",
      data: function (params) {
        return {
          term: params.term,
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.nilai_id,
              text: item.nama + " (" + item.username + ")",
            };
          }),
        };
      },
    },
  });
});
