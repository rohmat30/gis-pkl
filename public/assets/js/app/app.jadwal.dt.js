$(document).ready(function () {
  let $table = $("#table");
  let dtURL = $table.data("url");

  let $meta = $('meta[name="X-CSRF-TOKEN"]');

  let t = $table.dataTable({
    processing: true,
    serverSide: true,
    dom: "rtip",
    pageLength: 25,
    autoWidth: false,
    responsive: true,
    ajax: {
      url: dtURL,
      type: "POST",
      beforeSend: function (xhr) {
        let $token = $meta.attr("content");
        xhr.setRequestHeader("X-CSRF-TOKEN", $token);
      },
      complete: function (xhr) {
        let $token = xhr.getResponseHeader("x-csrf-token");
        if ($token) {
          $meta.attr("content", $token);
        }
      },
    },
    columns: [
      {
        data: "jadwal_id",
        orderable: false,
        className: "text-right",
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        },
      },
      {
        data: "nama_siswa",
        orderable: false,
      },
      {
        data: "tanggal_awal",
        orderable: false,
        searchable: false,
        render: function (data) {
          let date = data.split("-");
          return date[2] + "/" + date[1] + "/" + date[0];
        },
      },
      {
        data: "tanggal_akhir",
        orderable: false,
        searchable: false,
        render: function (data) {
          let date = data.split("-");
          return date[2] + "/" + date[1] + "/" + date[0];
        },
      },
      {
        data: "nama_instansi",
        orderable: false,
      },
      {
        data: "nama_pembimbing",
        orderable: false,
      },
      {
        data: "nama_pl",
        orderable: false,
      },
    ],
    order: [[0, "desc"]],
  });
});
