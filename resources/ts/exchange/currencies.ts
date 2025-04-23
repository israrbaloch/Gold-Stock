export const setupCurrencies = () => {
  $(".exchange-currencies-container button").on("click", function () {
    const currency = $(this).data("currency");

    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
    $.ajax({
      url: "/setcookie",
      data: {
        currency,
      },
      type: "post",
      success: function (res) {
        document.location.reload();
      },
    });
  });

  $(".exchange-currencies-container button").each(function () {
    if (
      ($(this).data("currency") as string).toLowerCase() ===
      window.app.currency.toLowerCase()
    ) {
      $(this).addClass("active");
    }
  });
};
