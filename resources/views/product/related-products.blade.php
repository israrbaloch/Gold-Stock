<div class="page-container container home-container">
    <div id="product-slider-container-reference" class="col-12 desktop-product-slider">
        <a href="/shop">
            <h2>Related Products</h2>
        </a>
        <div id="slider-product" class="slider-product">
            @foreach ($relatedProducts as $product)
                <div class="">
                    <div class="product-col">
                        @php
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
                        <div id="desktop-product-{{ $product->id }}"
                            class="desk-product-box-slider-container product-box-slider-container product"
                            data-product-id="{{ $product->id }}" data-id="{{ $product->id }}"
                            data-category-slug="{{ $metals[$product->metal_id] }}">
                            <a href="{{ URL::to('/') }}/product/{{ $product->id }}/{{ $product->url_name }}">
                                <div class="product-box-slider">
                                    <div class="product-image">
                                        <img src="{{ $image }}" alt="{{ $product->name }}">
                                    </div>
                                    <div class="product-name">
                                        {{ $product->name }}
                                    </div>
                                    <div class="product-price">
                                        <span class="text-bold">{{ $currency }} </span>
                                        <span id="slider-product-price-2368">
                                            ${{ number_format($product->real_price, 2) }}
                                        </span>
                                    </div>
                                    <div class="product-buy-button">
                                        <form action="{{ route('cart.add') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="user_id" value="{{ $userId }}">
                                            <input type="hidden" name="current_price"
                                                value="{{ $product->real_price }}">
                                            <input type="hidden" name="currency" value="{{ $currency }}">
                                            <input type="hidden" name="weight" value="{{ $product->weight_oz }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" name="btn" class="button "
                                                data-id="{{ $product->id }}" data-category-slug="">
                                                Buy
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="allproducts">
            <a href="/shop">
                View all Products
                <i class="fas fa-chevron-right right-chevron"></i>
            </a>
        </div>
    </div>
</div>
