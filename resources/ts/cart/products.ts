import { CurrencyWebSocket } from "../exchange/interfaces";
import { addCommas, removeFormat } from "../exchange/utils";
import { Product } from "../shop/interface";

declare const products: Product[];

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
        const subtotalSpan = $(element).find('.subtotal');
        const priceSpan = $(element).find('.price');
        const quantitySpan = $(element).find('.quantity');

        if (!subtotalSpan || !quantitySpan || !priceSpan) return;

        const quantity = Number(quantitySpan.val());
        let price = Number(product.weight_oz) * metal.value * window.app.currencyRate + product.percent_interval_1;

        // name="payment_method" checked value="3"
        let paymentMethod = $('.payment-button.active').data('payment-method');
        if (paymentMethod == 3) {
            price = Number(product.weight_oz) * metal.value * window.app.currencyRate + Number(product.percent_interval_cc_1);
        }

        const total = price * quantity;

        priceSpan.html(addCommas(price));
        subtotalSpan.html(addCommas(total));
    });
    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    for (const product of products) {
        const productElement = document.querySelector(`.product-${product.id}`);
        if (!productElement) continue;

        const totalSpan = productElement.querySelector('.subtotal');
        if (!totalSpan) continue;

        total += removeFormat(totalSpan.innerHTML);
    }

    var initialDeposit = (total * 0.1 * 100) / 100;
    var fee = (initialDeposit * 0.0375 * 100) / 100;

    const paymentMethod = $('input[name="payment_method"]:checked').val();
    if (paymentMethod == 3) {
        initialDeposit = total;
        fee = 0;
    }else{
        initialDeposit = (total * 0.1 * 100) / 100;
        fee = (initialDeposit * 0.0375 * 100) / 100;
    }

    const dueNow = initialDeposit + fee;

    // payment_method name payment_method checked


    $('.price-amount').html(addCommas(dueNow));
    $('.initial').html(addCommas(initialDeposit));
    $('.fee').html(addCommas(fee));
    $('.total').html(addCommas(total));

}