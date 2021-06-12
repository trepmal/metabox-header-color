jQuery(document).ready(function ($) {
  $("#hex_code_bg").wpColorPicker({
    change: function (event, ui) {
      //   console.log(ui.color.toString());
      $("h2.hndle").css({ backgroundColor: ui.color.toString() });
    },
  });

  $("#hex_code_tx").wpColorPicker({
    change: function (event, ui) {
      $("h2.hndle").css({ color: ui.color.toString() });
    },
  });

  $("#hex_code_sh").wpColorPicker({
    change: function (event, ui) {
      $("h2.hndle").css({ textShadow: "0 1px 0 " + ui.color.toString() });
    },
  });
});
