<table class="products-table-desktop" id="products-table" cellspacing="5">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Item Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            @php
                $interval = $percent_interval_prefix . \App\Helper\Helper::getPercentInterval($product->quantity);
                $currentProductPrice = $product->PaymentMethodPrice($interval);
            @endphp
            <tr class="product-{{ $product->id }}">

                {{-- Thumbnail --}}
                <td class="product-thumbnail">
                    <img src="{{ $product->image }}">
                    <a href="/product/{{ $product->id }}" target="_blank">
                        <span class="product-name" data-title="Name">
                            {{ $product->name }}
                        </span>
                    </a>
                </td>

                {{-- Price --}}
                <td class="product-price">
                    $<span class="price">
                        {{-- {{ number_format($product->real_price, 2) }} --}}
                        {{ number_format($currentProductPrice, 2) }}
                    </span>
                    <span>
                        {{ strtoupper($_currency) }}
                    </span>
                </td>

                {{-- Quantity --}}
                <td data-id="{{ $product->id }}" class="product-quantity the-cart-item">
                    <div class="quantity-container">
                        <button type="button" class="decrease">
                            -
                        </button>
                        <input class="quantity" type="number" name="cart[{{ $product->id }}][qty]"
                            step="1" min="1" size="4" value="{{ $product->quantity }}"
                            aria-labelledby="{{ $product->name }} quantity">
                        <button type="button" class="increase">
                            +
                        </button>
                    </div>
                </td>

                {{-- Total --}}
                <td class="product-subtotal">
                    $<span class="subtotal">
                        {{ number_format($currentProductPrice * $product->quantity, 2) }}
                    </span>
                    <span>
                        {{ strtoupper($_currency) }}
                    </span>
                </td>

                {{-- Remove --}}
                <td class="product-remove">
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
