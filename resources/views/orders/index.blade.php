@extends('header.index')

@php
    global $wpdb;
    $table_name = 'ic_order_metals';
    $table_name2 = 'ic_deposit_order';
@endphp

@push('styles')
    <link href="{{ URL::to('/') }}/css/order-history.css?ver=1.2.0" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ URL::to('/') }}/js/order-history.js?ver=1.5.0"></script>
    <script type="text/javascript">
        var ordersDetails = @json($deposits);
    </script>
    <script type="text/javascript" src="{{ URL::to('/') }}/js/modal.js?ver=1.4.0"></script>
@endpush

@section('content')
    <div class="page-container container orders-container">
        <div class="d-none d-md-block desktop-version">
            <div class="title-page-1 text-center">Order History</div>
            <div class="row tabs-change">
                <div class="col-12 tab-change back-to-history active">
                    Order History
                </div>
            </div>

            <table class="table no-style">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Order Type</th>
                        <th scope="col">Type</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($deposits) < 1)
                        {{-- No Data --}}
                        <tr>
                            <td colspan="6">
                                <div class="no-data text-gray-400">No data available</div>
                            </td>
                        </tr>
                    @else
                        {{-- With Data --}}
                        @php
                            $content_counter = 0;
                        @endphp
                        @foreach ($deposits as $desposit)
                            @php
                                $date = Carbon\Carbon::parse($desposit['date']);
                            @endphp
                            <tr class="toogle-details display-row-{{ $content_counter }}"
                                data-deposit-id="{{ $content_counter }}">
                                {{-- Order Type --}}
                                <td class="order-type">
                                    @if (!$desposit['order_type'] == null)
                                        @if ($desposit['order_type'] == 'Buy')
                                            <span style="color:green">{{ $desposit['order_type'] }}</span>
                                        @elseif ($desposit['order_type'] == 'Sell')
                                            <span style="color:red">{{ $desposit['order_type'] }}</span>
                                        @else
                                            {{ $desposit['order_type'] }}
                                        @endif
                                    @endif
                                </td>
                                {{-- Metal --}}
                                <td align="center">
                                    @if ($desposit['mtp'] == 'metal')
                                        <span>{{ $desposit['metal_name'] }}</span> /
                                        {{ $desposit['currency'] }}
                                    @else
                                        <span>Product</span> / {{ $desposit['currency'] }}
                                    @endif
                                </td>
                                {{-- Price --}}
                                <td align="center">
                                    @php
                                        $val = $desposit['quantity'] > 0 ? $desposit['priceproduct'] / $desposit['quantity'] : 0;
                                        if ($desposit['order_type'] == 'Shop') {
                                            $val = $desposit['priceproduct'];
                                        }
                                    @endphp
                                    ${{ number_format($val, 2) }}
                                </td>
                                {{-- Quantity --}}
                                <td align="center">
                                    {{ number_format($desposit['quantity']) }}
                                </td>
                                {{-- Total --}}
                                <td align="center">
                                    {{ number_format($desposit['priceproduct'], 2) }} {{ $desposit['currency'] }}
                                </td>
                                {{-- Date --}}
                                <td>
                                    {{ date_format($date, 'g:i A\, Y-m-d') }}
                                </td>
                            </tr>
                            @php
                                $content_counter++;
                            @endphp
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-block d-md-none only-mobile" style="margin-top: 20px;">
            <div class="row tab-link">
                <div class="col-12 text-center active actions mobile-back-to-history">
                    <a class="color-dark-green text-bold" href="#">Order History</a>
                </div>
                <div class="col-6 text-center actions mobile-details-title d-none">
                    <a class="color-dark-green text-bold" href="#">Order Details</a>
                </div>
            </div>
            <div class="metals-container mobile-hide-for-tab">
                <table class="mobile-metal-table no-style" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>Metal</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $content_counter = 0;
                        @endphp
                        @foreach ($deposits as $desposit)
                            @php
                                $date = Carbon\Carbon::parse($desposit['date']);
                            @endphp
                            <tr class="mobile-toogle-details toogle-details display-row-{{ $content_counter }}"
                                data-deposit-id="{{ $content_counter }}">
                                {{-- <div> --}}
                                <td class="order-type">
                                    @if (
                                        $desposit['product'] == 'Gold' ||
                                            $desposit['product'] == 'Silver' ||
                                            $desposit['product'] == 'Palladium' ||
                                            $desposit['product'] == 'Platinum')
                                        <span>{{ $desposit['product'] }}</span> /
                                        {{ $desposit['currency'] }}
                                    @else
                                        <span>Product</span> / {{ $desposit['currency'] }}
                                    @endif
                                    {{-- </div> --}}
                                    <div class="order-date">
                                        @if (!$desposit['order_type'] == null)
                                            @if ($desposit['order_type'] == 'Buy')
                                                <span style="color:green">{{ $desposit['order_type'] }}</span>
                                            @elseif ($desposit['order_type'] == 'Sell')
                                                <span style="color:red">{{ $desposit['order_type'] }}</span>
                                            @else
                                                <span
                                                    style="color:black; font-weight:600;">{{ $desposit['order_type'] }}</span>
                                            @endif
                                        @endif
                                        <br>
                                        {{ date_format($date, 'g:i A\, Y-m-d') }}
                                    </div>
                                </td>
                                <td>
                                    ${{ number_format($desposit['priceproduct'], 2) }}
                                </td>
                                <td class="text-right">
                                    @if (
                                        $desposit['product'] == 'Gold' ||
                                            $desposit['product'] == 'Silver' ||
                                            $desposit['product'] == 'Palladium' ||
                                            $desposit['product'] == 'Platinum')
                                        <div>Q:{{ $desposit['quantity'] }} /OZ</div>
                                    @else
                                        <div>Q:{{ $desposit['quantity'] }}</div>
                                    @endif
                                    <div><br></div>
                                    <div>T:${{ number_format($desposit['priceproduct'] * $desposit['quantity'], 2) }}</div>
                                </td>
                            </tr>

                            @php
                                $content_counter++;
                            @endphp
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div id="tab-mobile-order-details" class="tab-mobile-order-details d-none">
                <div class="simple-order-details order">
                    <div class="row g-0 px-1 title">
                        <div class="col-6 text-cap text-bold color-dark-green">
                            <!-- Your Order --> Order <span class="order-number"></span>
                        </div>
                        <div class="col-6 text-cap text-bold color-dark-green">
                            <span class="order-date"></span>
                        </div>
                        <br><br>
                        <div class="col-6 text-bold color-yellow">
                            <span class="status-pay"></span>
                        </div>

                        <div class="col-6 text-bold color-yellow">
                            <span class="status-shipping"></span>
                        </div>

                    </div>
                    <div class="content-title text-bold row g-0 px-1">
                        <div class="text-cap col-5">
                            Product:
                        </div>
                        <div class="text-cap col-2">
                            Qty
                        </div>
                        <div class="text-cap col-5">
                            Price
                        </div>
                    </div>
                    <div class="content row">
                        <div class="content row g-0 px-2 product-rows">
                        </div>
                    </div>
                    <div class="total row g-0 px-1">
                        <div class="col-6 text-cap">
                            Total:
                        </div>
                        <div class="col-6 color-yellow">
                            $<span class="total-order"></span> / <span class="currency"></span>
                        </div>
                    </div>
                    <div class="shipping-opt row g-0 px-1">
                        <div class="text-cap col-6 text-cap">
                            Shipping Option:
                        </div>
                        <div class="col-6 color-yellow text-cap">
                            <span class="shipping-option"></span>
                        </div>
                    </div>
                    <div class="shipping-track row">
                        <div class="text-cap col-6 text-cap">
                            Tracking Number
                        </div>
                        <div class="col-6 color-yellow text-cap">
                            #<span class="tracking-number"></span>
                        </div>
                    </div>
                    <div class="shipping-opt row g-0 px-1">
                        <div class="col-6 text-cap">
                            <span class="fedex-name"></span>
                        </div>
                        <div class="col-6 color-yellow text-cap">
                            <span class="fedex-price"></span>
                        </div>
                    </div>
                    <div class="subtotal row g-0 px-1">
                        <div class="text-cap col-6">
                            Subtotal:
                        </div>
                        <div class="col-6 color-yellow">
                            $<span class="sub-total"></span>/<span class="currency"></span>
                        </div>
                    </div>

                    <div class="percent row g-0 px-1">
                        <div class="text-cap col-6">
                            Paid:
                        </div>
                        <div class="col-6 color-yellow">
                            $<span class="total-paid"></span>/<span class="currency"></span>
                        </div>
                    </div>
                    <div class="percent row g-0 px-1 payments-title">
                        <div class="text-cap col-12 text-bold">
                            PAYMENTS:
                        </div>
                    </div>
                    <div class="content-title text-bold row g-0 px-1 payments-order">

                    </div>
                    <div class="pending payment-complete row g-0 px-1">
                        <div class="text-cap col-7">
                            PAYMENT COMPLETE
                        </div>
                        <div class="col-5 color-yellow">

                        </div>
                    </div>
                    <div class="payment row d-none" id="payment-method">
                        <div class="text-cap col-7">
                            PAYMENT METHOD:
                        </div>
                        <div class="col-5 color-yellow">
                            <span class="method-pay">FROM BALANCE ACCOUNT</span>
                        </div>
                    </div>
                    <div class="pending row payment-pending">
                        <div class="text-cap col-7">
                            PENDING BALANCE:
                        </div>
                        <div class="col-5 color-yellow">
                            <span class="pending-pay"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal" class="modal-container orders-modal">
        <div id="tab-desk-details" class="tab-conversion-details">
            <button id="modal-close" type="button" class="btn-close" aria-label="x"></button>
            <div class="titles-container">
                <div class="back-button modal-close">
                    Order History
                </div>
                <div class="modal-title">
                    Order Details
                </div>
            </div>
            <div class="simple-order-details">
                <div class="row title">
                    <div class="col-3">
                        ORDER
                        <span class="order-number"></span>
                    </div>
                    <div class="col-3">
                        <span class="order-date"></span>
                    </div>
                    <div class="col-3">
                        <span class="status-pay"></span>
                    </div>
                    <div class="col-3">
                        <span class="status-shipping"></span>
                    </div>
                </div>
                <div class="row content product-rows">
                </div>
                <div class="shipping-opt row">
                    <div class="col-6">
                        Shipping Option:
                    </div>
                    <div class="col-6">
                        <span class="shipping-option"></span>
                    </div>
                </div>
                <div class="shipping-track row">
                    <div class="col-6">
                        Tracking Number
                    </div>
                    <div class="col-6">
                        #<span class="tracking-number"></span>
                    </div>
                </div>
                <div class="shipping-opt row">
                    <div class="col-6">
                        <span class="fedex-name"></span>
                    </div>
                    <div class="col-6">
                        <span class="fedex-price"></span>
                    </div>
                </div>
                <div class="subtotal row">
                    <div class="col-6">
                        Subtotal:
                    </div>
                    <div class="col-6">
                        $<span class="sub-total"></span>/<span class="currency"></span>
                    </div>
                </div>
                <div class="percent row">
                    <div class="col-6">
                        Paid:
                    </div>
                    <div class="col-6">
                        -$<span class="total-paid"></span>/<span class="currency"></span>
                    </div>
                </div>
                <div class="fee row">
                    <div class="col-6">
                        3.75% Processing fee:
                    </div>
                    <div class="col-6">
                        $<span class="fee-paid"></span>/<span class="currency"></span>
                    </div>
                </div>
                <div class="total row">
                    <div class="col-6 ">
                        Total:
                    </div>
                    <div class="col-6">
                        $<span class="total-order"></span>/<span class="currency"></span>
                    </div>
                </div>

                <div class="percent-pay row payments-title">
                    <div class="col-12 text-bold">
                        PAYMENTS:
                    </div>
                </div>
                <div class="row payments-order">

                </div>
                <div class="content row payment-row d-none">
                    <div class="col-4">
                        <span class="order-date"></span>
                    </div>
                </div>
                <div class="col-5">
                    <span class="method-pay"></span>
                </div>

                <div class="pending payment-complete row">
                    <div class="col-6">
                        PAYMENT COMPLETE
                    </div>
                    <div class="col-6">

                    </div>
                </div>
                <div class="payment row d-none" id="payment-method">
                    <div class="col-6">
                        PAYMENT METHOD:
                    </div>
                    <div class="col-6">
                        <span class="method-pay">FROM BALANCE ACCOUNT</span>
                    </div>
                </div>
                <div class="pending row payment-pending">
                    <div class="col-6">
                        PENDING BALANCE:
                    </div>
                    <div class="col-6">
                        <span class="pending-pay"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
