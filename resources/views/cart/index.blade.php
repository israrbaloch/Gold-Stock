@extends('header.index')

@section('extratitle')
    Cart
@endsection

@php
    if (!Auth::user()) {
        // redirect to login page
        // return redirect()->route('login');
    }
    if ($cartId) {
        Cart::session($cartId);
    }
@endphp

@push('styles')
    <link href="{{ mix('css/cart.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script>
        const products = @json($products);
    </script>
    <script type="text/javascript" src="{{ mix('/js/cart/cart.js') }}"></script>
@endpush

@section('content')
    <div class="container cart-container">
        @if (!Cart::isEmpty())
            <div>
                <h1>
                    Shopping Cart
                </h1>
            </div>
            <br>
            <div id="cart-products">
                @include('cart.products-tables')
            </div>
            @include('cart.total')
        @else
            @include('cart.empty')
        @endif
    </div>
@endsection
