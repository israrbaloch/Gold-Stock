import { setFraction } from "../utils";

export default class TradeService {

  public static buy(metal: string, total: number) {
    return $.ajax({
      url: "/metal/buy",
      type: "post",
      data: {
        metal: metal,
        total: setFraction(total, 4),
      },
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
  }

  public static sell(metal: string, amount: number) {
    return $.ajax({
      url: "/metal/sell",
      type: "post",
      data: {
        metal: metal,
        amount: setFraction(amount, 5),
      },
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
  }


}