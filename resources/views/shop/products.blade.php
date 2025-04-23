<div class="row shop-products">
    @if (count($products) > 0)
        @foreach ($products as $product)
            @php
                // Decode the JSON-encoded product images
                $imagesData = json_decode($product->images);

                // Check if the decoded value is an array
                if (is_array($imagesData)) {
                    // Select the first image in the array
                    $image = $imagesData[0];
                    // Replace backslashes with forward slashes in the image path and prepend the 'storage/' directory
                    $image = '/storage/' . str_replace('\\', '/', $image);
                } else {
                    // Assume the decoded value is a comma-separated list of image paths
                    $exp = explode(',', $product->images);
                    // Select the first image in the list
                    $image = $exp[0];
                }
            @endphp


            <div id="product-{{ $product->id }}"
                class="col-6 col-xs-6 col-md-4 col-lg-3 gx-1 normal-product product product-box-desktop-container not-bar">
                <a href="/product/{{ $product->id }}/{{ $product->url_name }}">
                    <div class="product-box-desktop">
                        <div class="image">
                            <img src="{{ $image }}" alt="{{ $product->name }}">
                        </div>
                        <div class="name">
                            <b>{{ $product->name }}</b>
                        </div>
                        <div class="price-container">
                            <span class="currency">
                                {{ $_currency }}
                            </span>
                            <span class="price">
                                {{ number_format($product->real_price, 2) }}
                            </span>
                        </div>
                        <form action="{{ route('cart.add') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="user_id" value="{{ $userId }}">
                            <input type="hidden" name="current_price" value="{{ $product->real_price }}">
                            <input type="hidden" name="currency" value="{{ $currency }}">
                            <input type="hidden" name="weight" value="{{ $product->weight_oz }}">
                            <input type="hidden" name="quantity" value="1">
                            @if ($product->in_stock)
                                <button type="submit" name="btn" class="button medium"
                                    data-id="{{ $product->id }}">
                                    Buy
                                </button>
                            @else
                                <button type="button" class="button medium disabled-btn" disabled>
                                    Out of stock
                                </button>
                            @endif
                        </form>
                    </div>
                </a>
            </div>
        @endforeach
    @else
        @include('shop.products-not-found')
    @endif

</div>
