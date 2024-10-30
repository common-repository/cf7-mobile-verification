(function($) {
  "use strict";

  /**
   * Toggles the mobile input field on the click on Create mobile input field.
   */
  $(".cf7mv-mob-input").on("click", function() {
    if ("checked" === $(this).attr("checked")) {
      var inputVal = $(this).val();
      if ("No" === inputVal) {
        $("#cf7mv_mobile_input_name").removeClass("cf7mv-hide");
      } else if ("Yes" === inputVal) {
        $("#cf7mv_mobile_input_name").addClass("cf7mv-hide");
        $(".cf7mv_mob_input_name").val("");
      }
    }
  });
})(jQuery);
window.addEventListener("load", function() {
  // store tabs variables
  var tabs = document.querySelectorAll("ul.nav-tabs > li");

  for (var i = 0; i < tabs.length; i++) {
    tabs[i].addEventListener("click", switchTab);
  }

  function switchTab(event) {
    event.preventDefault();

    document.querySelector("ul.nav-tabs li.active").classList.remove("active");
    document.querySelector(".tab-pane.active").classList.remove("active");

    var clickedTab = event.currentTarget;
    var anchor = event.target;
    var activePaneID = anchor.getAttribute("href");

    clickedTab.classList.add("active");
    document.querySelector(activePaneID).classList.add("active");
  }
});
