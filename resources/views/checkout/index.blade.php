@extends('header.index')
@php
    if ($cartId) {
        Cart::session($cartId);
    }
@endphp

@push('styles')
    <link href="/css/cart.css?ver=1.0.0" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="/js/checkout.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://api.convergepay.com/hosted-payments/PayWithConverge.js"></script>
    <script
        src="{{ app()->environment('production') ? 'https://gateway.moneris.com/chktv2/js/chkt_v2.00.js' : 'https://gatewayt.moneris.com/chktv2/js/chkt_v2.00.js' }}">
    </script>
    <script>
        const products = @json($products);
        const shippingPrice = @json($shippingOption->price);
    </script>
    <script type="text/javascript" src="{{ mix('/js/checkout/checkout.js') }}"></script>

    {{-- <script>
        $(document).ready(function () {
            $('#progressButtonShipping').on('click', function (e) {
                e.preventDefault();
                // ajax call to check the shipping address
                $.ajax({
                    url: '/check-shipping-address',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        if (response.success) {
                            // proceed to the next step
                            $('#progressButtonShipping').addClass('active');
                            $('#progressButtonSummary').trigger('click');
                        } else {
                            // do not proceed to the next step
                            return alert('Please fill in the shipping address');
                        }
                    },
                    error: function (error) {
                        return alert('Please fill in the shipping address');
                    }
                });
            });
        });
    </script> --}}
@endpush

@section('content')
    <input type="hidden" id="currency" disabled="disabled" value="{{ $currency }}">

    <br>
    <br>

    <div class="page-container-checkout">
        @if (!Cart::isEmpty())
            @php

                $paymentMethod = session('payment_method');
                $percent_interval_prefix = $paymentMethod == 2 ? 'percent_interval_' : 'percent_interval_cc_';

                $subTotal = 0;
                foreach ($products as $product) {
                    // $subTotal += $product->real_price * $product->quantity;
                    $subTotal += $product->PaymentMethodPrice($percent_interval_prefix . \App\Helper\Helper::getPercentInterval($product->quantity)) * $product->quantity;
                }

                // $subTotal = 0;
                // foreach ($products as $product) {
                //     $subTotal += $product->real_price * $product->quantity;
                // }

                $userBalance = $balance <= 0 ? 0 : round($balance, 2);

                $total = round($subTotal, 2);

                $promocode = session('promocode');
                $promoCodeDiscount = 0;
                if ($promocode) {
                    $promoCodeDiscount = App\Helper\Helper::getPromoCodeDiscount($promocode, $subTotal);
                    $total -= $promoCodeDiscount;
                }

                $paymentMethod = session('payment_method');

                if ($paymentMethod == 2) {
                    $initialDeposit = floor($total * 0.1 * 100) / 100;
                } else {
                    $initialDeposit = $total;
                }

                // $initialDeposit = floor($total * 0.1 * 100) / 100;
                if ($subTotal > $shippingOption->free_from) {
                    if ($paymentMethod == 2) {
                        $initialDeposit += $shippingOption->price * 0.1;
                    } else {
                        $initialDeposit += $shippingOption->price;
                    }
                    
                }

                if ($paymentMethod == 2) {
                    $fee = floor($initialDeposit * 3.75) / 100;
                } else {
                    $fee = 0;
                }

                // $dueNow = $initialDeposit + $fee - $userBalance;
                $dueNow = $initialDeposit + $fee;

                // dd($initialDeposit, $fee, $dueNow);
                
                if ($subTotal > $shippingOption->free_from) {
                    $total += $shippingOption->price;
                }

                $pending = $total - $initialDeposit;
                $total += $fee;

            @endphp

            <div class="progress-container">

                <div class="dot" data-step="shipping">
                    <span>Shipping</span>
                </div>
                <hr>
                <div class="dot" data-step="summary">
                    <span>Summary</span>
                </div>
                <hr>
                <div class="dot" data-step="payment">
                    <span>Payment</span>
                </div>
            </div>
            <div class="details-container">
                @include('checkout.shipping')
                @include('checkout.summary')
                @include('checkout.payment')
            </div>
        @else
            <div class="session-expired">
                <span class="title">Sorry, your session has expired.</span>
                <a class="button" href="/shop">Return to shop</a>
            </div>
        @endif
    </div>
    <br>
@endsection
