<table class="products-table-mobile" id="products-table" cellspacing="5">
    <tbody>
        @foreach ($products as $item)
            <tr class="product-row">
                {{-- Product Details --}}
                <td class="product-thumbnail">
                    <div class="thumbnail-container">
                        @php
                            $images = json_decode($item->images);
                            if (is_array($images)) {
                                foreach ($images as $i => $image) {
                                    $images[$i] = '/storage/' . str_replace('\\', '/', $image);
                                }
                            } else {
                                $images = explode(',', $item->images);
                            }
                            $thumbnail = $images[0];
                        @endphp
                        <img src="{{ $thumbnail }}" alt="{{ $item->name }}" width="120">
                    </div>
                </td>
                <td class="product-details">
                    <a href="/product/{{ $item->id }}">
                        <span class="product-name">{{ $item->name }}</span>
                    </a>
                    <div class="product-price">
                        <strong>Price:</strong> ${{ number_format($item->price, 2) }}
                    </div>
                    <div class="product-quantity">
                        <strong>Quantity:</strong> <input value="{{ $item->quantity }}" disabled>
                    </div>
                    <div class="product-subtotal">
                        <strong>Item Total:</strong> ${{ number_format($item->price * $item->quantity, 2) }}
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
