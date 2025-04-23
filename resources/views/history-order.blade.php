@include('header.index')
<link href="{{ URL::to('/') }}/css/order-history.css?ver=1.2.0" rel="stylesheet">
<script type="text/javascript" src="{{ URL::to('/') }}/js/order-history.js?ver=1.5.0"></script>


@php
    global $wpdb;
    $table_name = 'ic_order_metals';
    $table_name2 = 'ic_deposit_order';
@endphp

<div class="page-container container orders-container">
    <div class="d-none d-md-block desktop-version">
        <div class="title-page-1 text-center">Order History</div>
        {{-- <div class="gray-space"></div> --}}
        <div class="row tabs-change">
            <div class="col-12 tab-change back-to-history active">
                Order History
            </div>
            {{-- <div class="col-6 tab-change details-title active d-none">
                Order Details
            </div> --}}
        </div>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Order Type</th>
                    <th scope="col">Metal</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @if (count($depositRows) < 1)
                    <tr>
                        <td colspan="6">
                            <div class="no-data text-gray-400">No data available</div>
                        </td>
                    </tr>
                @else
                    @php
                        $content_counter = 0;
                    @endphp
                    @foreach ($depositRows as $dp)
                        @php
                            $date = Carbon\Carbon::parse($dp['date']);
                        @endphp
                        <tr class="toogle-details display-row-{{ $content_counter }}" data-id="{{ $content_counter }}">
                            <td class="order-type">
                                @if (!$dp['order_type'] == null)
                                    @if ($dp['order_type'] == 'Buy')
                                        <span style="color:green">{{ $dp['order_type'] }}</span>
                                    @elseif ($dp['order_type'] == 'Sell')
                                        <span style="color:red">{{ $dp['order_type'] }}</span>
                                    @else
                                        {{ $dp['order_type'] }}
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($dp['mtp'] == 'metal')
                                    <span>{{ $dp['metal_name'] }}</span> /
                                    {{ $dp['currency'] }}
                                @else
                                    <span>Product</span> / {{ $dp['currency'] }}
                                @endif
                            </td>
                            <td>
                                @php
                                    $val = $dp['quantity'] > 0 ? $dp['priceproduct'] / $dp['quantity'] : 0;
                                    if ($dp['order_type'] == 'Shop') {
                                        $val = $dp['priceproduct'];
                                    }
                                @endphp
                                $ {{ number_format($val, 2) }}
                            </td>
                            <td>
                                {{ $dp['order_type'] == 'Shop' ? '' : number_format($dp['quantity'], 5) }}
                            </td>
                            <td>
                                {{ $dp['order_type'] == 'Shop' ? '' : '$ ' . number_format($dp['priceproduct'], 2) }}
                            </td>
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

    {{-- <div id="tab-order-details" class="tab-order-details d-none">
        <div class="row title">
            <div class="col-3 text-cap text-bold color-dark-green">
                Order <span class="order-number"></span>
            </div>
            <div class="col-3 text-cap text-bold color-dark-green">
                <span class="order-date"></span>
            </div>
            <div class="col-3 text-bold color-yellow">
                <span class="status-pay"></span>
            </div>
            <div class="col-3 text-bold color-yellow">
                <span class="status-shipping"></span>
            </div>
        </div>
        <div class="content-title text-bold row">
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
        <div class="content row product-rows">

        </div>
        <div class="shipping-opt row">
            <div class="col-7 text-cap">
                Shipping Option:
            </div>
            <div class="col-5 color-yellow text-cap">
                <span class="shipping-option"></span>
            </div>
        </div>
        <div class="shipping-track row">
            <div class="col-7 text-cap">
                Tracking Number
            </div>
            <div class="col-5 color-yellow text-cap">
                #<span class="tracking-number"></span>
            </div>
        </div>
        <div class="shipping-opt row">
            <div class="col-7 text-cap">
                <span class="fedex-name"></span>
            </div>
            <div class="col-5 color-yellow text-cap">
                <span class="fedex-price"></span>
            </div>
        </div>

        <div class="subtotal row">
            <div class="text-cap col-7">
                Subtotal:
            </div>
            <div class="col-5 color-yellow">
                $<span class="sub-total"></span>/<span class="currency"></span>
            </div>
        </div>
        <div class="fee row">
            <div class="text-cap col-7">
                3.75% processing fee:
            </div>
            <div class="col-5 color-yellow">
                $<span class="fee-paid"></span>/<span class="currency"></span>
            </div>
        </div>
        <div class="total row">
            <div class="col-7 text-cap">
                Total:
            </div>
            <div class="col-5 color-yellow">
                $<span class="total-order"></span>/<span class="currency"></span>
            </div>
        </div>
        <div class="percent row">
            <div class="text-cap col-7">
                Paid:
            </div>
            <div class="col-5 color-yellow">
                -$<span class="total-paid"></span>/<span class="currency"></span>
            </div>
        </div>

        <div class="percent-pay row payments-title">
            <div class="text-cap col-12 text-bold">
                PAYMENTS:
            </div>
        </div>
        <div class="content-title text-bold row payments-order">

        </div>

        <div class="content row payment-row d-none">
            <div class="text-cap col-4 color-yellow">
                <span class="order-date"></span>
            </div>

        </div>
        <div class="text-cap col-5 color-yellow">
            <span class="method-pay"></span>
        </div>

        <div class="pending payment-complete row">
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
    </div> --}}

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
            <table class="mobile-metal-table" cellspacing="0" cellpadding="0">
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
                    @foreach ($depositRows as $dp)
                        <tr class="mobile-toogle-details toogle-details display-row-{{ $content_counter }}"
                            data-id="{{ $content_counter }}">
                            <div>
                                <td class="order-type">
                                    @if (
                                        $dp['product'] == 'Gold' ||
                                            $dp['product'] == 'Silver' ||
                                            $dp['product'] == 'Palladium' ||
                                            $dp['product'] == 'Platinum')
                                        <span>{{ $dp['product'] }}</span> /
                                        {{ $dp['currency'] }}
                                    @else
                                        <span>Product</span> / {{ $dp['currency'] }}
                                    @endif
                            </div>
                            <div class="order-date">
                                @if (!$dp['order_type'] == null)
                                    @if ($dp['order_type'] == 'Buy')
                                        <span style="color:green">{{ $dp['order_type'] }}</span>
                                    @elseif ($dp['order_type'] == 'Sell')
                                        <span style="color:red">{{ $dp['order_type'] }}</span>
                                    @else
                                        <span style="color:black; font-weight:600;">{{ $dp['order_type'] }}</span>
                                    @endif
                                @endif
                                {{ date_format($date, 'g:i A\, Y-m-d') }}
                            </div>
                            </td>
                            <td>
                                ${{ number_format($dp['priceproduct'], 2) }}
                            </td>
                            <td class="text-right">
                                @if (
                                    $dp['product'] == 'Gold' ||
                                        $dp['product'] == 'Silver' ||
                                        $dp['product'] == 'Palladium' ||
                                        $dp['product'] == 'Platinum')
                                    <div>Q:{{ $dp['quantity'] }} /OZ</div>
                                @else
                                    <div>Q:{{ $dp['quantity'] }}</div>
                                @endif
                                <div><br></div>
                                <div>T:${{ number_format($dp['priceproduct'] * $dp['quantity'], 2) }}</div>
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
        <div class="titles-container">
            <div id="modal-close" class="back-button modal-close">
                &lt; Order History
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
            <div class="fee row">
                <div class="col-6">
                    3.75% processing fee:
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
            <div class="percent row">
                <div class="col-6">
                    Paid:
                </div>
                <div class="col-6">
                    -$<span class="total-paid"></span>/<span class="currency"></span>
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

<script type="text/javascript">
    var orders_details = @json($depositRows);
</script>
@include('footer')
<script type="text/javascript" src="{{ URL::to('/') }}/js/modal.js?ver=1.2.0"></script>
