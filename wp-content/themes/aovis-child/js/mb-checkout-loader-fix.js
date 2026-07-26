(function ($) {
  "use strict";

  function getCheckoutScope() {
    return $(".cart_detail .cart-sidebar .cart-checkout");
  }

  function isMovieBookingCheckoutRequest(settings) {
    if (!settings || !settings.data) {
      return false;
    }

    if (typeof settings.data === "string") {
      return settings.data.indexOf("action=mb_process_checkout") !== -1;
    }

    if (typeof settings.data === "object") {
      return settings.data.action === "mb_process_checkout";
    }

    return false;
  }

  function showMovieBookingCheckoutLoader() {
    var $checkout = getCheckoutScope();

    if (!$checkout.length) {
      return;
    }

    $checkout.addClass("mb-checkout-loading");
  }

  function resetMovieBookingCheckoutLoader() {
    var $checkout = getCheckoutScope();

    if (!$checkout.length) {
      return;
    }

    $checkout.removeClass("mb-checkout-loading");
    $checkout.find(".submit-load-more").css("z-index", -1);
  }

  $(document).on("ajaxSend", function (_event, _xhr, settings) {
    if (isMovieBookingCheckoutRequest(settings)) {
      showMovieBookingCheckoutLoader();
    }
  });

  $(document).on("ajaxComplete ajaxError", function (_event, _xhr, settings) {
    if (isMovieBookingCheckoutRequest(settings)) {
      resetMovieBookingCheckoutLoader();
    }
  });

  $(document).on("click", ".cart_detail .cart-sidebar #mb-btn-checkout", function () {
    showMovieBookingCheckoutLoader();
    setTimeout(resetMovieBookingCheckoutLoader, 10000);
  });

  $(function () {
    resetMovieBookingCheckoutLoader();
  });
})(jQuery);
