import { CurrencyWebSocket } from "../exchange/interfaces";
import { addCommas } from "../exchange/utils";

export const processCurrencies = (
  currency: string,
  data: CurrencyWebSocket
) => {
  if (data.currency === window.app.currency) {
    window.app.currencyRate = data.value;
  }
  window.app.currencies[currency] = data;
};

export const processMetal = (prefix: string, data: CurrencyWebSocket) => {
  if (window.app.metal === prefix) {
    window.app.historicalData?.event(data, true);
  }
  window.app.metals[prefix] = data;

  // Current
  $(`.${prefix}-price`).html(
    "$" + addCommas(data.value * window.app.currencyRate)
  );
  $(`.${prefix}-percentage`).html(data.change_percent.toString() + "%");
  $(`.${prefix}-percentage`).removeClass("low high");
  $(`.${prefix}-percentage`).addClass(data.change_percent > 0 ? "high" : "low");
  $(`.${prefix}-high`).html(
    "$" + addCommas(data.daily_highest * window.app.currencyRate)
  );
  $(`.${prefix}-low`).html(
    "$" + addCommas(data.daily_lowest * window.app.currencyRate)
  );

  if (data.change_percent > 0) {
    $(".cogreen-solid." + prefix).removeClass("d-none");
    $(".cogreen-solid." + prefix).addClass("d-inline");
    $(".cored-solid." + prefix).removeClass("d-inline");
    $(".cored-solid." + prefix).addClass("d-none");
  } else {
    $(".cogreen-solid." + prefix).removeClass("d-inline");
    $(".cogreen-solid." + prefix).addClass("d-none");
    $(".cored-solid." + prefix).removeClass("d-none");
    $(".cored-solid." + prefix).addClass("d-inline");
  }

  // USD
  if (window.app.currencies["usd"].value) {
    $(`.${prefix}-usd-price`).html(
      "$" + addCommas(data.value * window.app.currencies["usd"].value)
    );
    $(`.${prefix}-usd-percentage`).html(data.change_percent.toString() + "%");
    $(`.${prefix}-usd-percentage`).removeClass("low high");
    $(`.${prefix}-usd-percentage`).addClass(
      data.change_percent > 0 ? "high" : "low"
    );
    $(`.${prefix}-usd-high`).html(
      "$" + addCommas(data.daily_highest * window.app.currencies["usd"].value)
    );
    $(`.${prefix}-usd-low`).html(
      "$" + addCommas(data.daily_lowest * window.app.currencies["usd"].value)
    );
  }

  // CAD
  if (window.app.currencies["cad"].value) {
    $(`.${prefix}-cad-price`).html(
      "$" + addCommas(data.value * window.app.currencies["cad"].value)
    );
    $(`.${prefix}-cad-percentage`).html(data.change_percent.toString() + "%");
    $(`.${prefix}-cad-percentage`).removeClass("low high");
    $(`.${prefix}-cad-percentage`).addClass(
      data.change_percent > 0 ? "high" : "low"
    );
    $(`.${prefix}-cad-high`).html(
      "$" + addCommas(data.daily_highest * window.app.currencies["cad"].value)
    );
    $(`.${prefix}-cad-low`).html(
      "$" + addCommas(data.daily_lowest * window.app.currencies["cad"].value)
    );
  }

  // EUR
  if (window.app.currencies["eur"].value) {
    $(`.${prefix}-eur-price`).html(
      "$" + addCommas(data.value * window.app.currencies["eur"].value)
    );
    $(`.${prefix}-eur-percentage`).html(data.change_percent.toString() + "%");
    $(`.${prefix}-eur-percentage`).removeClass("low high");
    $(`.${prefix}-eur-percentage`).addClass(
      data.change_percent > 0 ? "high" : "low"
    );
    $(`.${prefix}-eur-high`).html(
      "$" + addCommas(data.daily_highest * window.app.currencies["eur"].value)
    );
  }
};
