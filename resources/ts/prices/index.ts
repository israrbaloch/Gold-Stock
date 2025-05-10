import { processCurrencies, processMetal } from "./process";

$(function () {
  if (window.Echo && typeof window.Echo.channel === "function") {
    window.Echo.channel("historical-data").listen("HistoricalEvent", (e) => {
      const data = e.data;
      window.app.historicalData?.event(data);

      switch (data.currency) {
        case "Gold": processMetal("gold", data); break;
        case "Silver": processMetal("silver", data); break;
        case "Platinum": processMetal("platinum", data); break;
        case "Palladium": processMetal("palladium", data); break;
        case "Canadian": processCurrencies("cad", data); break;
        case "Euro": processCurrencies("eur", data); break;
        case "Dollar": processCurrencies("usd", data); break;
      }
    });
  } else {
    console.warn("Echo not ready, channel subscription skipped.");
  }
});

