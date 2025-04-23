import { addCommas } from "./../exchange/utils";
import { setupPrices } from "./products";

$(function () {
    setupPrices();

    // Checkout button
    $("#checkout-button").on("click", function () {
        // const cart_price = parseFloat($("#total-checkout").val());
        // let shipping_price = parseFloat($("#fedex-price").val());
        // let shipping_name = $("#fedex-name").val();
        // const user_balance = parseFloat($("#user-b").val());
        // const user_id = $("#userId").val();
        // const currency = $("#cart-currency").val();

        // if ($(this).hasClass("btn-desktop")) {
        //   var tr_items = $(".table-desktop .the-cart-item");
        // } else {
        //   var tr_items = $(".table-mobile .the-cart-item");
        // }

        // Get all products from HTML
        // const htmlProducts = [];
        // for (var i = 0; i < tr_items.length; i++) {
        //   htmlProducts[i] = [];
        //   htmlProducts[i]["id"] = $(tr_items[i]).attr("data-id");
        //   htmlProducts[i]["quantity"] = $(tr_items[i]).attr("data-quantity");
        //   htmlProducts[i]["price"] = $(tr_items[i]).attr("data-price");
        //   htmlProducts[i]["currency"] = $(tr_items[i]).attr("data-currency");
        //   htmlProducts[i]["name"] = $(tr_items[i]).attr("data-name");
        //   if ($(this).hasClass("btn-desktop")) {
        //     htmlProducts[i]["qty"] = $(tr_items[i]).find(".qty").val();
        //   } else {
        //     const item_id = $(tr_items[i]).attr("data-id");
        //     htmlProducts[i]["qty"] = $(".table-mobile #quantity-" + item_id).val();
        //   }
        // }
        // const products = htmlProducts.map((product) => ({
        //   id: product.id,
        //   quantity: product.quantity,
        //   price: product.price,
        //   currency: product.currency,
        //   name: product.name,
        // }));

        // if user has enough balance, buy products
        // TODO: move discount from balance
        // if (user_balance > shipping_price + cart_price * 0.1) {
        //   let url = "/shop/products";
        //   if ($("#item-type").val() === "metal") {
        //     url = "/metal/buy";
        //   } else if ($("#type").val() === "cash") {
        //     url = "/deposit-cash";
        //   }
        //   $.ajax({
        //     url: url,
        //     type: "post",
        //     data: {
        //       fedex_price: shipping_price,
        //       fedex_name: shipping_name,
        //       currency: currency,
        //       user_id: user_id,
        //       total: cart_price,
        //     },
        //     headers: {
        //       "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        //     },
        //     success: function (res) {
        //       if (res.success) {
        //         alert("Your purchase was done succesfully");
        //         document.location.href = "/";
        //       } else {
        //         alert("Something went wrong. Please try again.");
        //       }
        //     },
        //   });
        // } else {
        // if user doesn't have enough balance, set cookies and redirect to checkout page


        // payment_method get by name payment_method
        let payment_method = $("input[name='payment_method']:checked").val();

        document.location.href = "/checkout?payment_method=" + payment_method;
        // }
    });


    setTimeout(function () {
        $("#billing_email").prop("disabled", true);
        $("#billing_city").prop("disabled", true);
        $("#billing_address_1").prop("disabled", true);
        $("#billing_state").prop("disabled", true);
        $("#billing_postcode").prop("disabled", true);
        $("#billing_phone").prop("disabled", true);
        $("#billing_country").prop("disabled", true);
    }, 4);
});


function update(products: any) {
    const _products = [];
    for (const product of products) {
        _products.push({
            id: product.id,
            qty: product.qty,
        });
    }
    $.ajax({
        url: "/cart/update",
        type: "post",
        data: {
            products: JSON.stringify(_products),
        },
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        success: function (res) {
            alert(res.msg);
            window.location.reload();
        },
    });
}

$(function () {
    // Setup increase and decrease buttons for number inputs
    $(".product-quantity").each(function () {
        const input = this.querySelector("input") as HTMLInputElement;
        const decreaseButton = $(this).find(".decrease");
        const increaseButton = $(this).find(".increase");

        let timeout: NodeJS.Timeout;
``
        decreaseButton.click(() => {
            if (input.value > input.min) {
                input.value = (parseInt(input.value) - parseInt(input.step)).toString();
                if (timeout) clearTimeout(timeout);
                timeout = setTimeout(() => {
                    updateCart();
                }, 1000);
            }
        });

        increaseButton.click(() => {
            if (input.value < input.max || input.max === "") {
                input.value = (parseInt(input.value) + parseInt(input.step)).toString();
                if (timeout) clearTimeout(timeout);
                timeout = setTimeout(() => {
                    updateCart();
                }, 1000);
            }
        });
    });

    // On Clicking Refresh Cart
    $("#refresh-cart").on("click", function () {
        $("body").find("input, button, select").attr("disabled", "disabled");
        $(this).html("Processing...");
        updateCart();
    });

    const updateCart = () => {
        const products: any = [];
        let items;
        if (window.innerWidth <= 1200) {
            items = $(".the-cart-item-mobile");
        } else {
            items = $(".the-cart-item");
        }
        console.log(items.length);
        

        for (let i = 0; i < items.length; i++) {
            const id = $(items[i]).attr("data-id");
            const qty = $(items[i]).find("input").val();
            console.log(id, qty);
            // Only add the product if it's not already in the array
            if (!products.some((product: any) => product.id === id)) {
                products.push({ id, qty });
            }
        }
        update(products);
    };
});

$("#apply-promo-code").click(function () {
    const promo_code = $("#promo-code").val();
    if (promo_code) {
        $.ajax({
            url: "/cart/promo",
            type: "post",
            data: {
                promo_code,
            },
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            success: function (res) {
                const total = res.total;

                if (res.success) {
                    const currency = res.currency;
                    const discount = res.discount;

                    // Update the promo code discount row
                    $("#promo-code-row").html(`
                        <th>
                            Promo Code Discount:
                        </th>
                        <td align="right">
                            - $<span class="promo-code-discount">
                                ${addCommas(parseFloat(parseFloat(discount).toFixed(2)))}
                            </span>
                            <span>
                                ${currency.toUpperCase()}
                            </span>
                        </td>
                    `).show(); // Show the row if it's hidden

                    // Update the total
                    $("#total-checkout").val(total);
                    $("span.total").html(addCommas(Number(parseFloat(total).toFixed(2))));

                    // Display success message
                    $("#promo-code-results").html(
                        `<span class='text-success'>Promo Code Applied: -$${addCommas(discount)}</span>`
                    );

                    // reload the .total-container data
                    $("#total-table-container").load(location.href + " #total-table");
                } else {
                    // Handle invalid promo code
                    $("#promo-code-results").html(`<span class='text-danger'>${res.message}</span>`);

                    // Hide the promo code discount row
                    $("#promo-code-row").hide();

                    // Update the total
                    $("span.total").html(addCommas(Number(parseFloat(total).toFixed(2))));

                    $("#total-table-container").load(location.href + " #total-table");
                }
            },
            error: function (err) {
                console.error("Error applying promo code:", err);
                $("#promo-code-results").html(`<span class='text-danger'>An error occurred. Please try again.</span>`);
            }
        });
    }
});


$(document).ready(function () {
    $('.payment-button').on('click', function () {
        // Remove the active class from all buttons
        $('.payment-button').removeClass('active');

        // Add the active class to the clicked button
        $(this).addClass('active');

        // old html of the button
        let old_html = $(this).html();
        let payment_button = $(this);

        // show loader on the button
        $(this).html('<i class="fa fa-spinner fa-spin"></i>');

        // payment_method value
        let payment_method = $(this).data('payment-method');

        // Update the session by ajax
        $.ajax({
            url: "/cart/payment-method",
            type: "post",
            data: {
                payment_method,
            },
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            success: function (res) {
                $("#total-table-container").html(res.html);
                // productsHtml
                $("#cart-products").html(res.productsHtml);
                payment_button.html(old_html);
            },
            error: function (err) {
                console.error("Error updating payment method:", err);
                payment_button.html(old_html);
            }
        });

        // reload the .total-container data
        // hide loader on the button

    });
});

