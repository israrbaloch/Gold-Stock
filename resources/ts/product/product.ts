import { CurrencyWebSocket } from "../exchange/interfaces";
import { addCommas } from "../exchange/utils";
import { Product } from "../shop/interface";

import { setupProductDetails } from "./details";

declare const product: Product;

$(document).ready(() => {
    setupProductDetails();

    window.app.historicalData.subscribeGold((gold) => {
        if (product.metal_id == 1183) {
            processProduct(product, gold);
        }
    });
    window.app.historicalData.subscribeSilver((silver) => {
        if (product.metal_id == 1677) {
            processProduct(product, silver);
        }
    });
    window.app.historicalData.subscribePlatinum((platinum) => {
        if (product.metal_id == 1681) {
            processProduct(product, platinum);
        }
    });
    window.app.historicalData.subscribePalladium((palladium) => {
        if (product.metal_id == 1682) {
            processProduct(product, palladium);
        }
    });

    $(".onlyNumber").on("keypress keyup blur", function (event: JQuery.Event) {
        const inputElement = $(this);

        // Ensure the current value is a string
        const currentValue = (inputElement.val() as string) || "";

        // Replace any non-digit characters
        inputElement.val(currentValue.replace(/[^\d]/g, ""));

        // Prevent non-digit keypresses
        if (event.type === "keypress") {
            const key = event.key; // Use event.key instead of event.which
            if (!key || key < "0" || key > "9") {
                event.preventDefault();
            }
        }

        // min can be set to 1, max can be set to 999
        const min = Number(inputElement.attr("min")) || 1;
        const max = Number(inputElement.attr("max")) || 999;
        let newValue = Number(inputElement.val()) || min;
        newValue = Math.min(max, Math.max(min, newValue));
        inputElement.val(newValue);
    });

    // #quantity-decrement, #quantity-increment
    $("#quantity-decrement, #quantity-increment").on("click", function () {
        const inputElement = $("#quantity");
        const currentValue = Number(inputElement.val()) || 0;
        const step = Number(inputElement.attr("step")) || 1;
        const min = Number(inputElement.attr("min")) || 0;
        const max = Number(inputElement.attr("max")) || Infinity;

        let newValue = currentValue + (this.id === "quantity-increment" ? step : -step);
        newValue = Math.min(max, Math.max(min, newValue));
        inputElement.val(newValue);
    });
});

function processProduct(product: Product, metal: CurrencyWebSocket) {
    const priceSpan = $(`#price`)
    if (!priceSpan) return;

    var original_price = Number(product.weight_oz) * metal.value * window.app.currencyRate;
    // const price = original_price + original_price * product.percent_interval_1 / 100;
    const price = original_price + product.percent_interval_1;
    priceSpan.html(addCommas(price));

    const interval1 = $(`#interval1`)
    if (!interval1) return;
    // const priceInterval1 = original_price + original_price * product.percent_interval_1 / 100;
    const priceInterval1 = original_price + product.percent_interval_1;
    interval1.html(addCommas(priceInterval1));


    const interval2 = $(`#interval2`)
    if (!interval2) return;
    const priceInterval2 = original_price + product.percent_interval_2;
    interval2.html(addCommas(priceInterval2));

    const interval3 = $(`#interval3`)
    if (!interval3) return;
    const priceInterval3 = original_price + product.percent_interval_3;
    interval3.html(addCommas(priceInterval3));

    const interval4 = $(`#interval4`)
    if (!interval4) return;
    const priceInterval4 = original_price + product.percent_interval_4;
    interval4.html(addCommas(priceInterval4));


    // new
    const interval1_1 = $(`#interval1_1`)
    const interval2_1 = $(`#interval2_1`)
    const interval3_1 = $(`#interval3_1`)
    const interval4_1 = $(`#interval4_1`)

    // console.log('product.percent_interval_cc_1', product.percent_interval_cc_1);
    // console.log('product.percent_interval_cc_2', product.percent_interval_cc_2);
    // console.log('product.percent_interval_cc_3', product.percent_interval_cc_3);
    // console.log('product.percent_interval_cc_4', product.percent_interval_cc_4);

    // // product log
    // console.log(product);
    // console.log('original_price', original_price);
    

    if (!interval1_1) return;
    const priceInterval1_1 = original_price + Number(product.percent_interval_cc_1);

    // console.log('priceInterval1_1', priceInterval1_1);
    
    interval1_1.html(addCommas(priceInterval1_1));

    if (!interval2_1) return;
    const priceInterval2_1 = original_price + Number(product.percent_interval_cc_2);
    interval2_1.html(addCommas(priceInterval2_1));

    if (!interval3_1) return;
    const priceInterval3_1 = original_price + Number(product.percent_interval_cc_3);
    interval3_1.html(addCommas(priceInterval3_1));

    if (!interval4_1) return;
    const priceInterval4_1 = original_price + Number(product.percent_interval_cc_4);
    interval4_1.html(addCommas(priceInterval4_1));

}