@extends('header.index')
@php
    $user = Auth::user();
@endphp

@php
    if ($type == 'product') {
        $subTotal = $order->priceproduct;
    } else {
        $subTotal = $order->value;
    }

    $paymentMethod = $order->payment_method;

    if ($paymentMethod == 2) {
        $initialDeposit = floor(($subTotal - $order->promo_code_discount) * 0.1 * 100) / 100;
    } else {
        $initialDeposit = $subTotal - $order->promo_code_discount;
    }

    // $initialDeposit = $order->has_fee ? floor(($subTotal - $order->promo_code_discount) * 0.1 * 100) / 100 : 0;
    if ($subTotal > $shippingOption->free_from) {
        $initialDeposit += $shippingOption->price * 0.1;
    }
    $fee = $order->has_fee ? floor($initialDeposit * 0.0375 * 100) / 100 : 0;
    $total = $type == 'cash' ? $subTotal : round($order->subtotal, 2);
    $paid = $order->payed;
    if ($subTotal > $shippingOption->free_from) {
        // $paid += $shippingOption->price * 0.1;
        $total += $shippingOption->price;
    }
    $total -= $order->promo_code_discount;

    // if ($subTotal > $shippingOption->free_from) {
    //     $pending -= $shippingOption->price * 0.1;
    // }
    $fromBalance = 0;
    $total = $order->total;

    $pending = $total - $paid;
@endphp

@push('styles')
    <link href="{{ mix('css/order.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://api.convergepay.com/hosted-payments/PayWithConverge.js"></script>
@endpush

@section('content')
    <div class="container page-container-cart order-container">
        <div>
            <h1>
                Thanks for your order!
            </h1>
            <span>
                Order number: <b>{{ $type != 'cash' ? $order->order_id : 'CD' . $order->id }}</b>
            </span>
        </div>
        <br>

        @include('order.products-desktop')
        @include('order.products-mobile')

        <div class="description">
            <h2>
                Order Details
            </h2>

            <hr>

            <div class="content">
                <div class="left">
                    <div class="detail">
                        <span class="title">
                            Order number:
                        </span>
                        <span class="value">
                            {{ $type != 'cash' ? $order->order_id : 'CD' . $order->id }}
                        </span>
                    </div>
                    <div class="detail">
                        <span class="title">
                            Order Date:
                        </span>
                        <span class="value">
                            {{ date('m/d/Y', strtotime($order->created_at)) }}
                        </span>
                    </div>
                    {{-- Payment Method --}}
                    <div class="detail">
                        <span class="title">
                            Payment Method:
                        </span>
                        <span class="value">
                            {{ $paymentMethodName }}
                        </span>
                    </div>
                </div>
                <div class="right">
                    <div class="detail">
                        <span class="title">
                            Sub Total:
                        </span>
                        <span class="value" id="subtotal">
                            ${{ number_format($subTotal, 2) }} {{ $order->currency }}
                        </span>
                    </div>
                    @if ($type == 'product')
                        <div class="detail">
                            <span class="title">
                                Shipping Service:
                            </span>
                            <span class="value" id="shipping">
                                {{ $shippingOption->name }}
                                @if ($subTotal > $shippingOption->free_from && $shippingOption->price > 0)
                                    (${{ number_format($shippingOption->price, 2) }} {{ $order->currency }})
                                @else
                                    (Free)
                                @endif
                            </span>
                        </div>
                    @endif

                    @if ($paymentMethod != 3)
                    <div class="detail">
                        <span class="title">
                            <b>
                                Paid:
                            </b>
                        </span>
                        <span class="value">
                            <b>
                                <span id="dueNow">-${{ number_format($paid, 2) }} {{ $order->currency }}</span>
                            </b>
                        </span>
                    </div>
                    @endif

                    @if ($type != 'cash')
                        @foreach ($order->payments as $payment)
                            @php
                                $fromBalance += $payment['payment_method_id'] == 5 ? $payment['value'] : 0;
                            @endphp
                            @if ($payment['payment_method_id'] == 3)
                                @if ($order->payment_method == 2)
                                    <div class="detail">
                                        <span class="title" style="text-indent: 2rem;">
                                            10% Deposit:
                                        </span>
                                        <span class="value" id="initialDeposit">
                                            ${{ number_format($initialDeposit, 2) }} {{ $order->currency }}
                                        </span>
                                    </div>
                                    <div class="detail">
                                        <span class="title" style="text-indent: 2rem;">
                                            3.75% Processing fee:
                                        </span>
                                        <span class="value" id="fee">
                                            ${{ number_format($fee, 2) }} {{ $order->currency }}
                                        </span>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @else
                        <div class="detail">
                            <span class="title" style="text-indent: 2rem;">
                                3.75% processing fee:
                            </span>
                            <span class="value" id="fee">
                                ${{ number_format($order->value * 0.0375, 2) }} {{ $order->currency }}
                            </span>
                        </div>
                    @endif
                    {{-- @if ($subTotal > $shippingOption->free_from && $shippingOption->price > 0)
                    <div class="detail">
                        <span class="title" style="text-indent: 2rem;">
                            10% Shipping Fee
                        </span>
                        <span class="value">
                            ${{ number_format($shippingOption->price * 0.1, 2) . ' ' . $order->currency }}
                        </span>
                    </div>
                @endif --}}
                    {{-- Promo Code Discount --}}
                    @if ($order->promo_code_discount > 0)
                        <div class="detail">
                            <span class="title">
                                <b>
                                    Promo Code Discount:
                                </b>
                            </span>
                            <span class="value">
                                <b>
                                    -${{ number_format($order->promo_code_discount, 2) }} {{ $order->currency }}
                                </b>
                            </span>
                        </div>
                    @endif
                    @if ($type != 'cash')
                        <div class="detail">
                            <span class="title">
                                <b>
                                    Total:
                                </b>
                            </span>
                            <span class="value" id="total">
                                <b>
                                    ${{ number_format($total, 2) }} {{ $order->currency }}
                                </b>
                            </span>
                        </div>
                    @endif
                    @if ($type != 'cash')
                        {{-- @if ($fromBalance > 0)
                            <div class="detail">
                                <span class="title">
                                    From Balance on account:
                                </span>
                                <span class="value">
                                    ${{ number_format($fromBalance, 2) }} {{ $order->currency }}
                                </span>
                            </div>
                        @endif --}}
                        @if ($paymentMethod != 3)
                        <div class="detail">
                            <span class="title">
                                <b>
                                    Outstanding Balance:
                                </b>
                            </span>
                            <span class="value" id="pending">
                                <b>
                                    (${{ number_format($pending, 2) }} {{ $order->currency }})
                                </b>
                            </span>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
