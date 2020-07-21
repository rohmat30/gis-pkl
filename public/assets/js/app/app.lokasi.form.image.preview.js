$(document).ready(function () {
  let $upload_inp = $("#foto");
  let $image = $("img#img-preview");
  let $progress = $("#img-progress");

  $upload_inp.on("change", function (e) {
    let files = e.target.files;
    let file;
    if (typeof $image.data("src") == "undefined") {
      $image.data("src", $image.attr("src"));
    }
    if (files && files.length > 0) {
      file = files[0];
      let type =
        file.type == "image/jpeg" ||
        file.type == "image/png" ||
        file.type == "image/jpg";

      if (type) {
        let render = new FileReader();
        $progress.show();
        render.onload = function (e) {
          $image.attr("src", e.target.result);
        };

        render.onprogress = function (e) {
          if (e.lengthComputable) {
            let progress = parseInt((e.loaded / e.total) * 100);
            let percentage = progress + "%";
            $progress.find(".progress-bar").css("width", percentage);
            $progress.find(".progress-bar").attr("aria-valuenow", progress);

            if (progress >= 100) {
              $progress.hide();
              $progress.find(".progress-bar").css("width", 0);
              $progress.find(".progress-bar").attr("aria-valuenow", 0);
            }
          }
        };
        render.readAsDataURL(file);
      }
    }

    $image.attr("src", $image.data("src"));
  });
});
