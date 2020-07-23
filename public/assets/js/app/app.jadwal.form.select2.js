$(document).ready(function () {
  function temp(state) {
    if (!state.id) return state.text;
    return $(`<span class="font-14">${state.text} (${state.username})</span>`);
  }

  function tempInstansi(state) {
    if (!state.id) return state.text;
    return $(`
    <img src="${state.photo}" width=32 height=32/>
    <span class="font-14">${state.text}</span>`);
  }

  let sURL = $("#siswa_id").data("url");
  $("#siswa_id").select2({
    templateResult: temp,
    width: "100%",
    placeholder: $("#siswa_id").attr("placeholder"),
    delay: 200,
    theme: "bootstrap4",
    ajax: {
      url: sURL,
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
              id: item.user_id,
              text: item.nama,
              username: item.username,
            };
          }),
        };
      },
    },
  });

  let pURL = $("#pembimbing_id").data("url");
  $("#pembimbing_id").select2({
    templateResult: temp,
    width: "100%",
    placeholder: $("#pembimbing_id").attr("placeholder"),
    delay: 200,
    theme: "bootstrap4",
    ajax: {
      url: pURL,
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
              id: item.user_id,
              text: item.nama,
              username: item.username,
            };
          }),
        };
      },
    },
  });

  let plURL = $("#pl_id").data("url");
  $("#pl_id").select2({
    templateResult: temp,
    width: "100%",
    placeholder: $("#pl_id").attr("placeholder"),
    delay: 200,
    theme: "bootstrap4",
    ajax: {
      url: plURL,
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
              id: item.user_id,
              text: item.nama,
              username: item.username,
            };
          }),
        };
      },
    },
  });

  let inURL = $("#instansi_id").data("url");
  $("#instansi_id").select2({
    templateResult: tempInstansi,
    width: "100%",
    placeholder: $("#instansi_id").attr("placeholder"),
    delay: 200,
    theme: "bootstrap4",
    ajax: {
      url: inURL,
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
              id: item.instansi_id,
              text: item.nama_instansi,
              photo: item.foto,
            };
          }),
        };
      },
    },
  });
});
