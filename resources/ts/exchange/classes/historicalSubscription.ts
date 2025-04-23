import { CurrencyWebSocket } from "../interfaces";

export class HistoricalSubscription {
  currentMetal: ((data: CurrencyWebSocket) => void)[] = [];

  gold: ((data: CurrencyWebSocket) => void)[] = [];
  silver: ((data: CurrencyWebSocket) => void)[] = [];
  platinum: ((data: CurrencyWebSocket) => void)[] = [];
  palladium: ((data: CurrencyWebSocket) => void)[] = [];

  canadians: ((data: CurrencyWebSocket) => void)[] = [];
  euros: ((data: CurrencyWebSocket) => void)[] = [];

  subscribeCurrent(callback: (data: CurrencyWebSocket) => void) {
    this.currentMetal.push(callback);
  }

  subscribeGold(callback: (data: CurrencyWebSocket) => void) {
    this.gold.push(callback);
  }

  subscribeSilver(callback: (data: CurrencyWebSocket) => void) {
    this.silver.push(callback);
  }

  subscribePlatinum(callback: (data: CurrencyWebSocket) => void) {
    this.platinum.push(callback);
  }

  subscribePalladium(callback: (data: CurrencyWebSocket) => void) {
    this.palladium.push(callback);
  }

  subscribeCanadian(callback: (data: CurrencyWebSocket) => void) {
    this.canadians.push(callback);
  }

  subscribeEuro(callback: (data: CurrencyWebSocket) => void) {
    this.euros.push(callback);
  }

  unsubscribeCurrent(callback: (data: CurrencyWebSocket) => void) {
    this.currentMetal = this.currentMetal.filter((cb) => cb !== callback);
  }

  unsubscribeGold(callback: (data: CurrencyWebSocket) => void) {
    this.gold = this.gold.filter((cb) => cb !== callback);
  }

  unsubscribeSilver(callback: (data: CurrencyWebSocket) => void) {
    this.silver = this.silver.filter((cb) => cb !== callback);
  }

  unsubscribePlatinum(callback: (data: CurrencyWebSocket) => void) {
    this.platinum = this.platinum.filter((cb) => cb !== callback);
  }

  unsubscribePalladium(callback: (data: CurrencyWebSocket) => void) {
    this.palladium = this.palladium.filter((cb) => cb !== callback);
  }

  unsubscribeCanadian(callback: (data: CurrencyWebSocket) => void) {
    this.canadians = this.canadians.filter((cb) => cb !== callback);
  }

  unsubscribeEuro(callback: (data: CurrencyWebSocket) => void) {
    this.euros = this.euros.filter((cb) => cb !== callback);
  }

  event(data: CurrencyWebSocket, current = false) {
    if (current) {
      this.currentMetal.forEach((cb) => cb(data));
      return;
    }
    switch (data.currency) {
      case "Gold":
        this.gold.forEach((cb) => cb(data));
        break;
      case "Silver":
        this.silver.forEach((cb) => cb(data));
        break;
      case "Platinum":
        this.platinum.forEach((cb) => cb(data));
        break;
      case "Palladium":
        this.palladium.forEach((cb) => cb(data));
        break;
      case "Canadian":
        this.canadians.forEach((cb) => cb(data));
        break;
      case "Euro":
        this.euros.forEach((cb) => cb(data));
        break;
    }
  }
}
