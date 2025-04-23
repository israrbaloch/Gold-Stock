@include('header.index')
@php
    if (Auth::user()) {
        $user = Auth::user();
        $userId = Auth::user()->id;
    }
    if ($cartId) {
        Cart::session($cartId);
    }
@endphp
<!--<script src="https://api.convergepay.com/hosted-payments/PayWithConverge.js"></script>-->
<link href="{{ URL::to('/') }}/css/cart.css?ver=1.0.0" rel="stylesheet">
<script type="text/javascript" src="{{ URL::to('/') }}/js/cart.js?ver=1.0.0"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/elavon.js?ver=1.0.0"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://api.convergepay.com/hosted-payments/PayWithConverge.js"></script>

<div class="page-container page-container-checkout">
    @if (!Cart::isEmpty())
        <input type="hidden" value="{{ $userId }}" id="user_id">
        <div class="row">
            @if (session('msgTxt'))
                <div class="alert alert-success">
                    {{ session('msgTxt') }}
                </div>
            @endif
            <div class="order-summary col-12 col-md-6">
                <div class="col-12 col-md-6 text-bold color-dark-green checkout-title text-center">
                    <h3>ORDER SUMMARY</h3>
                </div>
                @foreach (Cart::getContent() as $item)
                    @php
                        $isProduct = $item->attributes->type == 'product' ? true : false;
                        $isCash = $item->attributes->type == 'cash' ? true : false;
                    @endphp
                    <input type="hidden" id="cart_total" value="{{ Cart::getTotal() }}" />
                    <div class="row checkout-product-box" data-name="{{ $item->name }}" data-id="{{ $item->id }}"
                        data-quantity="{{ $item->quantity }}" data-price="{{ $item->price }}"
                        data-currency="{{ $item->attributes->currency }}">
                        <input type="hidden" id="item-type" value="{{ $item->attributes->type }}" />
                        <div class="product-thumbnail col-4 col-md-4">
                            <?php
                            $thumbnail = $item->attributes->image;
                            ?>
                            <img src="{{ $thumbnail }}">
                        </div>
                        <div class="name col-4">
                            <b>{{ $item->name }}</b>
                            @if (!$isCash)
                                <b>&nbsp;&nbsp;x{{ $item->quantity }}</b>
                            @endif
                        </div>
                        <div class="total col-4">
                            {{ $item->attributes->currency }} ${{ number_format($item->price * $item->quantity, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>
            @php
                $subtotal = Cart::getTotal();
                if (!$shipping_price > 0) {
                    $shipping_price = 0;
                }
                $userBalance = $balance <= 0 ? 0 : round($balance, 2);
                $minDeposit = $isCash ? round($subtotal, 2) : round(($subtotal + $shipping_price) * 0.1, 2);
                $fee = $isCash ? round($subtotal * 0.0375, 2) : round($minDeposit * 0.0375, 2);
                $total = round($subtotal + $shipping_price, 2);
                $dueNow = $minDeposit + $fee - $userBalance;
                $pending = $total - $minDeposit;
            @endphp
            <div class="col-12 col-md-6">
                <div class="order-desc row">
                    <div class="col-12">
                        <div id="order_review" class="checkout-review-order">
                            <table class="shop_table checkout-review-order-table">
                                <tbody>
                                    @if ($isProduct)
                                        <tr class="cart_item">
                                            <td class="product-name left-side-td">
                                                Subtotal:
                                            </td>
                                            <td class="product-total right-side-td">
                                                ${{ number_format($subtotal, 2) }} {{ $currency }}
                                            </td>
                                        </tr>
                                        <input type="hidden" id="delivery_option" name="delivery_option"
                                            value="{{ $delivery }}">
                                        <input type="hidden" id="fedex-service" name="fedex-service"
                                            value="{{ $shipping_name }}">
                                        <input type="hidden" id="fedex-value" name="fedex-value"
                                            value="{{ $shipping_price }}">
                                        <input type="hidden" id="currency" name="currency"
                                            value="{{ $currency }}">
                                        <tr class="shipping cart_item">
                                            <td class="product-name left-side-td">
                                                Shipping:
                                            </td>
                                            <td align="right" class="right-side-td" data-title="Shipping">
                                                {{ $shipping_name }} -
                                                ${{ number_format($shipping_price, 2) . ' ' . $currency }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr class="shipping cart_item order-total"
                                        style="border-bottom: solid 1px #A9954B;">
                                        <td class="product-name left-side-td">Total:</td>
                                        <td class="right-side-td">
                                            ${{ number_format($total, 2) }} {{ $currency }}
                                        </td>
                                    </tr>
                                    @if (!$isCash)
                                        <tr class="cart_item">
                                            <td class="product-name left-side-td">
                                                10% Deposit:
                                            </td>
                                            <td class="product-total right-side-td">
                                                ${{ number_format($minDeposit, 2) }} {{ $currency }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr class="cart_item">
                                        <td class="product-name left-side-td">
                                            3.75% processing fee:
                                        </td>
                                        <td class="product-total right-side-td">
                                            ${{ number_format($fee, 2) }} {{ $currency }}
                                        </td>
                                    </tr>
                                    <tr class="cart_item" style="border-bottom: solid 1px #A9954B;">
                                        <td class="product-name left-side-td">
                                            Due now:
                                        </td>
                                        <td class="product-total right-side-td">
                                            <span class="price-amount amount">${{ number_format($dueNow, 2) }}</span>
                                            {{ $currency }}
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    @if (!$isCash)
                                        <tr class="cart-subtotal">
                                            <th>From Balance on account:</th>
                                            <td>
                                                ${{ number_format($userBalance, 2) }} {{ $currency }}
                                            </td>
                                        </tr>
                                        <tr class="cart-subtotal">
                                            <th>
                                                Balance Pending:
                                            </th>
                                            <td>
                                                ${{ number_format($pending, 2) }} {{ $currency }}
                                            </td>
                                        </tr>
                                    @endif
                                </tfoot>
                            </table>
                            <div id="payment" class="checkout-payment">
                                <ul class="payment_methods payment_methods methods">
                                    <li class="payment_method payment_method_bacs">
                                        <label for="payment_method_bacs">Direct bank transfer</label>
                                        <input id="payment_method_bacs" type="radio" class="input-radio"
                                            name="payment_method" value="bacs" data-order_button_text="">
                                        <div class="payment_box payment_method_bacs d-none">
                                            <p>Make your payment directly into our bank account. Please use your Order
                                                ID as the payment reference. Your order will not be shipped until the
                                                funds have cleared in our account.</p>
                                        </div>
                                    </li>
                                    <li class="payment_method payment_method_cod">
                                        <input id="payment_method_cod" type="radio" class="input-radio"
                                            name="payment_method" value="cod" checked="checked"
                                            data-order_button_text="">

                                        <label for="payment_method_cod">
                                            Cash </label>
                                        <div class="payment_box payment_method_cod">
                                            <p>Pay with cash upon delivery.</p>
                                        </div>
                                    </li>
                                    <li class="payment_method elavon-api-container">
                                        <label for="payment_method_elavon_converge_credit_card_api">
                                            Credit Card
                                        </label>
                                        <input checked=""
                                            id="payment_method_elavon_converge_credit_card_api-disabled" type="radio"
                                            class="payment_method_elavon_converge_credit_card_api"
                                            name="payment_method" value="cod"
                                            data-order_button_text="Place order">
                                    </li>
                                </ul>
                                <div class="form-row place-order">
                                    <noscript>
                                        Since your browser does not support JavaScript, or it is disabled, please ensure
                                        you click the &lt;em&gt;Update Totals&lt;/em&gt; button before placing your
                                        order. You may be charged more than the amount stated above if you fail to do
                                        so. <br /><button type="submit" class="button alt"
                                            name="checkout_update_totals" value="Update totals">Update totals</button>
                                    </noscript>

                                    <div class="terms-and-conditions-wrapper">
                                        <div class="privacy-policy-text"></div>
                                    </div>
                                    <button type="submit" class="button alt d-none" name="checkout_place_order"
                                        id="place_order" value="Place order" data-value="Place order">Place
                                        order</button>
                                    <input type="hidden" id="process-checkout-nonce" name="process-checkout-nonce"
                                        value="017bcb2539"><input type="hidden" name="_wp_http_referer"
                                        value="/?wc-ajax=update_order_review">
                                    <input type="hidden" id="ssl-token" name="elavon-token" value="">
                                    <input type="hidden" id="ssl-zip" name="elavon-zip"
                                        value="{{ $account->postcode }}">
                                </div>
                                <br><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="action-tabs">
                    <div class="tab-header row g-0">
                        <div id="show-billing-form" class="action-tab-head col-6 active">
                            Shipping Info.
                        </div>
                        <div id="request-payment" class="action-tab-head col-6">
                            Payment
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="action-tab billing-info col-12">
                            <br>
                            <div id="customer_details" class="row g-0">
                                <div class="col-12">
                                    <div class="billing-fields">
                                        <form id="shipping-address-form" method="post"
                                            action="/update-shiping-info">
                                            @csrf
                                            <div class="billing-fields__field-wrapper">
                                                <div class="trigger-billing-addresses text-right">
                                                    Add/Update Shipping Address
                                                </div>
                                                <p class="form-row form-row-first validate-required validate-required"
                                                    id="billing_first_name_field" data-priority="10">
                                                    <span class="input-wrapper">
                                                        <input type="text" class="input-text "
                                                            name="billing_first_name" id="billing_first_name"
                                                            placeholder="First name" value="{{ $account->fname }}"
                                                            autocomplete="given-name" disabled="">
                                                    </span>
                                                </p>
                                                <p class="form-row form-row-first validate-required validate-required"
                                                    id="billing_last_name_field" data-priority="20">
                                                    <span class="input-wrapper">
                                                        <input type="text" class="input-text "
                                                            name="billing_last_name" id="billing_last_name"
                                                            placeholder="Last name" value="{{ $account->lname }}"
                                                            autocomplete="family-name" disabled="">
                                                    </span>
                                                </p>
                                                <p class="form-row form-row-first validate-required validate-required validate-phone"
                                                    id="billing_phone_field" data-priority="40">
                                                    <span class="input-wrapper">
                                                        <input type="text" class="input-text "
                                                            name="billing_phone" id="billing_phone"
                                                            placeholder="Phone" value="{{ $account->phone }}"
                                                            autocomplete="tel" disabled="">
                                                    </span>
                                                </p>
                                                <p class="form-row address-field form-row-wide validate-required"
                                                    id="billing_address_1_field" data-priority="50">
                                                    <span class="input-wrapper">
                                                        <input type="text" class="input-text "
                                                            name="billing_address_1" id="billing_address_1"
                                                            placeholder="Street address"
                                                            value="{{ $account->address_line1 }}"
                                                            autocomplete="address-line1" disabled="">
                                                    </span>
                                                </p>
                                                <p class="form-row address-field form-row-first validate-required"
                                                    id="billing_city_field" data-priority="70">
                                                    <span class="input-wrapper">
                                                        <input type="text" class="input-text " name="billing_city"
                                                            id="billing_city" placeholder="Town / City"
                                                            value="{{ $account->city }}"
                                                            autocomplete="address-level2" disabled="">
                                                    </span>
                                                </p>
                                                <p class="form-row address-field form-row-first validate-required"
                                                    id="billing_province_field" data-priority="80">
                                                    <span class="input-wrapper">
                                                        @php
                                                            $provinceName = $provinces_list[$account->province_id];
                                                        @endphp
                                                        <input type="text" class="input-text "
                                                            name="billing_province" id="billing_province"
                                                            placeholder="Town / City" value="{{ $provinceName }}"
                                                            autocomplete="address-level2" disabled="">
                                                        <select id="billing_province_id" name="billing_province_id"
                                                            class="form-control makeup-input d-none">
                                                            @foreach ($provinces as $province)
                                                                @php
                                                                    $selected = $provinceName == $province->name ? ' selected' : null;
                                                                @endphp
                                                                <option value={{ $province->id }}{{ $selected }}>
                                                                    {{ $province->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </span>
                                                </p>
                                                <p class="form-row address-field form-row-wide validate-required validate-postcode"
                                                    id="billing_postcode_field" data-priority="110">
                                                    <span class="input-wrapper">
                                                        <input type="text" class="input-text "
                                                            name="billing_postcode" id="billing_postcode"
                                                            placeholder="Postcode / ZIP"
                                                            value="{{ $account->postcode }}"
                                                            autocomplete="postal-code" disabled="">
                                                    </span>
                                                </p>
                                            </div>
                                            <button id="btn-cancel-save-info"
                                                class="btn-danger border-0 me-2 p-1 d-none">Cancel</button>
                                            <button type="submit" id="btn-save-info"
                                                class="btn-green border-0 me-2 p-1 d-none">Save</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="additional-fields">
                                        <div class="additional-fields__field-wrapper">
                                            <p class="form-row notes form-row-first" id="order_comments_field"
                                                data-priority="20">
                                                <label for="order_comments" class="">Order Notes&nbsp;
                                                    <span class="optional">(optional)</span>
                                                </label>
                                                <span class="input-wrapper">
                                                    <textarea name="order_comments" class="input-text " id="order_comments"
                                                        placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="action-tab payment-info col-12 d-none">
                            <br><br>
                            <form name="getSessionTokenForm">
                                <input type="hidden" id="name" name="ssl_first_name" size="25"
                                    value="{{ $account->fname }}">
                                <input type="hidden" id="lastname" name="ssl_last_name" size="25"
                                    value="{{ $account->lname }}">
                                <input type="hidden" id="ssl_account" name="ssl_account" size="25"
                                    value="{{ $account->number }}">
                                <input type="hidden" id="useremail" name="ssl_user_email" size="25"
                                    value="{{ $user->email }}">
                                <input type="hidden" id="ssl_amount" name="ssl_amount" disabled="disabled"
                                    value="{{ round($dueNow, 2) }}">
                            </form>
                            <form method="post" action="https://accept.authorize.net/payment/payment"
                                id="formAuthorizeNetPopup" name="formAuthorizeNetPopup" target="iframeAuthorizeNet"
                                style="display:none;">
                                <input type="hidden" id="popupToken" name="token"
                                    value="Replace with form token from getHostedPaymentPageResponse" />
                            </form>
                            <input type="hidden" id="inputtoken" value="" />
                            <br />
                            <div>
                                <button id="btnOpenAuthorizeNetPopup" class="button alt pay-order-btn"
                                    onclick="AuthorizeNetPopup.openPopup()">Pay Order</button>
                            </div>
                            <div class="action-results">
                                <div id="overlay" class="d-none"></div>
                                <button type="button" class="button alt pay-order-btn d-none" name="start-payment"
                                    id="start-payment">Pay Order</button>
                                <div id="elavon-msg-container" class="d-none">
                                    <div id="elavon-msg"></div>
                                    <br>
                                </div>
                            </div>
                            <br>
                            <p class="text-center text-bold hide-failed">Your Payment information is stored securely.
                            </p>
                        </div>
                    </div>
                    <div id="txn_status"></div>
                    <div id="txn_response"></div>
                </div>
                <form name="getSessionTokenForm">
                    <input type="hidden" id="name" name="ssl_first_name" size="25"
                        value="{{ $account->fname }}">
                    <input type="hidden" id="lastname" name="ssl_last_name" size="25"
                        value="{{ $account->lname }}">
                    <input type="hidden" id="ssl_account" name="ssl_account" size="25"
                        value="{{ $account->number }}">
                    <input type="hidden" id="useremail" name="ssl_user_email" size="25"
                        value="{{ $user->email }}">
                    <input type="hidden" id="ssl_amount" name="ssl_amount" disabled="disabled"
                        value="{{ round($dueNow, 2) }}">
                </form>
                <div class="anet-payment col-12 anet-payment-modal modal fade">
                    <button type="button" style="display: none;" class="close modal-trap"
                        data-dismiss="modal">×</button>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="logo-container d-none d-md-block">
                                <div class="main-logo-pu">
                                    <img src="/img/main-logo.png" alt="" class="main-logo" />
                                </div>
                            </div>
                            <div id="divAuthorizeContainer">
                                <div id="busy-if" class="d-none"></div>
                                <div id="divAuthorizeNetPopup" class="AuthorizeNetPopupGrayFrameTheme">
                                    <div class="AuthorizeNetPopupOuter">
                                        <div class="AuthorizeNetPopupTop">
                                            <div class="AuthorizeNetPopupClose">
                                                <a href="javascript:;" onclick="AuthorizeNetPopup.closePopup();"
                                                    title="Close"> </a>
                                            </div>
                                        </div>
                                        <div class="AuthorizeNetPopupInner">
                                            <iframe name="iframeAuthorizeNet" id="iframeAuthorizeNet"
                                                src="{{ url('/empty-iframe') }}" frameborder="0"
                                                scrolling="no"></iframe>
                                        </div>
                                        <div class="AuthorizeNetPopupBottom">
                                            <div class="AuthorizeNetPopupLogo" title="Powered by Authorize.net"></div>
                                        </div>
                                        <div id="divAuthorizeNetPopupScreen" style="display:none;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="cart-empty">Sorry, your session has expired.</p>
        <p class="return-to-shop">
            <a class="button" href="/products">Return to shop</a>
        </p>
    @endif
</div>
<script>
    var empty_if = "{{ route('empty.iframe') }}";
</script>
@include('footer')
