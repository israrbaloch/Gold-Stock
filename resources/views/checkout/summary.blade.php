<div class="summary-container d-none">
    <input type="hidden" id="payment_method" name="payment_method" value="{{ $paymentMethod }}">
    <h2>
        Order Summary
    </h2>
    <hr>
    @foreach ($products as $product)
        <div class="product-container product-{{ $product->id }}" data-currency="{{ $_currency }}">
            <h3>
                {{ $product->name }}
            </h3>
            <p>
                <span class="quantity">{{ $product->quantity }}</span> x $<span class="price">
                    {{ number_format($product->PaymentMethodPrice($percent_interval_prefix . \App\Helper\Helper::getPercentInterval($product->quantity)), 2) }}
                </span>
                {{ strtoupper($_currency) }}
            </p>
        </div>
        <hr>
    @endforeach
    <table class="no-style">
        <tbody>
            <tr>
                <td align="left">
                    Sub Total:
                </td>
                <td align="right">
                    $<span id="subtotal">{{ number_format($subTotal, 2) }}</span> {{ $currency }}
                </td>
            </tr>
            {{-- PromoCode Details --}}
            @if (isset($promoCodeDiscount) && $promoCodeDiscount > 0)
                <tr>
                    <td align="left">
                        Promo Code Discount:
                    </td>
                    <td align="right">
                        - ${{ number_format($promoCodeDiscount, 2) }}
                    </td>
                </tr>
            @endif
            <input type="hidden" id="delivery_option" name="delivery_option" value="{{ $shippingOption->id }}">
            <input type="hidden" id="currency" name="currency" value="{{ $currency }}">
            <tr class="shipping">
                <td align="left">
                    Shipping Service:
                </td>
                <td align="right" id="shippingDescription">
                    {{ $shippingOption->name }}
                    @if ($subTotal > $shippingOption->free_from && $shippingOption->price > 0)
                        (${{ number_format($shippingOption->price, 2) }} {{ $currency }})
                    @else
                        (Free)
                    @endif
                </td>
            </tr>
            <tr>
                <td align="left">
                    <b>
                        Due Now:
                    </b>
                </td>
                <td align="right">
                    <b>
                        <span class="price-amount amount">
                            $<span id="dueNow">{{ number_format($dueNow, 2) }}</span>
                        </span>
                        {{ $currency }}
                    </b>
                </td>
            </tr>
            @if ($paymentMethod == 2)
                <tr>
                    <td align="left" style="text-indent: 2rem;">
                        10% Deposit:
                    </td>
                    <td align="right" id="initialDeposit">
                        $<span id="initial">{{ number_format($initialDeposit, 2) }}</span> {{ $currency }}
                    </td>
                </tr>
                <tr>
                    <td align="left" style="text-indent: 2rem;">
                        3.75% Processing Fee:
                    </td>
                    <td align="right">
                        $<span id="fee">{{ number_format($fee, 2) }}</span> {{ $currency }}
                    </td>
                </tr>
            @endif
            <tr class="shipping order-total">
                <td align="left">
                    Total:
                </td>
                <td align="right">
                    $<span id="total">{{ number_format($total, 2) }}</span> {{ $currency }}
                </td>
            </tr>
            @if ($userBalance > 0)
                <tr>
                    <td align="left">
                        From Balance on account:
                    <td align="right">
                        ${{ number_format($userBalance, 2) }} {{ $currency }}
                    </td>
                </tr>
            @endif
            @if ($paymentMethod != 3)
            <tr>
                <td align="left">
                    <b>
                        Outstanding Balance:
                    </b>
                </td>
                <td align="right">
                    <b>
                        ($<span id="pending">{{ number_format($pending, 2) }}</span> {{ $currency }})
                    </b>
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    <div id="payment" class="checkout-payment">
        <div class="form-row place-order">
            <div class="terms-and-conditions-wrapper">
                <div class="privacy-policy-text"></div>
            </div>
            <button type="submit" class="button alt d-none" name="checkout_place_order" id="place_order"
                value="Place order" data-value="Place order">Place
                order</button>

            <input type="hidden" id="ssl-token" name="elavon-token" value="">
            <input type="hidden" id="ssl-zip" name="elavon-zip" value="{{ $account->postcode }}">
        </div>
    </div>

    <div class="buttons-container">
        <button class="button medium gray progress-button" data-step="shipping">
            Back
        </button>
        <button type="button" class="button medium progress-button" id="progressButtonSummary" data-step="payment">
            Continue
        </button>
    </div>
</div>
