import {
  CandlestickData,
  createChart,
  CrosshairMode,
  ISeriesApi,
  Time,
} from "lightweight-charts";
import { tz } from "moment-timezone";
import { CandleInterval, CurrencyWebSocket } from "./interfaces";

export const setupChart = () => {
  // get interval from query param
  const url = new URL(window.location.href);
  const interval = (url.searchParams.get("interval") as CandleInterval) || "1d";

  drawChart(interval);

  // Interval
  $(".chart-interval-container button").on("click", function () {
    $(".chart-interval-container button").removeClass("active");
    $(this).addClass("active");
    const interval = $(this).attr("data-interval") as CandleInterval;
    drawChart(interval);
    // Set query param
    const url = new URL(window.location.href);
    url.searchParams.set("interval", $(this).attr("data-interval") as string);
    window.history.pushState({}, "", url.toString());
  });
  $(".chart-interval-container button").removeClass("active");
  const currentButton = $(
    `.chart-interval-container button[data-interval=${interval}]`
  );
  if (currentButton.length) {
    currentButton.addClass("active");
  } else {
    $(".chart-interval-container button[data-interval=1d]")
      .first()
      .addClass("active");
  }

  $("#chart-interval").on("change", function () {
    const interval = $(this).val() as CandleInterval;
    drawChart(interval);
    // Set query param
    const url = new URL(window.location.href);
    url.searchParams.set("interval", interval);
    window.history.pushState({}, "", url.toString());
  });

  // Comparison
  $(".comparison-buttons-container button").on("click", function () {
    $(".comparison-buttons-container button").removeClass("active");
    $(this).addClass("active");

    const currency = $(this).attr("data-currency") as string;
    $(".comparison-group").removeClass("active");
    $(".comparison-group." + currency.toLowerCase()).addClass("active");
  });

  $(".comparison-buttons-container button").removeClass("active");
  const currentCurrencyButton = $(
    `.comparison-buttons-container button[data-currency=${window.app.currency}]`
  );
  if (currentCurrencyButton.length) {
    currentCurrencyButton.addClass("active");
  } else {
    $(".comparison-buttons-container button[data-currency=USD]")
      .first()
      .addClass("active");
  }

  $(".comparison-group." + window.app.currency.toLowerCase()).addClass(
    "active"
  );
};

let dataFill: CandlestickData[] = [];
const candlestickSeries: ISeriesApi<"Candlestick">[] = [];
let _interval: CandleInterval = "1d";
let _currentCandle: number | any = null;

export const drawChart = (interval?: CandleInterval) => {
  if (!interval) {
    const url = new URL(window.location.href);
    interval = url.searchParams.get("interval") as CandleInterval;
  }

  _interval = interval || "1d";
  _currentCandle = null;
  $.ajax({
    url: "/exchange/prices/history",
    type: "post",
    data: {
      metal: window.app.metal,
      interval,
      currency: window.app.currency,
      currentCurrencyRate: window.app.currencyRate,
      _token: $("meta[name='csrf-token']").attr("content"),
    },
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
    success: function (resp: { data: any[] }) {
      const data = resp.data;

      dataFill = data.map((el) => {

        var currencyRate = el.currency_rate;
        
        
        return {
          time: el.timestamp_id,
          open: el.open * window.app.currencyRate,
          high: el.high * window.app.currencyRate,
          low: el.low * window.app.currencyRate,
          close: el.close * window.app.currencyRate,

          // time: el.timestamp_id,
          // open: el.open * currencyRate,
          // high: el.high * currencyRate,
          // low: el.low * currencyRate,
          // close: el.close * currencyRate,
        };
      });

      
      dataFill = dataFill.reverse();

      const intervalTime = getIntervalTime(_interval);
      let last = dataFill[dataFill.length - 1];
      if (last.time !== intervalTime) {
        const candle = window.app.exchange.candles[_interval];
        if (candle) {
          dataFill.push({
            time: intervalTime,
            open: candle.open * window.app.currencyRate,
            high: candle.high * window.app.currencyRate,
            low: candle.low * window.app.currencyRate,
            close: candle.close * window.app.currencyRate,
          });
        }
      }

      $(".chart").empty();

      if ($(".chart").length) {
        const chartContainers = $(".chart");
        if (!chartContainers) return;

        for (let i = 0; i < chartContainers.length; i++) {
          const chartContainer = chartContainers[i];
          const chart = createChart(chartContainer, {
            width: 0,
            height: 0,
            layout: {
              background: {
                color: "#FFFFFF",
              },
            },
            crosshair: {
              mode: CrosshairMode.Normal,
            },
            grid: {
              vertLines: {
                color: "rgba(197, 203, 206, 0.3)",
              },
              horzLines: {
                color: "rgba(197, 203, 206, 0.3)",
              },
            },
            timeScale: {
              timeVisible: true,
              secondsVisible: false,
              rightOffset: 2
            },
          });

          const _candlestickSeries = chart.addCandlestickSeries({
            upColor: "#00BF76",
            downColor: "#E65764",
            borderDownColor: "#E65764",
            borderUpColor: "#00BF76",
            wickDownColor: "#E65764",
            wickUpColor: "#00BF76",
            lastValueVisible: true,
          });

          _candlestickSeries.setData(dataFill);
          candlestickSeries.push(_candlestickSeries);
        }
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error fetching data:", textStatus, errorThrown);
    },
  });
};

const getIntervalTime = (interval: CandleInterval) => {
  let now = tz("Europe/Helsinki").seconds(0).milliseconds(0);
  switch (interval) {
    case "5m":
      now = now
        .minute(Math.floor(now.minute() / 5) * 5)
        .seconds(0)
        .milliseconds(0);
      break;
    case "15m":
      now = now
        .minute(Math.floor(now.minute() / 15) * 15)
        .seconds(0)
        .milliseconds(0);
      break;
    case "1h":
      now = now.minute(0).seconds(0).milliseconds(0);
      break;
    case "1d":
      now = now.hour(0).minute(0).seconds(0).milliseconds(0);
      break;
  }
  return now.unix() as Time;
};

const processDataCandle = (data: CurrencyWebSocket) => {
  const now = getIntervalTime(_interval);
  if (_currentCandle === null) {
    const last = dataFill[dataFill.length - 1];
    _currentCandle = {
      ...last,
    };
  } else if (_currentCandle.time !== now) {
    _currentCandle = {
      open: _currentCandle.close,
      high: _currentCandle.close,
      low: _currentCandle.close,
      close: _currentCandle.close,
      time: now,
    };
  } else {
    const currentValue = data.value * window.app.currencyRate;
    _currentCandle = {
      ..._currentCandle,
      close: currentValue,
      high: Math.max(_currentCandle.high, currentValue),
      low: Math.min(_currentCandle.low, currentValue),
    };
  }
  return _currentCandle;
};

$(function () {
  const processData = (data: CurrencyWebSocket) => {
    const candle = processDataCandle(data);
    candlestickSeries.forEach((series) => series.update(candle));
  };

  switch (window.app.metal) {
    case "gold":
      window.app.historicalData?.subscribeGold((data: CurrencyWebSocket) => {
        processData(data);
      });
      break;
    case "silver":
      window.app.historicalData?.subscribeSilver((data: CurrencyWebSocket) => {
        processData(data);
      });
      break;
    case "platinum":
      window.app.historicalData?.subscribePlatinum(
        (data: CurrencyWebSocket) => {
          processData(data);
        }
      );
      break;
    case "palladium":
      window.app.historicalData?.subscribePalladium(
        (data: CurrencyWebSocket) => {
          processData(data);
        }
      );
      break;
  }
});
