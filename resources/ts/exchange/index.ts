import { setupChart } from "./chart";
import { setupCurrencies } from "./currencies";
import { setupOptions } from "./mobile";
import { setupTables } from "./table";
import ExchangeTrade from "./trade";

$(function () {
  setupChart();
  setupTables();

  setupOptions();
  ExchangeTrade.setup();
  setupCurrencies();
});
