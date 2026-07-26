(function ($) {
  "use strict";

  function resetMovieBookingCheckoutLoader() {
    var $checkout = $(".cart_detail .cart-sidebar .cart-checkout");

    if (!$checkout.length) {
      return;
    }

    $checkout.find(".submit-load-more").css("z-index", -1);
  }

  $(document).on("ajaxComplete ajaxError", function (_event, _xhr, settings) {
    var data = settings && settings.data ? String(settings.data) : "";

    if (data.indexOf("action=mb_process_checkout") !== -1) {
      resetMovieBookingCheckoutLoader();
    }
  });

  $(document).on("click", ".cart_detail .cart-sidebar #mb-btn-checkout", function () {
    setTimeout(resetMovieBookingCheckoutLoader, 10000);
  });

  $(function () {
    resetMovieBookingCheckoutLoader();
  });
})(jQuery);
