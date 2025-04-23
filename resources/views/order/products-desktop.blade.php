<table class="products-table-desktop" id="products-table" cellspacing="5">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th class="text-right">Item Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $item)
            <tr>
                {{-- Thumbnail --}}
                <td class="product-thumbnail">
                    @php
                        $images = json_decode($item->images);

                        // Check if the decoded value is an array
                        if (is_array($images)) {
                            // Replace backslashes with forward slashes in the image path and prepend the 'storage/' directory
                            foreach ($images as $i => $image) {
                                $images[$i] = '/storage/' . str_replace('\\', '/', $image);
                            }
                        } else {
                            // Assume the decoded value is a comma-separated list of image paths
                            $images = explode(',', $item->images);
                        }
                        $thumbnail = $images[0];
                    @endphp
                    <img src="{{ $thumbnail }}" alt="{{ $item->name }}" class="img-fluid">
                    <a href="/product/{{ $item->id }}">
                        <span class="product-name" data-title="Name">
                            {{ $item->name }}
                        </span>
                    </a>
                </td>

                {{-- Price --}}
                <td class="product-price" data-title="Price">
                    <span>
                        ${{ number_format($item->price, 2) }}
                    </span>
                </td>

                {{-- Quantity --}}
                <td data-id="{{ $item->id }}" class="the-cart-item product-quantity" data-title="Quantity">
                    <div class="quantity">
                        <input value="{{ $item->quantity }}" disabled>
                    </div>
                </td>

                {{-- Total --}}
                <td class="product-subtotal" data-title="Total">
                    <span>
                        ${{ number_format($item->price * $item->quantity, 2) }} {{ $order->currency }}
                    </span>
                </td>
            </tr>
        @endforeach
        {{-- <tr>
            <td colspan="6" class="actions">
                <button id="refresh-cart" class="button btn btn-desktop refresh-cart makeup-btn-dark-green">Update
                    cart</button>
            </td>
        </tr> --}}
    </tbody>
</table>
