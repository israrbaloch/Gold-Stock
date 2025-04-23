@extends('header.index')

@section('extratitle')
    Write a Review
@endsection

@push('styles')
    <style>
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
        }
    </style>
@endpush

@section('content')
<section class="container py-5">
    <h1>Give feedback for your order</h1>

    <p>Order Number: <strong>#{{ $order->orderid }}</strong></p>
    <p>Please provide your feedback for the products you purchased:</p>

    {{-- show all errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reviews.store') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        {{-- user_id --}}
        <input type="hidden" name="user_id" value="{{ $order->user_id }}">

        @foreach ($order->products as $product)
        {{-- @php
            dd($product);
        @endphp --}}
            <div style="margin-bottom: 30px; border: 1px solid #ccc; padding: 15px; border-radius: 5px;">
                @php
                    $imagesData = json_decode($product->getImages());
                    $image = is_array($imagesData) && count($imagesData) > 0 ? asset('storage/' . str_replace('\\', '/', $imagesData[0])) : asset(explode(',', $product->images)[0]);
                @endphp
                <div class="col-lg-12 row">
                    <div class="col-lg-1">
                        <img src="{{ $image }}" alt="{{ $product->name }}" 
                    style="max-width: 100px; height: auto; margin-bottom: 10px;">
                    </div>
                    <div class="col-lg-11 d-flex align-items-center ps-4">
                        <h3>{{ $product->name }}</h3>
                    </div>
                </div>

                {{-- <p>Price: ${{ number_format($product->price, 2) }}</p> --}}

                <input type="hidden" name="products[{{ $product->id }}][product_id]" value="{{ $product->product_id }}">

                <div class="my-3">
                    <label>Rating:</label>
                    <div class="star-rating" data-product-id="{{ $product->id }}" style="display: flex; gap: 5px; cursor: pointer;">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="far fa-star" data-value="{{ $i }}" style="font-size: 24px; color: #ccc;"></i>
                        @endfor
                    </div>
                    <input type="hidden" name="products[{{ $product->id }}][rating]" id="rating_{{ $product->id }}" value="0" required>
                </div>

                <div class="my-3">
                    <label for="review_{{ $product->id }}">Review:</label>
                    <textarea name="products[{{ $product->id }}][review]" id="review_{{ $product->id }}" rows="4" style="width: 100%;" required></textarea>
                    {{-- error --}}
                    @error('review')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        @endforeach

        <button type="submit" class="button px-5 py-3">
            Submit Review
        </button>
    </form>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.star-rating').each(function () {
            const $ratingContainer = $(this);
            const productId = $ratingContainer.data('product-id');
            const $hiddenInput = $(`#rating_${productId}`);
            const $stars = $ratingContainer.find('.fa-star');

            $stars.on('click', function () {
                const selectedValue = $(this).data('value');
                $hiddenInput.val(selectedValue);

                // Update star colors
                $stars.each(function (index) {
                    if (index < selectedValue) {
                        $(this).removeClass('far').addClass('fas').css('color', '#FFD700'); // Gold for selected
                    } else {
                        $(this).removeClass('fas').addClass('far').css('color', '#ccc'); // Gray for unselected
                    }
                });
            });
        });
    });
</script>
@endpush
