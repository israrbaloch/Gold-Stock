import Echo from "laravel-echo";
import Pusher from "pusher-js";
import { setupAlert } from "./alert";
import { HistoricalSubscription } from "./exchange/classes/historicalSubscription";

window.Pusher = Pusher;

$(function () {
  $("#mobile-sidebar-button").on("click", function () {
    $("#sidebar").removeClass("d-none");
    $("#sidebar").addClass("active");
  });
  $("#menu-item-close").on("click", function () {
    $("#sidebar").addClass("d-none");
    $("#sidebar").removeClass("active");
  });

  dropDownActions(false);

  const currency = $("body").attr("data-currency");
  let imgCountry = "Canada";
  switch (currency) {
    case "CAD":
      imgCountry = "Canada";
      break;
    case "EUR":
      imgCountry = "EUR";
      break;
    case "USD":
      imgCountry = "USA";
      break;
  }

  const parent = $(".ic-currency-flags");
  const dropdownImage = $(parent).find(".dropdown-toggle img")[0];
  const dropdown = $(parent).find(".dropdown-toggle")[0];

  const src = $(dropdownImage).attr("src");
  if (src) {
    const gscSrc = src
      .replace("Canada", imgCountry)
      .replace("USA", imgCountry)
      .replace("EUR", imgCountry);
    $(dropdownImage).attr("src", gscSrc);
  }

  if (currency) {
    $(dropdown).attr("data-currency", currency);
    const dropDownSpan = $(dropdown).find("span")[0];
    const gscHtml = $(dropDownSpan)
      .text()
      .replace("CAD", currency)
      .replace("USD", currency)
      .replace("EUR", currency);
    $(dropDownSpan).text(gscHtml);
    const listCurrencies = ["CAD", "USD", "EUR"];
    const currencyId = listCurrencies.indexOf(currency);

    if (currencyId) {
      const dropDownItems = $(parent).find(".dropdown-item");
      const listImages = ["Canada.", "USA.", "EUR."];

      for (let i = 0, dropdownId = 0, used = -1; i < 3; i++) {
        if (i !== currencyId && i !== used) {
          const img = $(dropDownItems[dropdownId]).find("img")[0];
          const src = $(img).attr("src");
          const span = $(dropDownItems[dropdownId]).find("span")[0];
          const thisOldHtml = $(span).text();
          if (src) {
            const gscSrc = src
              .replace("Canada.", listImages[i])
              .replace("USA.", listImages[i])
              .replace("EUR.", listImages[i]);
            if (gscSrc) {
              $(dropDownItems[dropdownId]).find("img").attr("src", gscSrc);
            }
          }
          const thisNewHtml = thisOldHtml
            .replace("CAD", listCurrencies[i])
            .replace("USD", listCurrencies[i])
            .replace("EUR", listCurrencies[i]);
          $(dropDownItems[dropdownId]).attr("data-currency", listCurrencies[i]);
          $(span).text(thisNewHtml);
          dropdownId++;
          used = i;
        }
      }
    }
  }

  $("#ic-currency-flags-desktop").on("click", function () {
    dropDownActions(true);
  });
  $(window).on("click", function (e) {
    if (
      typeof $(this).attr("class") === "undefined" &&
      $(e.target).is(":not(ul, ul *)") &&
      $(e.target).is(":not(a, a *)")
    ) {
      dropDownActions(false);
      const element = $(".history-hover");
      element.fadeOut("fast");
    }
  });
  $(".js-change-currency").on("click", function () {
    const oldCurrency = $("body").attr("data-currency");
    const newCurrency = $(this).attr("data-currency");

    if (newCurrency && newCurrency !== oldCurrency) {
      setCookie(newCurrency);
    }
  });
  $(document).on("mouseenter", ".history-hover-trigger", function (e) {
    const element = $(".history-hover");
    element.fadeIn("fast");
  });

  $(document).on("mouseleave", ".history-hover", function (e) {
    const element = $(".history-hover");
    element.fadeOut("fast");
  });

  $.ajax({
    url: "/cart/quantity",
    type: "get",
    success: function (res) {
      const quantity = res.totalQuantity;
      if (quantity > 0) {
        $(".cart-quantity").removeClass("d-none");
        $(".cart-quantity").each(function () {
          $(this).html(res.totalQuantity);
        });
      }
    },
  });
});

function dropDownActions(isClick: boolean) {
  const parent = $(".ic-currency-flags");
  const dropDownItems = $(parent).find(".dropdown-menu");
  if (isClick) {
    if ($(dropDownItems).hasClass("hide")) {
      $(dropDownItems).addClass("show");
      $(dropDownItems).removeClass("hide");
    } else {
      $(dropDownItems).removeClass("show");
      $(dropDownItems).addClass("hide");
    }
  } else {
    $(dropDownItems).removeClass("show");
    $(dropDownItems).addClass("hide");
  }
}
function setCookie(currency: string) {
  const newCurrency = currency;
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  $.ajax({
    url: "/setcookie",
    data: {
      currency: newCurrency,
    },
    type: "post",
    success: function (res) {
      document.location.reload();
    },
  });
}

$(function () {
  setupAlert();
});

window.Echo = new Echo({
  broadcaster: "pusher",
  key: process.env.MIX_PUSHER_APP_KEY || "local",
  cluster: process.env.MIX_PUSHER_APP_CLUSTER || "mt1",
  forceTLS: false,
  wsHost: window.location.hostname,
  wsPort: window.app.wsPort,
  disableStats: true,
  enabledTransports: ["ws", "wss"],
  reconnect: {
    maxAttempts: 5,
    delay: 1000,
    maxDelay: 5000,
  },
});

window.app.historicalData = new HistoricalSubscription();
