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
        data: "evaluasi_id",
        orderable: false,
        className: "text-center",
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        },
      },
      {
        data: "nama_siswa",
        orderable: false,
        className: "text-nowrap",
      },
      {
        data: "total",
        orderable: false,
        searchable: false,
      },
      {
        data: "keterangan",
        orderable: false,
        searchable: false,
      },
      {
        data: "kelulusan",
        orderable: false,
        searchable: false,
      },
      {
        data: "hasil_evaluasi",
        orderable: false,
        searchable: false,
      },
    ],
    order: [[0, "desc"]],
  });

  $(document).on("keyup", "#search-box", function (e) {
    let val = $(this).val();
    if (e.keyCode == 13 && val.length > 0) {
      t.api().search(val).draw();
    }
    if (val.length < 1) {
      t.api().search(val).draw();
    }
  });
});
