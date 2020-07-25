$(document).ready(function () {
  let URL = $("#jadwal_id").data("url");
  $("#jadwal_id").select2({
    width: "100%",
    placeholder: $("#jadwal_id").attr("placeholder"),
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
              id: item.jadwal_id,
              text: item.nama_siswa + " (" + item.username + ")",
            };
          }),
        };
      },
    },
  });
});
