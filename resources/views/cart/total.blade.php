@php
    $total = 0;
    foreach ($products as $product) {
        // $total += $product->real_price * $product->quantity;
        $total += $product->PaymentMethodPrice($percent_interval_prefix . \App\Helper\Helper::getPercentInterval($product->quantity)) * $product->quantity;
    }

    $promocode = session('promocode');
    $promoCodeDiscount = 0;
    if ($promocode) {
        $promoCodeDiscount = App\Helper\Helper::getPromoCodeDiscount($promocode, $total);
        $total -= $promoCodeDiscount;
    }

    // dd($total);

    $paymentMethod = session('payment_method');

    if ($paymentMethod == 2) {
        $initialDeposit = floor($total * 0.1 * 100) / 100;
        $fee = floor($initialDeposit * 0.0375 * 100) / 100;
    } else {
        $initialDeposit = $total;
        $fee = 0;
    }

    // $userBalance = $balance <= 0 ? 0 : round($balance, 2);
    // $dueNow = $initialDeposit + $fee - $userBalance;
    $dueNow = $initialDeposit + $fee;
    $total += $fee;

    // new
    // $cartId = Cookie::get('_cartid');
    // Cart::session($cartId);
    // $cart = Cart::getContent();

    // // dd($cart);

    // $total = 0;
    // foreach ($cart as $item) {
    //     $total += $item->price * $item->quantity;
    // }

    // $promocode = session('promocode');
    // $promoCodeDiscount = 0;
    // if ($promocode) {
    //     $promoCodeDiscount = Helper::getPromoCodeDiscount($promocode, $total);
    //     $total -= $promoCodeDiscount;
    // }

    // $paymentMethod = session('payment_method');

    // if ($paymentMethod == 2) {
    //     $initialDeposit = floor($total * 0.1 * 100) / 100;
    //     $fee = floor($initialDeposit * 0.0375 * 100) / 100;
    // }else {
    //     $initialDeposit = $total;
    //     $fee = 0;
    // }

    // // $userBalance = $balance <= 0 ? 0 : round($balance, 2);
    // // $dueNow = $initialDeposit + $fee - $userBalance;
    // $dueNow = $initialDeposit + $fee;
    // $total += $fee;

@endphp

<div class="bottom-container row col-lg-12">
    <div class="col-lg-6">
        <div class="promo-code-container mb-4">
            <label for="promo-code" class="w-100 mb-2">
                <b>Promo Code:</b>
            </label>
            <div class="d-flex col-lg-12">
                <input type="text" id="promo-code" placeholder="Enter promo code" class="form-control col-lg-6">
                <div class="col-lg-6 h-auto ps-3">
                    <button type="button" id="apply-promo-code" class="button h-100 w-100">Apply</button>
                </div>
            </div>

            <div id="promo-code-results">
                @if (isset($promoCodeDiscount) && $promoCodeDiscount > 0)
                    <div class="promo-code-result text-success">
                        <span class="promo-code-name">Promo Code Applied</span>
                        <span class="promo-code-discount">-${{ number_format($promoCodeDiscount, 2) }}</span>
                    </div>
                @endif
            </div>

        </div>
    </div>
    <div class="total-container col-lg-6">
        <div id="total-table-container">
            @include('cart.total-table')
        </div>

        <hr>

        <div class="">
            <div class="row d-flex justify-content-center">
                <label class="w-100 mb-0 text-center">
                    <b>Select Payment Method:</b>
                </label>
                <div class="row g-3 col-lg-12 row justify-content-center mt-0">
                    <div class="col-md-6">
                        <div class="form-check w-100 p-0">
                            <input class="form-check-input" type="radio" name="payment_method" id="credit-card"
                                value="3" {{ $paymentMethod == 3 ? 'checked' : '' }}>
                            <label class="payment-button {{ $paymentMethod == 3 ? 'active' : '' }}" for="credit-card"
                                data-payment-method="3">
                                Credit Card
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check w-100 p-0">
                            <input class="form-check-input" type="radio" name="payment_method" id="bank"
                                value="2" {{ $paymentMethod == 2 ? 'checked' : '' }}>
                            <label class="payment-button {{ $paymentMethod == 2 ? 'active' : '' }}" for="bank"
                                data-payment-method="2">
                                Bank Transfer
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="checkout-button">
            @auth
                <button id="checkout-button" class="button medium">
                    Proceed to Checkout
                </button>
            @else
                <button id="" class="button medium" data-bs-toggle="modal" data-bs-target="#Login-Register">
                    Proceed to Checkout
                </button>
            @endauth
        </div>
    </div>
</div>
