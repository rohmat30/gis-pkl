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
        data: "pengajuan_id",
        orderable: false,
        className: "text-right",
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        },
      },
      {
        data: "foto",
        orderable: false,
        searchable: false,
        render: function (data) {
          return `<img src="${data}" width="32" height="32" class="img-modal" data-target="#preview-gambar" data-toggle="modal" rel="tooltip" data-placement="bottom" title="Klik untuk preview foto"/>`;
        },
      },
      {
        data: "nama",
        orderable: false,
      },
      {
        data: "alamat",
        orderable: false,
        searchable: false,
      },
      {
        data: "pic",
        orderable: false,
        searchable: false,
      },
      {
        data: "status",
        orderable: false,
        searchable: false,
        render: function (data) {
          let color;
          switch (data) {
            case "menunggu":
              color = "warning";
              break;
            case "setuju":
              color = "success";
              break;
            default:
              color = "danger";
              break;
          }
          return `<span class="badge badge-${color} badge-pill">${data}</span>`;
        },
      },
    ],
    order: [[0, "desc"]],
  });

  $("#preview-gambar").on("shown.bs.modal", function (e) {
    let url = $(e.relatedTarget).attr("src");
    $(this).find("img").attr("src", url);
  });
});
