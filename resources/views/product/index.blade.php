@extends('header.index')

@section('extratitle')
    {{ $product['name'] }}
@endsection

@php
    $currency = Cookie::get('currency');
    // Decode the JSON-encoded product images
    $images = json_decode($product['images']);

    // Check if the decoded value is an array
    if (is_array($images)) {
        // Replace backslashes with forward slashes in the image path and prepend the 'storage/' directory
        foreach ($images as $i => $image) {
            $images[$i] = '/storage/' . str_replace('\\', '/', $image);
        }
    } else {
        // Assume the decoded value is a comma-separated list of image paths
        $images = explode(',', $product['images']);
    }
@endphp

@push('styles')
    <link href="{{ asset('css/style-new.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script>
        const product = @json($product);
    </script>
    <script type="text/javascript" src="{{ mix('js/product/product.js') }}"></script>

    <script>
        $(document).ready(function() {
            function loadReviews(page = 1) {
                const productId = '{{ $product->id }}';
                const url = `/product/${productId}/reviews?page=${page}`;

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#reviews-container').html(response);
                        attachPaginationLinks();
                    },
                    error: function(error) {
                        console.error('Failed to load reviews:', error);
                    }
                });
            }

            function attachPaginationLinks() {
                $('#pagination-container .pagination a').on('click', function(e) {
                    e.preventDefault();
                    const page = $(this).attr('href').split('page=')[1];
                    loadReviews(page);
                });
            }

            // Initial load
            loadReviews();
        });
    </script>

    <script>
        // if session has alert_created then swl
        @if (session('alert_created'))
            Swal.fire({
                icon: 'success',
                title: '{{ session('alert_created') }}',
                text: 'You will be notified when the price reaches the specified value.',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>
@endpush


@section('content')
    <div class="page-container container product-page-container">
        <div class="title-page-1 text-center">SHOP</div>
        <div id="product-">

            <div class="product-container">
                <div class="images-container">
                    @if (count($images) > 1)
                        <div class="product-thumbs">
                            @foreach ($images as $image)
                                @php
                                    $class = $image == $images[0] ? ' active' : '';
                                @endphp
                                <div class="thumb-container">
                                    <img class="thumbs{{ $class }}" src="{{ $image }}">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="main-image-container">
                        <img class="main-image" src="{{ $images[0] }}" alt="{{ $product['name'] }}">
                    </div>
                </div>

                <div class="details-container">

                    <div class="title-container">
                        <h1>
                            {{ $product['name'] }}
                        </h1>

                        <div class="d-flex">
                            <div>
                                <p>
                                    <span>
                                        {{ $currency }}
                                    </span>
                                    $<span id="price">{{ number_format($product['real_price'], 2) }}</span>
                                </p>

                                <div class="rating mt-2">
                                    <div class="rating-stars">
                                        @php
                                            $rating = $product->reviews->avg('rating');
                                        @endphp
                                        {{-- fa fa-star --}}
                                        <span class="">
                                            @for ($j = 0; $j < 5; $j++)
                                                @if ($j + 1 <= $rating)
                                                    <i class="fas fa-star rating-star"></i>
                                                @elseif ($j < $rating)
                                                    <i class="fas fa-star-half-alt rating-star"></i>
                                                @else
                                                    <i class="far fa-star rating-star"></i>
                                                @endif
                                            @endfor
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="notify-me-container ms-auto mt-auto">
                                @auth
                                    <button class="button medium px-4" data-bs-toggle="modal"
                                        data-bs-target="#productAlertModal">
                                        <i class="far fa-bell me-2"></i>
                                        Notify Me
                                    </button>
                                @else
                                    <button class="button medium px-4 login-modal-trigger" data-bs-toggle="modal"
                                        data-bs-target="#loginModal">
                                        <i class="far fa-bell me-2"></i>
                                        Notify Me
                                    </button>
                                @endauth
                            </div>

                            @include('header.product-alert-modal')
                        </div>
                    </div>

                    <div class="buy-container">
                        <form action="{{ route('cart.add') }}" method="post" id="add-to-cart" class="cart">
                            @csrf
                            <input type="hidden" name="product_id" id="product_id" value="{{ $product['id'] }}">
                            <input type="hidden" name="current_price" id="current_price"
                                value="{{ $product['real_price'] }}">
                            <input type="hidden" name="currency" id="currency" value="{{ $currency }}">

                            <div class="options-container">
                                <div class="options-title">
                                    <label for="quantity">Quantity:</label>
                                </div>
                                <div class="options d-flex align-items-center">
                                    {{-- <div class="quantity">
                                        <input type="number" id="quantity" step="1" min="1" max=""
                                            name="quantity" value="1">
                                    </div> --}}
                                    <div class="input-group- ms-auto quantity align-items-center d-flex">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="quantity-decrement">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" id="quantity" step="1" min="1" max=""
                                            name="quantity" value="1" class="text-center onlyNumber">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="quantity-increment">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    @if ($product['in_stock'])
                                        <button type="submit" name="btn" class="button medium my-auto">Add to
                                            Cart</button>
                                    @else
                                        <button type="button" class="button medium disabled-btn-" disabled>Out of
                                            stock</button>
                                    @endif
                                </div>
                                @if ($product['in_stock'])
                                    <div class="availability" title="Availability">
                                        <span>In Stock</span>
                                    </div>
                                @else
                                    <div class="text-danger" title="Availability">
                                        <span>Out of Stock</span>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>

                    {{-- <div class="row">
                    <div class="col-6 col-md-3 text-start text-bold text-cap color-yellow no-padding">
                        Category
                    </div>
                    <div class="col-6 col-md-9 text-end text-cap color-yellow">
                        {{$product['metal_name']}}
                    </div>
                </div> --}}
                    {{-- <div class="row">
                    <div class="col-6 col-md-3 text-start text-bold text-cap color-yellow no-padding">
                        Price
                    </div>
                    <div class="col-6 col-md-9 text-end text-cap color-yellow">
                        {{ $currency }} ${{ number_format($product['real_price'], 2) }}
                    </div>
                </div> --}}

                    <table class="price-table">
                        <thead>
                            <tr>
                                <th>Quantity</th>
                                <th>Bank payment/Cheque</th>
                                <th>PayPal/Credit card</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $real_price = $product->original_price;

                                // $real_price = $product['real_price'];

                                // dd($product['real_price'] * $product['percent_interval_1']);

                            @endphp
                            <tr>
                                <td>1-9</td>
                                <td>
                                    $<span id="interval1">
                                        {{ number_format($real_price + $product['percent_interval_1'], 2) }}
                                    </span>
                                </td>
                                <td>
                                    $<span id="interval1_1">
                                        {{ number_format($real_price + $product['percent_interval_cc_1'], 2) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>10-24</td>
                                <td>
                                    $<span id="interval2">
                                        {{ number_format($real_price + $product['percent_interval_2'], 2) }}
                                    </span>
                                </td>
                                <td>
                                    $<span id="interval2_1">
                                        {{ number_format($real_price + $product['percent_interval_cc_2'], 2) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>25-49</td>
                                <td>
                                    $<span id="interval3">
                                        {{ number_format($real_price + $product['percent_interval_3'], 2) }}
                                    </span>
                                </td>
                                <td>
                                    $<span id="interval3_1">
                                        {{ number_format($real_price + $product['percent_interval_cc_3'], 2) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>50-∞</td>
                                <td>
                                    $<span id="interval4">
                                        {{ number_format($real_price + $product['percent_interval_4'], 2) }}
                                    </span>
                                </td>
                                <td>
                                    $<span id="interval4_1">
                                        {{ number_format($real_price + $product['percent_interval_cc_4'], 2) }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @if ($product['description'])
                        <section>
                            <div class="title-container">
                                <h2>
                                    Product Description
                                </h2>
                                <div class="icon">
                                    <img src="{{ asset('img/icons/arrow-down.png') }}" alt="">
                                </div>
                            </div>
                            <div class="content-container">
                                <div class="content">
                                    <p>
                                        {{ $product['description'] }}
                                    </p>
                                </div>
                            </div>
                        </section>
                    @endif
                    <section>
                        <div class="title-container">
                            <h2>
                                Product Specifications
                            </h2>
                            <div class="icon">
                                <img src="{{ asset('img/icons/arrow-down.png') }}" alt="">
                            </div>
                        </div>
                        <div class="content-container">
                            <div class="content">

                                <div class="row spec-row">
                                    <div class="col-6 text-bold text-cap">
                                        <b>Category</b>
                                    </div>
                                    <div class="col-6 text-cap">
                                        {{ $product['metal_name'] }}
                                    </div>
                                </div>
                                <div class="row spec-row">
                                    <div class="col-6 text-bold text-cap">
                                        <b>Weight</b>
                                    </div>
                                    <div class="col-6 text-cap">
                                        {{ $product['weight'] }}
                                    </div>
                                </div>
                                <div class="row spec-row">
                                    <div class="col-6 text-bold text-cap">
                                        <b>Purity</b>
                                    </div>
                                    <div class="col-6 text-cap">
                                        {{ $product['purity'] }}
                                    </div>
                                </div>
                                <div class="row spec-row">
                                    <div class="col-6 text-bold text-cap">
                                        <b>Producer</b>
                                    </div>
                                    <div class="col-6 text-cap">
                                        {{ $product['producer'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="title-container">
                            <h2>
                                Shipping Detail
                            </h2>
                            <div class="icon">
                                <img src="{{ asset('img/icons/arrow-down.png') }}" alt="">
                            </div>
                        </div>
                        <div class="content-container">
                            <div class="content">

                                <p>All our parcels are packed in secured unbranded boxes and are delivered fully insured
                                    with great caution.</p>
                                <p>Average delivery duration varies from 1 to 10 business days and depends primarily on the
                                    destination and shipping option selected.</p>
                                <p>Our shipping rates include fully insured delivery for all products being shipped.</p>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="title-container">
                            <h2>
                                Price match gurantee
                            </h2>
                            <div class="icon">
                                <img src="{{ asset('img/icons/arrow-down.png') }}" alt="">
                            </div>
                        </div>
                        {{-- <div class="content-container">
                            <div class="content">
                                <p>
                                    {{ $product['description'] }}
                                </p>
                            </div>
                        </div> --}}
                    </section>

                </div>
            </div>

            <div class="d-flex justify-content-center container">
                <div class="product-details-container">
                    @if ($product['description'])
                        <div class="content-container">
                            <h2>
                                Product Description
                            </h2>
                            <div class="content">
                                <p>
                                    {{ $product['description'] }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="content-container">
                        <h2>
                            Product Specifications
                        </h2>
                        <div class="content">
                            <p>Category: {{ $product['metal_name'] }}</p>
                            <p>Weight: {{ $product['weight'] }}</p>
                            <p>Purity: {{ $product['purity'] }}</p>
                            <p>Producer: {{ $product['producer'] }}</p>
                        </div>
                    </div>

                    <div class="content-container">
                        <h2>
                            Shipping Detail
                        </h2>
                        <div class="content">
                            <p>All our parcels are packed in secured unbranded boxes and are delivered fully insured
                                with great caution.</p>
                            <p>Average delivery duration varies from 1 to 10 business days and depends primarily on the
                                destination and shipping option selected.</p>
                            <p>Our shipping rates include fully insured delivery for all products being shipped.</p>
                        </div>
                    </div>

                    <div class="content-container">
                        <h2>
                            Price match gurantee
                        </h2>
                    </div>
                </div>
            </div>

            {{-- Related Products --}}
            @php
                $metals = [1183 => 'Gold', 1677 => 'Silver', 1681 => 'Platinum', 1682 => 'Palladium'];
            @endphp
            @include('product.related-products')


            {{-- reviews --}}
            @include('product.reviews')
        </div>
    </div>
@endsection
