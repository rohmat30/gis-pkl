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
      {
        data: "aksi",
        orderable: false,
        className: "nowrap",
        searchable: false,
        render: function (data, type, row) {
          let action = `<a href="${data.edit}" class="btn btn-outline-primary btn-icon btn-xs" rel="tooltip" data-placement="bottom" title="Edit"> <i class="far fa-edit"></i></a>`;
          if (row.user_id != 1) {
            action += ` <button data-url="${data.hapus}" class="btn btn-outline-danger btn-icon btn-xs" data-toggle="modal" rel="tooltip" data-target="#konfirmasi-hapus" data-placement="bottom" title="Hapus"><i class="far fa-trash-alt"></i></button>`;
          } else {
            action += ` <button class="btn btn-outline-danger btn-icon btn-xs disabled"><i class="far fa-trash-alt"></i></button>`;
          }
          return action;
        },
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

  $("#preview-gambar").on("shown.bs.modal", function (e) {
    let url = $(e.relatedTarget).attr("src");
    $(this).find("img").attr("src", url);
  });

  $(".alert-js .close").on("click", function () {
    $(this).parent().addClass("d-none");
  });

  $("#konfirmasi-hapus").on("shown.bs.modal", function (e) {
    let url = $(e.relatedTarget).data("url");
    $(this).find("#btn-hapus").data("url", url);
  });

  $("#btn-hapus").on("click", function () {
    let url = $(this).data("url");

    $.ajax({
      url: url,
      type: "DELETE",
      beforeSend: function (xhr) {
        let $token = $meta.attr("content");
        xhr.setRequestHeader("X-CSRF-TOKEN", $token);
      },
      success: function (res) {
        let icon = '<i class="far fa-check-circle"></i> ';
        let $alert = $(".alert-js");

        $alert.addClass("show alert-info");
        if ($alert.hasClass("alert-danger")) {
          $alert.removeClass("alert-danger");
        }
        if ($alert.hasClass("d-none")) {
          $alert.removeClass("d-none");
        }
        $(".alert-js > .message").html(icon + res.message);
        t.api().ajax.reload();
      },
      error: function (xhr) {
        let res = xhr.responseJSON;
        if (res && res.error) {
          let icon = '<i class="far fa-times-circle"></i> ';
          let $alert = $(".alert-js");

          $alert.addClass("show alert-danger");
          if ($alert.hasClass("alert-info")) {
            $alert.removeClass("alert-info");
          }
          if ($alert.hasClass("d-none")) {
            $alert.removeClass("d-none");
          }

          $(".alert-js > .message").html(icon + res.message);
          t.api().ajax.reload();
        }
      },
      complete: function (xhr) {
        let $token = xhr.getResponseHeader("x-csrf-token");

        if ($token) {
          $meta.attr("content", $token);
        }
        $("#konfirmasi-hapus").modal("hide");
      },
    });
  });
});
