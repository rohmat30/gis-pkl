$(document).ready(function () {
  $(document).tooltip({
    selector: '[rel="tooltip"]',
  });
  let $backTop = $("#back-to-top");
  $(window).on("scroll", function () {
    let scroll_y = $(this).scrollTop();
    let offset = $(".breadcrumb").offset().top;
    let offset_top = parseInt(offset);

    if (scroll_y > offset_top) {
      $backTop.fadeIn();
    } else {
      $backTop.fadeOut();
    }
  });
  $backTop.on("click", function () {
    let scroll_y = parseInt($(window).scrollTop() / 2);
    $("html,body").animate({ scrollTop: 0 }, scroll_y);
  });
});
