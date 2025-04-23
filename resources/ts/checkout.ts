// @ts-nocheck

const knownErrors = {
    shipping_details: {
        title: "Shipping Details",
        errors: {
            postal_code:
                "Invalid Postal Code, please enter a valid one in <a href='/checkout?step=shipping'>Shipping Step</a>",
        },
    },
};

$(document).ready(function () {
    const dots = $(".progress-container .dot");
    dots.click(function () {
        $(this).addClass("active");
        $(this).prevAll().addClass("active");
        $(this).nextAll().removeClass("active");

        const step = $(this).data("step");
        // showContainerByStep(step);

        // Only update the URL if the step has changed
        if (step !== currentStep) {
            const url =
                window.location.protocol +
                "//" +
                window.location.host +
                window.location.pathname +
                "?step=" +
                (step || "shipping");
            window.location.href = url;
        }
    });

    // Check query to set active dot
    const urlParams = new URLSearchParams(window.location.search);
    const currentStep = urlParams.get("step");

    dots.removeClass("active");
    if (currentStep == "shipping" || !currentStep) {
        dots.eq(0).addClass("active");
    } else if (currentStep == "summary") {
        dots.slice(0, 2).addClass("active");
    } else if (currentStep == "payment") {
        dots.addClass("active");
    }

    setTimeout(() => {
        $("#paymentButtonContainer").removeClass("d-none");
    }, 1000);

    $("#paymentMoneris").click(function () {
        $("#paymentButtonContainer").addClass("d-none");
        $("#outerDiv").removeClass("d-none");
        const currency = $("#currency").val();
        const delivery_option = $("#delivery_option").val();
        const myCheckout = new monerisCheckout();
        if (window.app.env === "production") {
            myCheckout.setMode("prod");
        } else {
            myCheckout.setMode("qa");
        }
        myCheckout.setCheckoutDiv("monerisCheckout");

        myCheckout.setCallback("page_loaded", (e) => {
            console.log("myPageLoad");
            console.log(e);
        });
        myCheckout.setCallback("cancel_transaction", (e) => {
            window.location.href = "/checkout?step=summary";
        });
        myCheckout.setCallback("error_event", (e) => {
            console.log("myErrorEvent");
            console.log(e);
        });
        myCheckout.setCallback("payment_receipt", (data) => {
            console.log("myPaymentReceipt", data);
            const parsedData = JSON.parse(data);
            $.ajax({
                url: "/payment/check",
                type: "post",
                dataType: "json",
                data: {
                    ticket: parsedData.ticket,
                    currency,
                    delivery_option,
                    dataCard: 1,
                },
                success: function (res) {
                    console.log(res);
                    if (res.success) {
                        alert("Your purchase was done successfully.");
                        document.location.href =
                            "/order/" + res.item_type + "/" + res.order_id;
                    }
                },
            });
        });
        myCheckout.setCallback("payment_complete", (data) => {
            console.log("myPaymentComplete", data);
            const parsedData = JSON.parse(data);
            $.ajax({
                url: "/payment/check",
                type: "post",
                dataType: "json",
                data: {
                    ticket: parsedData.ticket,
                    currency,
                    delivery_option,
                    dataCard: 1,
                },
                success: function (res) {
                    console.log(res);
                    if (res.success) {
                        alert("Your purchase was done successfully.");
                        document.location.href =
                            "/order/" + res.item_type + "/" + res.order_id;
                    }
                },
            });
        });
        // Get the ticket and ticket_date from the query parameters
        const urlParams = new URLSearchParams(window.location.search);
        const ticket = urlParams.get("ticket");
        const ticketDateString = urlParams.get("ticket_date");

        // Convert the ticket_date to a Date object
        const ticketDate = new Date(Number.parseInt(ticketDateString));

        // Get the current date and time
        const now = new Date();

        // Calculate the difference in minutes
        const diffInMinutes = (now - ticketDate) / 1000 / 60;
        if (ticket && ticketDateString && diffInMinutes < 5) {
            // If the ticket and ticket_date exist and the ticket_date is less than 5 minutes old,
            // use the ticket from the query parameters
            myCheckout.startCheckout(ticket);
        } else {
            // Otherwise, make the AJAX request to get a new ticket
            $.ajax({
                url: "/payment/preload",
                type: "post",
                success: function (res) {
                    if (res.success) {
                        console.log(res.ticket);
                        const url = new URL(window.location.href);
                        url.searchParams.set("ticket", res.ticket);

                        // Get the current date and time
                        const ticketDate = new Date();
                        const ticketDateString = ticketDate.getTime();

                        // Add the ticket_date query parameter to the URL
                        url.searchParams.set("ticket_date", ticketDateString);

                        history.pushState({}, "", url);
                        myCheckout.startCheckout(res.ticket);
                    } else {
                        let title = res.title;
                        var error = res.error;
                        let errorMessage = "";
                        errorMessage += "<div class='error-title'>" + title + "</div> ";
                        errorMessage += "<div class='error-description'>" + error + "</div> ";

                        $("#monerisErrorContainer").removeClass("d-none");
                        $("#monerisErrors").html(errorMessage);
                        $("#outerDiv").addClass("d-none");
                        $("#paymentButtonContainer").addClass("d-none");
                    }
                },
                error: function (xhr, status, err) {
                    const error = xhr.responseJSON.error;
                    let errorMessage = "";
                    for (const e in error) {
                        if (e in knownErrors) {
                            errorMessage +=
                                '<div class="error-title">' +
                                knownErrors[e].title +
                                ": </div> ";
                            for (const m in error[e]) {
                                console.log(knownErrors[e].errors, m);
                                errorMessage +=
                                    '<div class="error-description">' +
                                    knownErrors[e].errors[m] +
                                    "</div> ";
                            }
                            errorMessage += "<br>";
                        }
                    }
                    $("#monerisErrorContainer").removeClass("d-none");
                    $("#monerisErrors").html(errorMessage);
                    $("#outerDiv").addClass("d-none");
                    $("#paymentButtonContainer").removeClass("d-none");
                },
            });
        }
    });

    const showContainerByStep = function (step) {
        $(".summary-container").addClass("d-none");
        $(".shipping-container").addClass("d-none");
        $(".payment-container").addClass("d-none");
        switch (step) {
            case "shipping":
                $(".shipping-container").removeClass("d-none");
                break;
            case "summary":
                $(".summary-container").removeClass("d-none");
                break;
            case "payment":
                $(".payment-container").removeClass("d-none");
                break;
            default:
                $(".shipping-container").removeClass("d-none");
                break;
        }
        // set to url as query
        // Get the current step from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const currentStep = urlParams.get("step");

        // Only update the URL if the step has changed
        if (step !== currentStep) {
            const url =
                window.location.protocol +
                "//" +
                window.location.host +
                window.location.pathname +
                "?step=" +
                (step || "shipping");
            window.location.href = url;
        }
    };
    showContainerByStep(currentStep);

    $(".title-container").click(function () {
        $(this).toggleClass("active");
    });

    // On Clicking "Continue" button
    $(".progress-button").click(function () {
        const step = $(this).data("step");
        const url =
            window.location.protocol +
            "//" +
            window.location.host +
            window.location.pathname +
            "?step=" +
            (step || "shipping");
        window.location.href = url;
    });

    // On Clicking "Add/Update Shipping Address"
    $(document).on("click", ".update-billing", function (e) {
        $(this).addClass("d-none");
        $("#billing_province_id").removeClass("d-none");
        $("#billing_province").addClass("d-none");
        $("#shipping-address-form input").removeAttr("disabled");
        $("#buttonsContainer").removeClass("d-none");
        $("#orderComments").addClass("d-none");
    });

    // On Clicking 'Update Address - Cancel' button
    $(document).on("click", "#btn-cancel-save-info", function (e) {
        e.preventDefault();
        $("#billing_province_id").addClass("d-none");
        $("#billing_province").removeClass("d-none");
        $("#shipping-address-form input").attr("disabled", "disabled");
        $("#buttonsContainer").addClass("d-none");
        $("#orderComments").removeClass("d-none");
        $(".update-billing").removeClass("d-none");
        // $("#btn-save-info").addClass("d-none");
        // $("#btn-cancel-save-info").addClass("d-none");
    });

    // On Clicking "Use this address"
    $(document).on("click", ".use-billing-address", function (e) {
        var first_name = $(this).attr("data-first-name");
        var last_name = $(this).attr("data-last-name");
        var phone = $(this).attr("data-phone");
        var email = $(this).attr("data-email");
        var address = $(this).attr("data-address");
        var town_city = $(this).attr("data-town-city");
        var state_country = $(this).attr("data-state-country");
        var postal_code = $(this).attr("data-postal-code");

        var data = {};
        data["user_id"] = $(this).attr("data-user-id");
        data["action"] = "update_billing_address";

        data["first_name"] = first_name;
        data["last_name"] = last_name;
        data["phone"] = phone;
        data["address"] = address;
        data["town_city"] = town_city;
        data["state_country"] = state_country;
        data["postal_code"] = postal_code;

        $.ajax({
            url: my_ajax_object.ajax_url,
            data: data,
            dataType: "json",
            method: "post",
            success: function (response) {
                if (response.success) {
                    alert("Address Updated");
                    location.reload();
                } else {
                    alert("error");
                }
            },
        });
    });

    const shippingShowInfo = () => {
        const shippingSelected = $("#shipping-method").find("option:selected");
        const shippingName = shippingSelected.attr("data-name");
        $("#shipping-address-form").addClass("d-none");
        $("#pick-up-container").addClass("d-none");
        switch (shippingName) {
            case "Pick up in store":
                $("#pick-up-container").removeClass("d-none");
                break;

            default:
                $("#shipping-address-form").removeClass("d-none");
                break;
        }
    };
    // On Load
    shippingShowInfo();

    // On Selecting Shipping Option
    $("#shipping-method").on("change", function () {
        const shippingSelected = $("#shipping-method").find("option:selected");
        const shipping_id = shippingSelected.val();
        const shippingName = shippingSelected.attr("data-name");
        const shippingPrice = shippingSelected.attr("data-price");
        const currency = $("#currency").val();

        shippingShowInfo();

        $("#shippingDescription").html(
            `${shippingName} - $${parseFloat(shippingPrice).toFixed(2)} ${currency}`
        );

        if (shipping_id === "1") {
            // populateFedex();
        } else {
            // $(".shipping-fedex").removeClass("d-table-row").addClass("d-none");
            // const total = addCommas(parseFloat($("#total-checkout").val()).toFixed(2));
            // $("#fedex-price").val(0);
            // $("#fedex-name").val("");
            // $("span.total").html(total);
        }
        setCookies(shipping_id);
    });

    function setCookies(shipping_id) {
        $.ajax({
            url: "/cart/cookies",
            type: "post",
            data: {
                shipping_id,
            },
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            success: function (res) {
                if (res.success) {
                    console.log("Cookies set");
                }
            },
        });
    }
});

function populateFedex() {
    $.ajax({
        url: "/cart/fedex",
        type: "post",
        data: {},
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        success: function (res) {
            if (res.data.success) {
                let currency = res.currency;
                var fedex_services = res.data.shipping_services;
                $(fedex_services).each(function () {
                    var text =
                        this.service_name + ": $" + this.service_price + " " + currency;
                    var item =
                        '<option data-c="' +
                        currency +
                        '" data-val="' +
                        this.service_price +
                        '" data-name="' +
                        this.service_name +
                        '">' +
                        text +
                        "</option>";
                    //                    console.log(this.service_name);
                    $("#trigger-fedex").append(item);
                });
                window.setTimeout(function () {
                    $(".shipping-fedex").removeClass("d-none").addClass("d-table-row");
                    $(".no-shipping-fedex").addClass("d-none").removeClass("d-tablerow");
                }, 0);
                var input_total = $("#total-checkout");
                var previous_total = $(input_total).val();
                var selected_price = $("#trigger-fedex")
                    .find("option:selected")
                    .attr("data-val");
                var selected_name = $("#trigger-fedex")
                    .find("option:selected")
                    .attr("data-name");
                $("#fedex-price").val(selected_price);
                $("#fedex-name").val(selected_name);
                var new_total = addCommas(
                    (parseFloat(previous_total) + parseFloat(selected_price)).toFixed(2)
                );
                $("span.total").html(new_total);
                $("#overlay").addClass("d-none");
                $("#overlay").removeClass("busy");
            } else {
                $(".shipping-fedex").addClass("d-none").removeClass("d-table-row");
                $(".no-shipping-fedex").removeClass("d-none").addClass("d-tablerow");
                $("#overlay").addClass("d-none");
                $("#overlay").removeClass("busy");
            }
        },
    });
    //trigger-fedex


    // #promo-code-results, input #promo-code, button #apply-promo-code
    // On Clicking "Apply Promo Code"
}
