import { CurrencyWebSocket } from "../exchange/interfaces";
import { addCommas } from "../exchange/utils";
import { Product, ProductsPage } from "./interface";

declare const productsPage: ProductsPage;

export function setupProducts() {
    console.log(productsPage);
    window.app.historicalData.subscribeGold((gold) => {
        for (const product of productsPage.data) {
            if (product.metal_id == 1183) {
                processProduct(product, gold);
            }
        }
    });
    window.app.historicalData.subscribeSilver((silver) => {
        for (const product of productsPage.data) {
            if (product.metal_id == 1677) {
                processProduct(product, silver);
            }
        }
    });
    window.app.historicalData.subscribePlatinum((platinum) => {
        for (const product of productsPage.data) {
            if (product.metal_id == 1681) {
                processProduct(product, platinum);
            }
        }
    });
    window.app.historicalData.subscribePalladium((palladium) => {
        for (const product of productsPage.data) {
            if (product.metal_id == 1682) {
                processProduct(product, palladium);
            }
        }
    });
}

function processProduct(product: Product, metal: CurrencyWebSocket) {
    const priceSpan = $(`#product-${product.id} .price`)
    if (!priceSpan) return;

    const price = Number(product.weight_oz) * metal.value * window.app.currencyRate + product.percent_interval_1;
    priceSpan.html(addCommas(price));
}