@include('header.index')
@php
    $userId = '';
    if (Auth::user()) {
        $userId = Auth::user()->id;
    }
    if ($cartId) {
        Cart::session($cartId);
    }
@endphp
<link href="{{ URL::to('/') }}/css/cart.css?ver=1.2.0" rel="stylesheet">
<script type="text/javascript" src="{{ URL::to('/') }}/js/cart.js?ver=1.2.0"></script>

<div class="d-md-block page-container-cart">
    <div class="title-page-1 text-center">
        SHOPING CART
    </div>
    @if (!Cart::isEmpty())
        <input type="hidden" id="cart-currency" name="currency" value="{{ $cartCurrency }}">
        <input type="hidden" id="cart_total" value="{{ Cart::getTotal() }}" />
        {{-- table desktop --}}
        <table class="shop_table table-desktop cart d-none d-md-table" cellspacing="0">
            <thead>
                <tr>
                    <th class="product-name color-dark-green text-bold">Product</th>
                    <th class="product-price color-dark-green text-bold">Price</th>
                    <th class="product-quantity color-dark-green text-bold">Quantity</th>
                    <th class="product-subtotal color-dark-green text-bold">Total</th>
                    <th class="product-remove color-dark-green text-bold text-right">Remove</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalWeight = 0;
                    $hasProduct = true;
                    $isProduct = true;
                @endphp
                @foreach (Cart::getContent() as $item)
                    @php
                        $isProduct = $item->attributes->type == 'metal' ? false : true;
                        $hasProduct = $item->attributes->type == 'metal' ? false : $hasProduct;
                        $steps = $isProduct ? 1 : 0.01;
                    @endphp
                    <tr data-name="{{ $item->name }}" data-id="{{ $item->id }}"
                        data-quantity="{{ $item->quantity }}" data-price="{{ $item->price }}"
                        data-currency="{{ $item->attributes->currency }}" data-hasg class="the-cart-item">
                        <td class="product-thumbnail text-gr">
                            @php
                                $thumbnail = $item->attributes->image;
                            @endphp
                            <img src="{{ $thumbnail }}">
                            <a href="/product/{{ $item->id }}"><span class="product-name text-underline"
                                    data-title="Name">{{ $item->name }}</span></a>
                        </td>
                        <td class="product-price text-underline text-gr" data-title="Price">
                            <span>${{ number_format($item->price, 2) }} {{ $item->attributes->currency }}</span>
                        </td>
                        <td class="product-quantity relative" data-title="Quantity">
                            <div class="quantity">
                                <input type="number" id="quantity-{{ $item->id }}" class="input-text qty text"
                                    name="cart[{{ $item->id }}][qty]" step="{{ $steps }}"
                                    min="{{ $steps }}" max="" value="{{ $item->quantity }}"
                                    title="Qty" size="4" pattern="" inputmode=""
                                    aria-labelledby="{{ $item->name }} quantity">
                            </div>
                            @php
                                $totalWeight += ($item->attributes->weight * $item->quantity) / 16;
                            @endphp
                        </td>
                        <td class="product-subtotal text-underline text-gr" data-title="Total">
                            <span>${{ number_format($item->price * $item->quantity, 2) }}
                                {{ $item->attributes->currency }}</span>
                            <input type="hidden" id="item-type" value="{{ $item->attributes->type }}" />
                        </td>
                        <td class="product-remove d-none d-md-block text-right padding-right-none">
                            <form method="POST" action="{{ route('cart.remove') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="user_id" value="{{ $userId }}">
                                <input type="hidden" value="{{ $item->id }}" id="pid" name="pid">
                                <button type="submit" class="btn makeup-btn-red">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="6" class="actions">
                        <button class="button btn btn-desktop refresh-cart makeup-btn-dark-green">Update cart</button>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- table mobile --}}
        <table class="shop_table table-mobile cart d-table d-md-none" cellspacing="0">
            <tbody>
                @php
                    $totalWeight = 0;
                    $hasProduct = true;
                @endphp
                @foreach (Cart::getContent() as $item)
                    @php
                        $isProduct = $item->attributes->type == 'metal' ? false : true;
                        $hasProduct = $item->attributes->type == 'metal' ? false : $isProduct;
                        $steps = $isProduct ? ' step="1" min="1" max="" ' : '';
                    @endphp
                    <tr data-id="{{ $item->id }}" data-hasg class="the-cart-item item-{{ $item->id }}">
                        <th class="product-name color-dark-green text-bold">Product</th>
                        <td>
                            <a href="/product/{{ $item->id }}"><span class="product-name color-gold text-bold"
                                    data-title="Name">{{ $item->name }}</span></a>
                        </td>
                    </tr>
                    <tr>
                        <th class="product-thumbnail text-right">&nbsp;</th>
                        <td class="thumb">
                            @php
                                $thumbnail = $item->attributes->image;
                            @endphp
                            <img src="{{ $thumbnail }}">
                        </td>
                    </tr>
                    <tr>
                        <th class="product-price color-dark-green text-bold">Price</th>
                        <td class="product-price text-gr" data-title="Price">
                            <span>${{ number_format($item->price, 2) }} {{ $item->attributes->currency }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th class="product-quantity color-dark-green text-bold">Quantity</th>
                        <td class="product-quantity relative" data-title="Quantity">
                            <div class="quantity">
                                <input type="number" id="quantity-{{ $item->id }}"
                                    class="input-text qty text item-{{ $item->id }}"
                                    name="cart[{{ $item->id }}][qty]" step="{{ $steps }}"
                                    min="{{ $steps }}" max="" value="{{ $item->quantity }}"
                                    title="Qty" size="4" pattern="" inputmode=""
                                    aria-labelledby="{{ $item->name }} quantity">
                            </div>
                            @php
                                $totalWeight += ($item->attributes->weight * $item->quantity) / 16;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <th class="product-subtotal color-dark-green text-bold">Total</th>
                        <td class="product-subtotal  text-gr" data-title="Total">
                            <span>${{ number_format($item->price * $item->quantity, 2) }}
                                {{ $item->attributes->currency }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th class="product-remove color-dark-green text-bold text-right">&nbsp;</th>
                        <td class="product-remove padding-right-none">
                            <form method="POST" action="{{ route('cart.remove') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="user_id" value="{{ $userId }}">
                                <input type="hidden" value="{{ $item->id }}" id="pid" name="pid">
                                <button type="submit" class="btn makeup-btn-red w-100">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="2" class="actions">
                        <hr>
                        <button class="button btn btn-mobile refresh-cart makeup-btn-dark-green w-100">Update
                            cart</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr class="w-sm-100">

        <div class="row">
            <div class="col-12 col-md-6 pe-md-8">
                @if ($hasProduct)
                    <div class="text-left"><b><span class="color-dark-green text-bold">You might be interested
                                in...</span></b></div>
                    <br class="d-none d-md-block">
                    <div id="desktop-product-{{ $featured->id }}" class="normal-product product"
                        data-id="{{ $featured->id }}">
                        <div class="product-box-desktop">
                            <div class="row">
                                <div class="col-12 d-md-none text-left product-name color-gold">{{ $featured->name }}
                                </div>
                                <div class="col-12 d-md-none text-left product-price color-yellow text-bold">
                                    <div class="color-yellow">
                                        {{ $cartCurrency }} $<span
                                            id="product-price-{{ $featured->id }}">{{ number_format($featured->real_price, 2) }}</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 product-image">
                                    @php
                                        $exp = explode(',', $featured->images);
                                        $img = $exp[0];
                                    @endphp
                                    <img src="{{ $img }}">
                                </div>
                                <div class="col-8 offset-4 col-md-8 offset-md-0">
                                    <div class="col-12 d-none d-md-flex text-left product-name color-gold">
                                        {{ $featured->name }}</div>
                                    <br>
                                    <div class="col-12 d-none d-md-flex text-left product-price color-yellow">
                                        <span id="product-price-{{ $featured->id }}">{{ $cartCurrency }}
                                            ${{ number_format($featured->real_price, 2) }}</span>
                                    </div>
                                    <br class="d-none d-md-block">
                                    <div class="col-12 text-right text-md-left button-shadow">
                                        <form action="{{ route('cart.add') }}" method="post">
                                            <div class="row g-0">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $featured->id }}">
                                                <input type="hidden" name="user_id" value="{{ $userId }}">
                                                <input type="hidden" name="current_price"
                                                    value="{{ $featured->real_price }}">
                                                <input type="hidden" id="currency" name="currency"
                                                    value="{{ $cartCurrency }}">
                                                <input type="hidden" name="weight"
                                                    value="{{ $featured->weight_oz }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" name="btn"
                                                    class="makeup-btn-dark-green button add-directly-to-cart-in-cart"
                                                    data-id="{{ $featured->id }}">Add to Cart Now</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-12 col-md-6 ps-md-8">
                <hr class="w-sm-100 d-block d-md-none">
                <div class="cart_totals ">
                    <div id="overlay" class="d-none"></div>
                    <table cellspacing="0" class="shop_table totals">
                        <tbody>
                            <input type="hidden" name="userId" id="userId" value={{ $userId }}>
                            <input type="hidden" name="total_weight" id="total_weight"
                                value="{{ $totalWeight }}">
                            @if ($hasProduct)
                                <tr class="shipping">
                                    <th>Shipping</th>
                                    <td align="right" data-title="Shipping">
                                        <select name="fake-shipping" id="trigger-shipping">
                                            <option value="3" data-shipping-name="Add to storage"
                                                selected="selected">Add to storage: $0.00</option>
                                            <option value="1" data-shipping-name="Delivery">Delivery</option>
                                            <option value="2" data-shipping-name="Pick up in store">Pick up in
                                                store: $0.00</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="shipping-fedex shipping d-none">
                                    <th>
                                        <img class="fedex-logo" src="/img/fedex-logo.png" alt="FeDex">
                                    </th>
                                    <td align="right" data-title="Shipping">
                                        <select name="fedex-shipping" id="trigger-fedex">

                                        </select>
                                    </td>
                                </tr>
                                <tr class="no-shipping-fedex d-none">
                                    <th>
                                        <img class="fedex-logo" src="/img/fedex-logo.png" alt="FeDex">
                                    </th>
                                    <td align="right" data-title="Shipping">
                                        <span class="product-price color-yellow">No services available for
                                            location</span>
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <th>Subtotal</th>
                                    <td class="product-price color-yellow " align="right" data-title="Total">
                                        <strong>$<span
                                                class="product-price color-yellow">{{ number_format(Cart::getTotal(), 2) }}</span></strong>
                                        {{ $cartCurrency }}
                                    </td>
                                </tr>
                            @endif
                            <tr class="order-total">
                                <th>Total</th>
                                <td align="right" class="product-price color-yellow " data-total="">$<span
                                        class="total">{{ number_format(Cart::getTotal(), 2) }}</span>
                                    {{ $cartCurrency }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="proceed-to-checkout text-center">
                        <input type="hidden" id="user-b" name="user-b" value="{{ $balance }}">
                        <input type="hidden" id="fedex-price" name="fedex-price" value="0">
                        <input type="hidden" id="fedex-name" name="fedex-name" value="Add to storage">
                        <input type="hidden" id="total-checkout" value="{{ Cart::getTotal() }}" />
                        <buttton id="checkout-button"
                            class="checkout-button button alt makeup-btn-dark-green w-sm-100 btn-desktop">Proceed to
                            checkout</buttton>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="cart-empty">Your cart is currently empty</p>
        <p class="return-to-shop">
            <a class="button" href="/products">Return to shop</a>
        </p>
    @endif
</div>
@include('footer')
