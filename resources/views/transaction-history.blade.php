@extends('header.index')

@php
    $content_counter_dp = 1;
    $row_counter_dp = 0;
    $display_counter_dp = 0;

    $content_counter_wd = 1;
    $row_counter_wd = 0;
    $display_counter_wd = 0;

    $mobile_content_counter_dp = 1;
    $mobile_row_counter_dp = 0;
    $mobile_display_counter_dp = 0;

    $mobile_content_counter_wd = 1;
    $mobile_row_counter_wd = 0;
    $mobile_display_counter_wd = 0;

    $total_deposits = count($depositRows);
    $total_withdrawals = count($withdrawalRows);

    $pages_dp = ceil($total_deposits / 5);

    $pages_wd = ceil($total_withdrawals / 5);

    $img = ['CAD', 'USD', 'EUR', 'Gold', 'Silver', 'Palladium', 'Platinum'];
@endphp

@php
    $deposit_details = $drs;
    $whitdraw_details = $wrs;
@endphp

@push('styles')
    <link href="{{ URL::to('/') }}/css/transaction-history.css?ver=1.2.0" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ URL::to('/') }}/js/transaction-history.js?ver=1.2.0"></script>
    <script type="text/javascript">
        var deposit_details = @json($deposit_details);
        var whitdraw_details = @json($whitdraw_details);
    </script>
    <script type="text/javascript" src="{{ URL::to('/') }}/js/modal.js?ver=1.2.0"></script>
@endpush

@section('content')
    <br><br>

    <div class="page-container container transactions-container">
        <div class="d-none d-md-block desktop-version">
            <div class="title-page-1 text-center">Transaction history</div>
            <div class="gray-space"></div>
            <div class="tabs-change">
                <div id="desktop-deposit" href="#" class="tab-change active">Deposit History</div>
                <div id="desktop-withdrawal" href="#" class="tab-change">Withdrawals History</div>
                {{-- <div href="#" class="tab-change color-dark-green active details-title d-none">Details</div> --}}
            </div>

            <table id="deposit-table" class="table d-table">
                <thead class="thead-dark">
                    <tr>
                        <th>Metal/Currency</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Date</th>
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
                            $i = 0;
                        @endphp
                        @foreach ($depositRows as $row)
                            @php
                                $date = date_create($row->date);
                                $row_counter_dp++;
                                $display_counter_dp++;
                                $style_dp = '';
                                $visibility = $i < 5 ? ' d-table-row' : ' d-none';
                                $status = 'Complete';
                                if ($row->status == 'PAYMENT PENDING') {
                                    $status = 'Pending';
                                }
                            @endphp
                            <tr class="dcash toogle-details toogle-dcash-details dp-display-row-{{ $content_counter_dp }}{{ $visibility }}"
                                data-id="{{ $i }}" {{ $style_dp }}>
                                <td class="title"><img class="thumby-big" alt=""
                                        src="/img/{{ $row->currencycode }}.png">
                                    {{ $row->currencycode }}</td>
                                @if (
                                    $row->currencycode == 'Gold' ||
                                        $row->currencycode == 'Silver' ||
                                        $row->currencycode == 'Platinum' ||
                                        $row->currencycode == 'Palladium')
                                    <td>{{ number_format($row->value, 2) }} /oz</td>
                                @else
                                    <td>$ {{ number_format($row->value, 2) }}</td>
                                @endif
                                <td>{{ $row->status }}</td>
                                <td>{{ date_format($date, 'g:i A\, Y-m-d') }}</td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                        <tr class="load-more-dp{{ count($depositRows) > 5 ? ' d-table-row' : ' d-none' }}">
                            <td colspan="6">
                                <div class="text-center">
                                    <a href="#" class="load-next dp">Load Next</a>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <table id="withdrawal-table" class="table d-none">
                <thead class="thead-dark">
                    <tr>
                        <th>Metal/Currency</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($withdrawalRows) < 1)
                        <tr>
                            <td colspan="6">
                                <div class="no-data text-gray-400">No data available</div>
                            </td>
                        </tr>
                    @else
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($withdrawalRows as $row)
                            @php
                                $date = date_create($row['date']);
                                $row_counter_wd++;
                                $display_counter_wd++;
                                $style_wd = '';
                                $visibility = $i < 5 ? ' d-table-row' : ' d-none';
                            @endphp
                            <tr class="wcash toogle-details toogle-wcash-details wd-display-row-{{ $content_counter_wd }}{{ $visibility }}"
                                data-id="{{ $i }}" {{ $style_wd }}>
                                <td class="title"><img class="thumby-big" alt=""
                                        src="/img/{{ $row['currency'] }}.png">
                                    {{ $row['currency'] }}</td>
                                @if (
                                    $row['currency'] == 'Gold' ||
                                        $row['currency'] == 'Silver' ||
                                        $row['currency'] == 'Platinum' ||
                                        $row['currency'] == 'Palladium')
                                    <td>{{ number_format($row['oz'], 2) }} /oz</td>
                                @else
                                    <td>$ {{ number_format($row['value'], 2) }}</td>
                                @endif
                                <td>{{ $row['status'] }}</td>
                                <td>{{ date_format($date, 'g:i A\, Y-m-d') }}</td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                        <tr class="load-more-wd{{ count($withdrawalRows) > 5 ? ' d-table-row' : ' d-none' }}">
                            <td colspan="6">
                                <div class="text-center">
                                    <a href="#" class="load-next wd">Load Next</a>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Mobile here --}}
        <div id="deposit-table-mobile" class="d-block d-md-none only-mobile" style="margin-top: 20px;">
            <div class="title-page-1 text-center">Transaction history</div>
            <div id="mobile-history-link" class="row">
                <div class="col-5 text-center mobile-deposit-trigger active">
                    <a class="color-dark-green text-bold" id="mobile-deposit" href="#">Deposit Hist.</a>
                </div>
                <div class="col-5 text-center mobile-withdrawal-trigger">
                    <a class="color-dark-green text-bold" id="mobile-withdrawal" href="#">Withdrawals Hist.</a>
                </div>
                <div class="col-2 text-center mobile-details-title d-none">
                    <a class="color-dark-green text-bold" href="#">Dt.</a>
                </div>
            </div>
            <div class="mobile-deposit-container">
                @if (count($depositRows) < 1)
                    <div class="no-data text-gray-400">No data available</div>
                @else
                    @php
                        $i = 0;
                        $visibilityDm = count($depositRows) > 5 ? ' d-block' : ' d-none';
                    @endphp
                    @foreach ($depositRows as $row)
                        @php
                            $date = date_create($row->date);

                            $visibility = $i > 4 ? ' d-none' : ' d-flex';
                            $mobile_row_counter_dp++;
                            $mobile_display_counter_dp++;
                            $mobile_style_dp = '';
                        @endphp
                        <div class="row g-0 dcash toogle-details mobile-toogle-dcash-details dp-display-row{{ $visibility }}"
                            data-id="{{ $i }}" {{ $mobile_style_dp }}>
                            <div class="col-9">

                                @if (
                                    $row->currencycode == 'Gold' ||
                                        $row->currencycode == 'Silver' ||
                                        $row->currencycode == 'Palladium' ||
                                        $row->currencycode == 'Platinum')
                                    <span style="font-weight: bold;">{{ $row->currencycode }}</span>
                                    <span>
                                        {{ number_format($row->value, 2) }} OZ
                                    </span>
                                @else
                                    <span style="font-weight: bold;">{{ $row->currencycode }}</span>
                                    <span>
                                        $ {{ number_format($row->value, 2) }}
                                    </span>
                                @endif
                                <div class="deposit-date">
                                    {{ date_format($date, 'g:i A\, Y-m-d') }}
                                </div>
                            </div>
                            <div class="col-3 deposit-status">{{ str_replace('PAYMENT ', '', $row->status) }}</div>
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    <div class="load-more-dm text-center{{ $visibilityDm }}">
                        <a href="#" class="load-next-mb dm">Load Next</a>
                    </div>
                @endif
            </div>
            <div class="mobile-withdrawal-container d-none">
                @if (count($withdrawalRows) < 1)
                    <div class="row g-0 toogle-details no-data text-gray-400 text-center">No data available</div>
                @else
                    @php
                        $i = 0;
                        $visibilityWm = count($withdrawalRows) > 5 ? ' d-block' : ' d-none';
                    @endphp
                    @foreach ($withdrawalRows as $row)
                        @php
                            $visibility = $i > 4 ? ' d-none' : ' d-flex';
                            $mobile_row_counter_dp++;
                            $mobile_display_counter_dp++;
                            $mobile_style_dp = '';
                            $date = date_create($row['date']);
                        @endphp
                        <div class="row g-0 wcash toogle-details mobile-toogle-wcash-details dp-display-row{{ $visibility }}"
                            data-id="{{ $i }}" {{ $mobile_style_dp }}>
                            <div class="col-9">
                                @if (
                                    $row['currency'] == 'Gold' ||
                                        $row['currency'] == 'Silver' ||
                                        $row['currency'] == 'Palladium' ||
                                        $row['currency'] == 'Platinum')
                                    <span style="font-weight: bold;">{{ $row['currency'] }}</span>
                                    <span>
                                        {{ number_format($row['oz'], 2) }} OZ
                                    </span>
                                @else
                                    <span style="font-weight: bold;">{{ $row['currency'] }}</span>
                                    <span>$ {{ number_format($row['value'], 2) }}</span>
                                @endif
                                <div class="deposit-date">
                                    <span>{{ date_format($date, 'g:i A\, Y-m-d') }}</span>
                                </div>
                            </div>
                            <div class="col-3 deposit-status">
                                <span>{{ str_replace('PAYMENT ', '', $row['status']) }}</span>
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    <div class="load-more-wm text-center{{ $visibilityWm }}">
                        <a href="#" class="load-next-mb wm">Load Next</a>
                    </div>
                @endif
            </div>
        </div>

        <div id="tab-mobile-details-deposit" class="tab-mobile-details d-none">
            <div class="simple-order-details order">
                <div class="row title">
                    <div class="col-6 text-cap text-bold color-dark-green">
                        DEPOSIT <span class="code-order"></span><span class="order-deposit"></span>
                    </div>
                    <div class="col-6 text-cap text-bold color-dark-green">
                        <span class="date-depo"></span>
                    </div>
                    <br><br>
                    <div class="col-6 text-bold color-yellow">
                        <span class="status-depo"></span>
                    </div>
                </div>
                <div class="content-title text-bold row">
                    <div class="text-cap col-5">
                        Product:
                    </div>
                    <div class="text-cap col-5 offset-2">
                        Qty
                    </div>
                </div>

                <div class="content row">
                    <div class="text-cap col-5 color-yellow">
                        <span class="product-depo"></span>
                    </div>
                    <div class="text-cap col-5 offset-2 color-yellow">
                        <span class="qty-depo"></span>
                    </div>
                </div>
                <div class="total row">
                    <div class="col-5 text-cap">
                        Total:
                    </div>
                    <div class="col-5 offset-2 color-yellow">
                        <span class="total-depo"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="text-cap col-5">
                        PAYMENT METHOD:
                    </div>
                    <div class="col-5 offset-2 color-yellow text-cap">
                        <span class="pay-method"></span>
                    </div>
                </div>
            </div>
        </div>
        <div id="tab-mobile-details-withdraw" class="tab-mobile-details d-none">
            <div class="simple-order-details order">
                <div class="row title">
                    <div class="col-6 text-cap text-bold color-dark-green">
                        WITHDRAWAL <span class="code-whitdrawal"></span>
                    </div>
                    <div class="col-6 text-cap text-bold color-dark-green">
                        <span class="date-whitdrawal"></span>
                    </div>
                    <br><br>
                    <div class="text-bold color-yellow">
                        <span class="status-whitdrawal"></span>
                    </div>
                </div>
                <div class="content-title text-bold row">
                    <div class="text-cap col-4">
                        Product: <span class="product-whitdrawal"></span>
                    </div>
                    <div class="text-cap col-3">
                        Qty
                    </div>
                    <div class="product-price text-cap col-5">
                        Price
                    </div>
                </div>

                <div class="content row" id="product-rows-mobile">

                </div>

                <div class="total row">
                    <div class="col-7 text-cap">
                        Total Price:
                    </div>
                    <div class="col-5 color-yellow">
                        $<span class="total-price-whitdrawal"></span>
                    </div>
                </div>
                <div class="subtotal row">
                    <div class="text-cap col-7">
                        Total Converted:
                    </div>
                    <div class="col-5 color-yellow">
                        <span class="total-metal-whitdrawal"></span>/oz
                    </div>
                </div>
                <div class="shiping row">
                    <div class="text-cap col-7 text-cap">
                        DELIVERY OPTION:
                    </div>
                    <div class="col-5 color-yellow text-cap">
                        <span class="shipping-whitdrawal"></span>
                    </div>
                </div>
                <div class="percent row payments-title payment-info">
                    <div class="text-cap col-12 text-bold">
                        PAYMENTS:
                    </div>
                </div>
                <div class="content-title text-bold row payment-info">
                    <div class="text-cap col-4">
                        date
                    </div>
                    <div class="text-cap col-3">
                        value
                    </div>
                    <div class="text-cap col-5">
                        method
                    </div>
                </div>
                <div class="content row payment-row" id="payment-rows-mobile">

                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div id="modal" class="modal-container transactions-modal">
        <div id="tab-desk-details" class="tab-conversion-details d-none">
            <button id="modal-close" type="button" class="btn-close" aria-label="x"></button>
            <div class="titles-container">
                <div id="modal-close" class="back-button modal-close">
                    Deposit History
                </div>
                <div class="modal-title">
                    Transaction Details
                </div>
            </div>
            <div class="simple-order-details row">
                <div class="row title">
                    <div class="col-4">
                        DEPOSIT
                        <span class="code-order"></span>
                        <span class="order-deposit"></span>
                    </div>
                    <div class="col-4">
                        <span class="date-depo"></span>
                    </div>
                    <div class="col-4">
                        <span class="status-depo"></span>
                    </div>
                </div>
                <div class="content-title row">
                    <div class="col-6">
                        Product:
                    </div>
                    <div class="col-6">
                        <span class="product-depo"></span>
                    </div>
                </div>
                <div class="content row">
                    <div class="col-6">
                        Qty
                    </div>
                    <div class="col-6">
                        <span class="qty-depo"></span>
                    </div>
                </div>
                <div class="total row">
                    <div class="col-7 ">
                        Total:
                    </div>
                    <div class="col-5">
                        <span class="total-depo"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-7">
                        Payment Method:
                    </div>
                    <div class="col-5">
                        <span class="pay-method"></span>
                    </div>
                </div>
            </div>
        </div>

        <div id="tab-conversion-details" class="tab-conversion-details d-none">
            <div class="titles-container">
                <div id="modal-close" class="back-button modal-close">
                    &lt; Withdrawal History
                </div>
                <div class="modal-title">
                    Transaction Details
                </div>
            </div>
            <div class="simple-order-details order">
                <div class="row title">
                    <div class="col-4  text-bold color-dark-green">
                        WITHDRAWAL
                        <span class="code-whitdrawal"></span>
                    </div>
                    <div class="col-4  text-bold color-dark-green">
                        <span class="date-whitdrawal"></span>
                    </div>
                    <div class="col-4 text-bold color-yellow">
                        <span class="status-whitdrawal"></span>
                    </div>

                </div>
                <div class="content row" id="product-rows">

                </div>
                <div class="total row">
                    <div class="col-6 ">
                        Total Price:
                    </div>
                    <div class="col-6">
                        <span class="total-price-whitdrawal"></span>
                    </div>
                </div>
                <div class="subtotal row">
                    <div class="col-6">
                        Total Converted:
                    </div>
                    <div class="col-6">
                        <span class="total-metal-whitdrawal"></span>/oz
                    </div>
                </div>
                <div class="shipping row">
                    <div class="col-6 ">
                        DELIVERY OPTION:
                    </div>
                    <div class="col-6 ">
                        <span class="shipping-whitdrawal"></span>
                    </div>
                </div>

                <div class="percent row payments-title payment-info">
                    <div class="col-12"></div>
                    PAYMENTS:
                </div>
            </div>

            <div class="content-title row payment-info">
                <div class="detal-pay col-4">
                    date
                </div>
                <div class="detal-pay col-3">
                    value
                </div>
                <div class="detal-pay col-5">
                    method
                </div>
            </div>
            <div class="content row payment-row" id="payment-rows">

            </div>
        </div>
    </div>
    </div>
@endsection
