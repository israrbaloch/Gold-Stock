import { addCommas } from "./utils";

const MAX_TRADES = 20;

export function setupTables() {
  window.app.historicalData.subscribeCurrent((data) => {
    const ask = window.app.ask;
    const bid = window.app.bid;

    ask.unshift(data.ask);
    bid.unshift(data.bid);

    if (ask.length > MAX_TRADES) {
      ask.pop();
      bid.pop();
    }
    $(".trade-history").empty();

    // for (let i = ask.length-1; i >=0; i--) {
    for (let i = 0; i < ask.length; i++) {
      $(".trade-history").append(
        `<div class="trade-container">
          <div class="text-left ask">${addCommas(
            ask[i] * window.app.currencyRate
          )}</div>
          <div class="text-right bid">${addCommas(
            bid[i] * window.app.currencyRate
          )}</div>
        </div>`
      );
    }
  });
}
