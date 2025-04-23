@include('header.index')
<link href="{{ URL::to('/') }}/css/style-new.css?ver=1.2.0" rel="stylesheet">
<link href="{{ URL::to('/') }}/css/single-product.css?ver=1.0.0" rel="stylesheet">
<script type="text/javascript" src="{{ URL::to('/') }}/js/single-product.js?ver=1.2.0"></script>
@php
    $currency = Cookie::get('currency');
    // Decode the JSON-encoded product images
    $images = json_decode($detail_product['images']);

    // Check if the decoded value is an array
    if (is_array($images)) {
        // Replace backslashes with forward slashes in the image path and prepend the 'storage/' directory
        foreach ($images as $i => $image) {
            $images[$i] = '/storage/' . str_replace('\\', '/', $image);
        }
    } else {
        // Assume the decoded value is a comma-separated list of image paths
        $images= explode(',', $detail_product['images']);
    }
@endphp
<div class="page-container container">
    <div class="title-page-1 text-center">SHOP</div>
    <div id="product-" data-category-slug="" data-product-weight-number=""
        data-product-add-price="<?= $detail_product['real_price'] ?>">
        <div class="page-title-wrapper row d-md-none">
            <div class="col-12">
                <h1 class="page-title">
                    <span class="base text-bold" data-ui-id="page-title-wrapper" itemprop="name">
                        <?= $detail_product['name'] ?>
                    </span>
                </h1>
            </div>
        </div>

        <div class="product-info-main-top row product-box-shadow text-center">
            <div class="col-md-6 col-12 extra-padding">
                <div id="img-container" class="img-magnifier-container" style="max-height: 260px;">
                    <img id="myimage" src="{{ $images[0] }}" class="product-image"
                        style="width: auto; height: 260px">
                </div>
                @if (count($images) > 1)
                    <div class="row justify-content-evenly justify-content-md-center pt-4" style="max-height: 50px;">
                        @foreach ($images as $image)
                            @php
                                $class = $image == $images[0] ? ' active' : '';
                            @endphp
                            <div class="col-2 thumb-container" style="height: 50px;">
                                <img class="thumbs{{ $class }}" src="{{ $image }}" class="product-thumb"
                                    style="width: auto; height: 100%; margin: auto;">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-md-6 col-12">
                <br class="d-md-block">
                <br class="d-none d-md-block">
                <div class="page-title-wrapper row g-0 d-none d-md-flex">
                    <div class="col-12">
                        <h1 class="page-title">
                            <span class="base text-bold" data-ui-id="page-title-wrapper" itemprop="name">
                                <?= $detail_product['name'] ?>
                            </span>
                        </h1>
                    </div>

                </div>
                <br>
                <div class="row">
                    <div class="col-6 col-md-3 text-start text-bold text-cap color-yellow no-padding">
                        Category
                    </div>
                    <div class="col-6 col-md-9 text-end text-cap color-yellow">
                        <?= $detail_product['metal_name'] ?>
                    </div>
                </div>
                <br class="d-none d-md-block">
                <div class="row">
                    <div class="col-6 col-md-3 text-start text-bold text-cap color-yellow no-padding">
                        Price
                    </div>
                    <div class="col-6 col-md-9 text-end text-cap color-yellow">
                        <?= $currency ?> $<?= number_format($detail_product['real_price'], 2) ?>
                    </div>
                </div>

                <br><br class="d-none d-md-block">
                <form action="{{ route('cart.add') }}" method="post" id="add-to-cart" class="cart">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $userId }}">
                    <input type="hidden" name="product_id" id="product_id" value="{{ $detail_product['id'] }}">
                    <input type="hidden" name="current_price" id="current_price"
                        value="{{ $detail_product['real_price'] }}">
                    <input type="hidden" name="currency" id="currency" value="{{ $currency }}">
                    <input type="hidden" id="weight" name="weight" value="{{ $detail_product['weight_oz'] }}">
                    <div class="row align-items-end">
                        <div class="col-6">
                            <div class="quantity">
                                <input type="number" id="quantity" step="1" min="1" max=""
                                    name="quantity" title="Qty" size="4" value="1"
                                    class="input-text qty text">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="product-info-stock-sku">
                                <div class="available  text-right color-light-green text-cap text-bold"
                                    title="Availability">
                                    <span>IN STOCK</span>
                                </div>
                            </div>
                            <button type="submit" name="btn"
                                class="single_add_to_cart_button-sp button makeup-btn-dark-green"
                                data-id="{{ $detail_product['id'] }}" data-category-slug="">Buy</button>
                        </div>
                    </div>
                </form>
                <br>
                <div class="row g-0 percent-header">
                    <div class="col-6 text-center text-bold">Quantity</div>
                    <div class="col-6 text-center text-bold">Price</div>
                </div>

                <div class="row g-0 percent-row">
                    <div class="col-6 text-center">1 - 9</div>
                    <div class="col-6 text-center table-price-item" data-product-id="" data-quantity="">
                        <?= number_format($detail_product['real_price'], 2) ?></div>
                </div>
                <div class="row g-0 percent-row">
                    <div class="col-6 text-center">10 - 24</div>
                    <div class="col-6 text-center table-price-item" data-product-id="" data-quantity="">
                        <?= number_format($detail_product['real_price'], 2) ?></div>
                </div>
                <div class="row g-0 percent-row">
                    <div class="col-6 text-center">25 - 49</div>
                    <div class="col-6 text-center table-price-item" data-product-id="" data-quantity="">
                        <?= number_format($detail_product['real_price'], 2) ?></div>
                </div>
                <div class="row g-0 percent-row">
                    <div class="col-6 text-center">50 - ∞</div>
                    <div class="col-6 text-center table-price-item" data-product-id="" data-quantity="">
                        <?= number_format($detail_product['real_price'], 2) ?></div>
                </div>
                <br>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="color-dark-green text-cap text-bold">Product Specifications</div>
                <div class="gray-line my-2"></div>
                <div class="row spec-row">
                    <div class="col-6 text-bold text-cap">
                        <b>Category</b>
                    </div>
                    <div class="col-6 text-cap">
                        <?= $detail_product['metal_name'] ?>
                    </div>
                </div>
                <div class="row spec-row">
                    <div class="col-6 text-bold text-cap">
                        <b>WEIGHT</b>
                    </div>
                    <div class="col-6 text-cap">
                        <?= $detail_product['weight'] ?>
                    </div>
                </div>
                <div class="row spec-row">
                    <div class="col-6 text-bold text-cap">
                        <b>PURITY</b>
                    </div>
                    <div class="col-6 text-cap">
                        <?= $detail_product['purity'] ?>
                    </div>
                </div>
                <div class="row spec-row">
                    <div class="col-6 text-bold text-cap">
                        <b>PRODUCER</b>
                    </div>
                    <div class="col-6 text-cap">
                        <?= $detail_product['producer'] ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="heading text-cap color-dark-green text-bold">Product Description</div>
                <div class="gray-line my-2"></div>
                <div class="content-area">
                    <p></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="heading text-cap color-dark-green text-bold">Shipping Detail</div>
                <div class="gray-line my-2"></div>
                <div class="content-area">
                    <p>All our parcels are packed in secured unbranded boxes and are delivered fully insured with great
                        caution.</p>
                    <p>Average delivery duration varies from 1 to 10 business days and depends primarily on the
                        destination and shipping option selected.</p>
                    <p>Our shipping rates include fully insured delivery for all products being shipped.</p>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</div>
@include('footer')
