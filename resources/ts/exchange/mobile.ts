import { drawChart } from "./chart";

export const setupOptions = () => {
  setupMobileButtons();
  setupSelected();

  // get query param
  const url = new URL(window.location.href);
  const option = url.searchParams.get("option");
  if (option) {
    $(".options-container button").removeClass("active");
    $(`.options-container button[data-option=${option}]`).addClass("active");
  }
  selectOption(option, true);

  // options button click
  $(".options-container button").on("click", function () {
    $(".options-container button").removeClass("active");
    $(this).addClass("active");

    selectOption($(this).attr("data-option") as string);

    // set as query param
    const url = new URL(window.location.href);
    url.searchParams.set("option", $(this).attr("data-option") as string);
    window.history.pushState({}, "", url.toString());
  });
};

const selectOption = (option: string | null, firstTime = false) => {
  $(".metals").removeClass("active");
  $(".currencies").removeClass("active");
  $(".chart-container").removeClass("active");
  $(".trade").removeClass("active");
  $(".left-container").removeClass("active");
  $(".right-container").removeClass("active");

  switch (option) {
    case "metals":
      $(".metals").addClass("active");
      $(".left-container").addClass("active");
      break;
    case "currencies":
      $(".currencies").addClass("active");
      $(".left-container").addClass("active");
      break;
    case "chart":
    default:
      $(".chart-container").addClass("active");
      if (!firstTime) {
        drawChart();
      }
      break;
    case "trade":
      $(".trade").addClass("active");
      $(".right-container").addClass("active");
      break;
  }

  // Close trade options
  $(".chart-trade-options-container").removeClass("active");
};

const setupMobileButtons = () => {
  // Mobile trade buttons
  $(".chart-trade-mobile-container button").on("click", function () {
    $(".chart-trade-mobile-container button").removeClass("active");
    $(this).addClass("active");

    $(".chart-trade-options-container").addClass("active");

    $(".chart-trade-option").removeClass("active");
    switch ($(this).attr("data-option")) {
      case "buy":
        $(".chart-trade-option.buy").addClass("active");
        break;
      case "sell":
        $(".chart-trade-option.sell").addClass("active");
        break;
    }
  });

  // Back button
  $(".button-back").on("click", function () {
    $(".chart-trade-options-container").removeClass("active");
  });
};

const setupSelected = () => {
  $(".exchange-selected").on("change", function () {
    const id = $(this).val();
    window.location.href = "/exchange/" + id;
  });
};
