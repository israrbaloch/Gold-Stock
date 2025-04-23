import Echo from "laravel-echo";
import { HistoricalSubscription } from "./exchange/classes/historicalSubscription";
import {
  Candle,
  CurrencyWebSocket
} from "./exchange/interfaces";

declare global {
  interface Window {
    Echo: Echo;
    Pusher: any;
    app: {
      env: string;
      wsPort: string;
      currencyRate: number;
      currency: string;
      balances: { [key: string]: number };
      currencies: { [key: string]: CurrencyWebSocket };
      metals: { [key: string]: CurrencyWebSocket };

      historicalData: HistoricalSubscription;

      // Exchange
      metal: string;
      currentMetal: CurrencyWebSocket;
      ask: number[];
      bid: number[];
      exchange: {
        candles: { [key: string]: Candle };
      };
    };
  }
}
