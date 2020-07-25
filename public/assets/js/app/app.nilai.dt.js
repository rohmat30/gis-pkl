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
        data: "nilai_id",
        orderable: false,
        className: "text-center",
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        },
      },
      {
        data: "nama_siswa",
        orderable: false,
        className: "text-nowrap border-left",
      },
      {
        data: "tanggal",
        orderable: false,
        searchable: false,
        className: "border-left",
        render: function (data) {
          if (data == null) {
            return "-";
          }
          let date = data.split("-");
          return date[2] + "/" + date[1] + "/" + date[0];
        },
      },
      {
        data: "kehadiran",
        orderable: false,
        className: "border-left text-right",
        render: function (data) {
          return ~~data;
        },
      },
      {
        data: "nilai_lapangan",
        orderable: false,
        className: "border-left text-right",
        render: function (data) {
          return ~~data;
        },
      },
      {
        data: "nilai_keterampilan",
        orderable: false,
        className: "border-left text-right",
        render: function (data) {
          return ~~data;
        },
      },
      {
        data: "nilai_kehadiran",
        orderable: false,
        className: "border-left text-right",
        render: function (data) {
          return ~~data;
        },
      },
      {
        data: "total",
        orderable: false,
        searchable: false,
        className: "border-left text-right",
        render: function (data) {
          return ~~data;
        },
      },
      {
        data: "grade",
        orderable: false,
        className: "border-left text-center",
        render: function (data) {
          let grade = data.toUpperCase();
          let color = "muted";
          switch (grade) {
            case "A":
              color = "primary";
              break;
            case "B":
              color = "success";
              break;
            case "C":
              color = "warning";
              break;
            case "D":
              color = "danger";
              break;
          }
          return `<span class="bg-${color} d-inline-block px-1 rounded text-white">${grade}</span>`;
        },
      },
      {
        data: "keterangan",
        orderable: false,
        searchable: false,
        className: "border-left",
      },
      {
        data: "aksi",
        orderable: false,
        className: "border-left text-nowrap",
        render: function (aksi) {
          let action = `<button type="button" data-url="${
            aksi.detail
          }" data-change="${
            aksi.edit != undefined ? aksi.edit : ""
          }" class="btn btn-outline-success btn-icon btn-xs detail" rel="tooltip" data-placement="bottom" title="Detail"  data-toggle="modal" data-target="#show-detail"> <i class="far fa-id-card"></i></button> `;
          if (aksi.edit) {
            action += `<a href="${aksi.edit}" class="btn btn-outline-primary btn-icon btn-xs" rel="tooltip" data-placement="bottom" title="Edit"> <i class="far fa-edit"></i></a>`;
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

  $("#show-detail").on("show.bs.modal", function (e) {
    let url = $(e.relatedTarget).data("url");
    let change = $(e.relatedTarget).data("change");
    let self = $(this);
    self.find(".modal-body").html("Loading...");
    self.find(".modal-footer > a.change").attr("href", change);
    $.get(url, function (res) {
      self.find(".modal-body").html(res);
    });
  });

  $("#show-detail").on("hidden.bs.modal", function () {
    $(this).find(".modal-body").html("");
    $(this).find(".modal-footer > a.change").attr("href", "");
  });
});
