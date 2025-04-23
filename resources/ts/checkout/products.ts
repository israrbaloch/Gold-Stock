import { CurrencyWebSocket } from "../exchange/interfaces";
import { addCommas, removeFormat } from "../exchange/utils";
import { Product } from "../shop/interface";

declare const products: Product[];
declare const shippingPrice: number;

export function setupPrices() {
    window.app.historicalData.subscribeGold((gold) => {
        for (const product of products) {
            if (product.metal_id == 1183) {
                processProduct(product, gold);
            }
        }

    });
    window.app.historicalData.subscribeSilver((silver) => {
        for (const product of products) {
            if (product.metal_id == 1677) {
                processProduct(product, silver);
            }
        }
    });
    window.app.historicalData.subscribePlatinum((platinum) => {
        for (const product of products) {
            if (product.metal_id == 1681) {
                processProduct(product, platinum);
            }
        }
    });
    window.app.historicalData.subscribePalladium((palladium) => {
        for (const product of products) {
            if (product.metal_id == 1682) {
                processProduct(product, palladium);
            }
        }
    });

}

function processProduct(product: Product, metal: CurrencyWebSocket) {
    $(`.product-${product.id}`).each((index, element) => {
        const priceSpan = $(element).find('.price');
        const subtotalSpan = $(element).find('.subtotal');
        const quantitySpan = $(element).find('.quantity');

        if (!subtotalSpan || !quantitySpan || !priceSpan) return;

        const quantity = Number(quantitySpan.val());
        const price = Number(product.weight_oz) * metal.value * window.app.currencyRate + product.percent_interval_1;
        const total = price * quantity;

        priceSpan.html(addCommas(price));
        subtotalSpan.html(addCommas(total));
    });
    calculateTotal();
}

function calculateTotal() {
    let subtotal = 0;
    for (const product of products) {
        const productElement = document.querySelector(`.product-${product.id}`);
        if (!productElement) continue;

        const price = productElement.querySelector('.price');
        if (!price) continue;

        const quantitySpan = productElement.querySelector('.quantity');
        if (!quantitySpan) continue;


        subtotal += removeFormat(price.innerHTML) * Number(quantitySpan.innerHTML);
    }


    var initialDeposit = (subtotal * 0.1 * 100) / 100 + shippingPrice * 0.1;
    var fee = (initialDeposit * 0.0375 * 100) / 100;

    var paymentMethod = $('#paymentMethod').val();

    if (paymentMethod == 2) {
        var initialDeposit = (subtotal * 0.1 * 100) / 100 + shippingPrice * 0.1;
        var fee = (initialDeposit * 0.0375 * 100) / 100;
    } else {
        var initialDeposit = subtotal + shippingPrice;
        var fee = 0;
    }


    const dueNow = initialDeposit + fee;
    subtotal += shippingPrice;
    const pending = subtotal - initialDeposit;
    const total = subtotal + fee;

    $('#dueNow').html(addCommas(dueNow));
    $('#initial').html(addCommas(initialDeposit));
    $('#fee').html(addCommas(fee));
    $('#subtotal').html(addCommas(subtotal));
    $('#pending').html(addCommas(pending));
    $('#total').html(addCommas(total));

}