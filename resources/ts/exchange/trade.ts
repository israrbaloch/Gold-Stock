import Decimal from "decimal.js";
import { CurrencyWebSocket } from "./interfaces";
import TradeService from "./services/trade.services";
import { addCommas, removeFormat, setFraction } from "./utils";

type TradeMode = "amount" | "total";
type TradeTypes = "buy" | "sell";

let buyMode: TradeMode = "amount";
let sellMode: TradeMode = "amount";

export default class ExchangeTrade {
  public static readonly setup = () => {
    this.setPercentageButtons();
    this.setOnPriceChange();
    this.setOnAmountTotalChange();
    this.setButtonActions();
    this.setDisableDragDrop();
  };

  private static readonly setPercentageButtons = () => {
    $(".percentage-button").each(function () {
      $(this).on("click", function () {
        const percent = Number($(this).attr("data-percentage")) / 100;
        const mode = $(this).attr("data-mode");

        const metalBalance = window.app.balances[window.app.metal];
        let cashBalance = new Decimal(window.app.balances["cash"]);

        if (mode === "buy") {
          const totalBuy = cashBalance.mul(percent);
          ExchangeTrade.setTotal(
            totalBuy.toNumber(),
            "buy"
          );

          const amountBuy = ExchangeTrade.calcAmount(totalBuy);
          ExchangeTrade.setAmount(amountBuy.toNumber(), "buy");

          ExchangeTrade.setFee("buy");
          // Set the total static
          buyMode = "total";
        } else {
          const amountSell = metalBalance * percent;
          ExchangeTrade.setAmount(amountSell, "sell");
          const totalSell = window.app.currentMetal.value * window.app.currencyRate * amountSell;
          ExchangeTrade.setTotal(
            totalSell,
            "sell"
          );
          ExchangeTrade.setFee("sell");
          // Set the amount static
          sellMode = "amount";
        }
      });
    });
  };

  private static readonly setOnPriceChange = () => {
    window.app.historicalData?.subscribeCurrent((data: CurrencyWebSocket) => {
      window.app.currentMetal = data;
      priceChange(data);
    });

    const priceChange = (data: CurrencyWebSocket) => {
      const metalPrice = new Decimal(data.value * window.app.currencyRate);

      // Buy
      if (buyMode === "amount") {
        $("#price-buy")
          .val("$" + addCommas(metalPrice.toNumber(), 4))
          .prop("disabled", true);
        const amountBuy = Number($("#amount-buy").val() as string);
        ExchangeTrade.setTotal(metalPrice.mul(amountBuy).toNumber(), "buy");
      } else {
        const totalBuy = new Decimal(removeFormat($("#total-buy").val() as string));
        const amountBuy = ExchangeTrade.calcAmount(totalBuy);
        ExchangeTrade.setAmount(amountBuy.toNumber(), "buy");
      }
      ExchangeTrade.setFee("buy");

      // Sell
      if (sellMode === "amount") {
        $("#price-sell")
          .val("$" + addCommas(metalPrice.toNumber(), 4))
          .prop("disabled", true);
        const amountSell = Number($("#amount-sell").val() as string);
        ExchangeTrade.setTotal(metalPrice.mul(amountSell).toNumber(), "sell");
      } else {
        const totalSell = new Decimal(removeFormat($("#total-sell").val() as string));
        const amountSell = totalSell.div(metalPrice);
        ExchangeTrade.setAmount(amountSell.toNumber(), "sell");
      }
      ExchangeTrade.setFee("sell")
    };
    priceChange(window.app.currentMetal);
  };

  private static readonly setOnAmountTotalChange = () => {
    // Buy
    $("#amount-buy").on("input", function () {
      const amountBuy = ExchangeTrade.getAmount("buy");
      ExchangeTrade.setTotal(
        window.app.currentMetal.value * window.app.currencyRate * amountBuy,
        "buy"
      );
      buyMode = "amount";
      ExchangeTrade.setFee("buy")
    });
    $("#total-buy").on("input", function () {
      ExchangeTrade.setAmountFromTotal(this, "buy");
      buyMode = "total";
      ExchangeTrade.setFee("buy")
    });

    // Sell
    $("#amount-sell").on("input", function () {
      const amountSell = ExchangeTrade.getAmount("sell");
      ExchangeTrade.setTotal(
        window.app.currentMetal.value * window.app.currencyRate * amountSell,
        "sell"
      );
      sellMode = "amount";
      ExchangeTrade.setFee("sell")
    });
    $("#total-sell").on("input", function () {
      ExchangeTrade.setAmountFromTotal(this, "sell");
      sellMode = "total";
      ExchangeTrade.setFee("sell")
    });

    // Focus
    const onFocus = (el: JQuery<HTMLElement>) => {
      $(el).on("focus", function () {
        // select all text
        $(this).trigger("select");
      });
    };
    onFocus($("#amount-buy"));
    onFocus($("#amount-sell"));
    onFocus($("#total-buy"));
    onFocus($("#total-sell"));

    // Blur
    const onTotalBlur = (el: JQuery<HTMLElement>, type: TradeTypes) => {
      $(el).on("blur", function () {
        ExchangeTrade.setTotal(ExchangeTrade.getTotal(type), type);
      });
    };
    onTotalBlur($("#total-buy"), "buy");
    onTotalBlur($("#total-sell"), "sell");

    const onAmountBlur = (el: JQuery<HTMLElement>, type: TradeTypes) => {
      $(el).on("blur", function () {
        ExchangeTrade.setAmount(ExchangeTrade.getAmount(type), type);
      });
    };
    onAmountBlur($("#amount-buy"), "buy");
    onAmountBlur($("#amount-sell"), "sell");
  };

  private static readonly setButtonActions = () => {
    // Buy Button
    $("#button-buy").on("click", function (e) {
      e.preventDefault();
      // set loading state
      $(this).prop("disabled", true);

      const total = ExchangeTrade.getTotal("buy");
      if (total <= 0) {
        return;
      }
      const metal = window.app.metal;

      TradeService.buy(metal, total).then((res) => {
        if (res.success) {
          window.app.balances[metal] = Number(res.data.amount);
          window.app.balances["cash"] = Number(res.data.total);
          $(".sell-available").html(window.app.balances[metal].toFixed(5));
          $(".buy-available").html(addCommas(window.app.balances["cash"], 4));
          alert("Transaction completed successfully");
        }
      }).catch((xhr: any, status, error) => {
        switch (xhr.status) {
          case 401:
            window.location.href = "/login?redirect=/exchange";
            break;
          case 402:
            // open new tab in /funds with alert query param
            window.open("/funds?alert=Insufficient funds", "_blank");
            break;
        }
      }).always(() => {
        // reset loading state
        $("#button-buy").prop("disabled", false);
      })
    });

    // Sell Button
    $("#button-sell").on("click", function (e) {
      e.preventDefault();
      // set loading state
      $(this).prop("disabled", true);

      const amount = Number($("#amount-sell").val());
      if (amount <= 0) {
        return;
      }
      const metal = window.app.metal;
      TradeService.sell(metal, amount).then((res) => {
        if (res.success) {
          window.app.balances[metal] = Number(res.data.amount);
          window.app.balances["cash"] = Number(res.data.total);
          $(".sell-available").html(window.app.balances[metal].toFixed(5));
          $(".buy-available").html(addCommas(window.app.balances["cash"], 4));
          alert("Transaction completed successfully");
        }
      }).catch((xhr: any, status, error) => {
        switch (xhr.status) {
          case 401:
            window.location.href = "/login?redirect=/exchange";
            break;
          case 402:
            // open new tab in /funds with alert query param
            window.open("/funds?alert=Insufficient " + metal, "_blank");
        }
      }).always(() => {
        // reset loading state
        $("#button-sell").prop("disabled", false);
      }
      );

    });
  };

  private static readonly setDisableDragDrop = () => {
    $("#amount-buy, #total-buy, #amount-sell, #total-sell").on(
      "dragstart drop dragover dragenter dragleave dragend",
      function (e) {
        e.preventDefault();
      }
    );
  };

  private static readonly setAmount = (amount: number, type: TradeTypes) => {
    // check NaN
    if (isNaN(amount)) {
      amount = 0;
    }
    if (amount < 0) {
      amount = 0;
    }
    $(`#amount-${type}`).val(amount.toFixed(5));
    $(`#button-${type}`).prop("disabled", amount <= 0);
  };

  private static readonly getAmount = (type: TradeTypes) => {
    return setFraction(Number($(`#amount-${type}`).val()), 5)
  }

  private static readonly setAmountFromTotal = (
    el: HTMLElement,
    type: TradeTypes
  ) => {
    let total = $(el).val() as string;
    const _total = total.replace(/[^0-9-\.$,]/g, "");

    if (total != _total) {
      total = _total;
    }

    let totalValue = removeFormat(total);
    if (isNaN(totalValue) || totalValue < 0) {
      totalValue = 0;
    }

    const amount =
      totalValue / (window.app.currentMetal.value * window.app.currencyRate);

    $(`#amount-${type}`).val(setFraction(amount, 4));
    // if selected, select all text
    if ($(`#amount-${type}`).is(":focus")) {
      $(`#amount-${type}`).trigger("select");
    }
    $(`#button-${type}`).prop("disabled", amount <= 0);
  };


  private static readonly calcAmount = (totalBuy: Decimal) => {
    const totalBuyAfterFee = totalBuy.minus(totalBuy.mul(ExchangeTrade.getPercentFee()));
    return totalBuyAfterFee.div
      (window.app.currentMetal.value * window.app.currencyRate)
  }

  private static readonly setTotal = (total: number, type: TradeTypes) => {
    // check NaN
    if (isNaN(total)) {
      total = 0;
    }
    if (total < 0) {
      total = 0;
    }
    $(`#total-${type}`).val(`$${addCommas(total, 4)}`);
    // if selected, select all text
    if ($(`#total-${type}`).is(":focus")) {
      $(`#total-${type}`).trigger("select");
    }
    $(`#button-${type}`).prop("disabled", total <= 0);
  };

  private static readonly getTotal = (type: TradeTypes) => {
    return setFraction(Number(removeFormat($(`#total-${type}`).val() as string)), 4)
  }

  private static readonly getPercentFee = () => {
    switch (window.app.metal) {
      case "gold":
        return 0.01;
      case "silver":
        return 0.02;
      case "platinum":
      case "palladium":
        return 0.05;
      default:
        console.error("Invalid metal");
        break;
    }
    return 0
  }

  private static readonly setFee = (type: TradeTypes) => {
    const totalElement = $(`#total-${type}`);
    let total = Number(removeFormat($(totalElement).val() as string));

    if (isNaN(total) || total < 0) {
      total = 0;
    }

    const percent = this.getPercentFee();
    const fee = setFraction(total * percent, 5);

    $(`#fee-${type}`)
      .val(
        `$${addCommas(
          fee,
          4
        )}`
      );
  };
}
