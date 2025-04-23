export type MetalPrices = {
  ask: number;
  bid: number;
  change_percent: number;
  current_value: number;
};

export interface ComparisonResponse {
  gold: Metal;
  silver: Metal;
  platinum: Metal;
  palladium: Metal;
}

interface Metal {
  value: number;
  change: number;
}

export interface CurrencyWebSocket {
  currency: string;
  value: number;
  change: number;
  change_percent: number;
  daily_lowest: number;
  daily_highest: number;
  date: string;
  ask: number;
  bid: number;
}

export interface Currency {
  sprofit: number;
  bprofit: number;
  sfakeprice: number;
  bfakeprice: number;
  lowest: number;
  highest: number;
  change_percent: number;
  current_value: number;
  ask: number;
  bid: number;
  sellingounce: number;
  buyingounce: number;
  sellingkilo: number;
  buyingkilo: number;
}

export type CandleInterval = "1m" | "5m" | "15m" | "1h" | "1d";
export interface Candle {
  timestamp: number;
  open: number;
  high: number;
  low: number;
  close: number;
}

export interface IHistoricalSubscription {
  gold: Array<(data: CurrencyWebSocket) => void>;
  silver: Array<(data: CurrencyWebSocket) => void>;
  platinum: Array<(data: CurrencyWebSocket) => void>;
  palladium: Array<(data: CurrencyWebSocket) => void>;

  subscribeGold(callback: (data: CurrencyWebSocket) => void): void;
  subscribeSilver(callback: (data: CurrencyWebSocket) => void): void;
  subscribePlatinum(callback: (data: CurrencyWebSocket) => void): void;
  subscribePalladium(callback: (data: CurrencyWebSocket) => void): void;

  unsubscribeGold(callback: (data: CurrencyWebSocket) => void): void;
  unsubscribeSilver(callback: (data: CurrencyWebSocket) => void): void;
  unsubscribePlatinum(callback: (data: CurrencyWebSocket) => void): void;
  unsubscribePalladium(callback: (data: CurrencyWebSocket) => void): void;

  eventGold(data: CurrencyWebSocket): void;
  eventSilver(data: CurrencyWebSocket): void;
  eventPlatinum(data: CurrencyWebSocket): void;
  eventPalladium(data: CurrencyWebSocket): void;
}
