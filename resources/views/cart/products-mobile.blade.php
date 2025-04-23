<table class="products-table-mobile" id="products-table" cellspacing="5">
    <tbody>
        @foreach ($products as $product)
            @php
                $interval = $percent_interval_prefix . \App\Helper\Helper::getPercentInterval($product->quantity);
                $currentProductPrice = $product->PaymentMethodPrice($interval);
            @endphp
            <tr class="product-{{ $product->id }}">

                <th>Product</th>

                {{-- Thumbnail --}}
                <td class="product-thumbnail">
                    <div class="thumbnail-container">
                        <img src="{{ $product->image }}">
                        <a href="/product/{{ $product->id }}">
                            <span class="product-name" data-title="Name">
                                {{ $product->name }}
                            </span>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Price</th>
                {{-- Price --}}
                <td class="product-price">
                    $<span class="price">
                        {{ number_format($currentProductPrice, 2) }}
                    </span>
                    <span>
                        {{ strtoupper($_currency) }}
                    </span>
                </td>
            </tr>


            {{-- Quantity --}}
            <tr data-id="{{ $product->id }}" class="the-cart-item-mobile">
                <th>Quantity</th>
                <td class="product-quantity">
                    <div class="quantity-container">
                        <button type="button" class="decrease">
                            -
                        </button>
                        <input class="quantity" type="number" name="cart[{{ $product->id }}][qty]" step="1"
                            min="1" value="{{ $product->quantity }}" title="Qty" size="4"
                            aria-labelledby="{{ $product->name }} quantity">
                        <button type="button" class="increase">
                            +
                        </button>
                    </div>
                </td>
            </tr>

            <tr>
                <th>Item Total</th>
                {{-- Total --}}
                <td class="product-subtotal" data-title="Total">
                    $<span class="subtotal">
                        {{ number_format($currentProductPrice * $product->quantity, 2) }}
                    </span>
                    <span>
                        {{ strtoupper($_currency) }}
                    </span>
                </td>
            </tr>
            <tr>
                <th></th>
                {{-- Remove --}}
                <td class="product-remove ">
                    <form method="POST" action="{{ route('cart.remove') }}">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $product->id }}" id="pid" name="pid">
                        <button type="submit">
                            <img src="{{ asset('img/icons/trash.png') }}" alt="trash icon">
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
