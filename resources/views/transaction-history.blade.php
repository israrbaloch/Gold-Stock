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
    <script type="text/javascript">
        window.transactionData = @json($depositRows);
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
                                <td class="title"><img class="thumby-big" alt="" src="/img/{{ $row->currencycode }}.png">
                                    {{ $row->currencycode }}</td>
                                @if (
                                        $row->currencycode == 'Gold' ||
                                        $row->currencycode == 'Silver' ||
                                        $row->currencycode == 'Platinum' ||
                                        $row->currencycode == 'Palladium'
                                    )
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
                                <td class="title"><img class="thumby-big" alt="" src="/img/{{ $row['currency'] }}.png">
                                    {{ $row['currency'] }}</td>
                                @if (
                                        $row['currency'] == 'Gold' ||
                                        $row['currency'] == 'Silver' ||
                                        $row['currency'] == 'Platinum' ||
                                        $row['currency'] == 'Palladium'
                                    )
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
            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" id="transactionTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="deposits-tab" data-bs-toggle="tab" data-bs-target="#deposits"
                        type="button" role="tab">
                        Deposits
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="withdrawals-tab" data-bs-toggle="tab" data-bs-target="#withdrawals"
                        type="button" role="tab">
                        Withdrawaals
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="transactionTabsContent">
                <!-- Deposits Tab -->
                <div class="tab-pane fade show active" id="deposits" role="tabpanel">
                    <!-- Filters -->
                    <div class="filter-bar">
                        <div class="d-flex justify-content-between mb-2">
                            <select class="form-select form-select-sm w-50 me-2">
                                <option>Last 30 Days</option>
                            </select>
                            <select class="form-select form-select-sm w-50">
                                <option>Status: All</option>
                            </select>
                        </div>
                        <div class="search-bar">
                            <input type="text" class="form-control form-control-sm" placeholder="Search by amount or ID" />
                        </div>
                    </div>
                    @if (count($depositRows) < 1)
                        <p class="text-muted text-center mt-5">No Deposits yet.</p>
                    @else
                        @php
                            $i = 0;
                            $visibilityDm = count($depositRows) > 5 ? ' d-block' : ' d-none';
                        @endphp
                        @foreach ($depositRows as $row)
                            @php
                                // dd($row->status);
                                $date = new DateTime($row->date, new DateTimeZone('UTC'));
                                $date->setTimezone(new DateTimeZone('America/Toronto'));
                                $formatted = $date->format('M d, Y • G:i A');

                                $status = 'Complete';
                                if ($row->status == 'PAYMENT PENDING') {
                                    $status = 'Pending';
                                }

                                $paymentIconsByName = [
                                    'Cash drop off in store' => ['/img/payments/store.png'],
                                    'Bank transfer' => ['/img/payments/ibtf.png'],
                                    'Credit card' => ['/img/payments/visa.png', '/img/payments/master.png', '/img/payments/amx.png', '/img/payments/discover.png'],
                                    'Pay/Pal' => ['/img/payments/paypal.png'],
                                    'From Balance Account' => ['/img/payments/wallet.png'],
                                    'E-Transfer' => ['/img/payments/etrans.png'],
                                    'Debit in store' => ['/img/payments/debit.png'],
                                ];
                            @endphp
                            <!-- Deposit Transactions -->
                            <div class="transaction-card" data-bs-toggle="modal" data-bs-target="#txnModal"
                                data-index="{{ $loop->index }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="fw-bold">{{$row->currencycode}} $ {{number_format($row->value, 2)}}</div>
                                        <div class="text-muted small">{{$formatted}}</div>
                                        <div class="d-flex align-items-center mt-1">
                                            @if(isset($paymentIconsByName[$row->payment]))
                                                @foreach($paymentIconsByName[$row->payment] as $icon)
                                                    <img src="{{ asset($icon) }}" alt="icon" style="height: 24px; margin-right: 5px;">
                                                @endforeach
                                            @endif
                                            <span class="small">{{$row->payment}}</span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-{{ $status === 'Pending' ? 'warning' : 'success' }}">
                                            {{ $status}}
                                        </span><br />

                                        <small class="id-copy">{{$row->id}}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="load-more-dm text-center{{ $visibilityDm }}">
                            <a href="#" class="load-next-mb dm">Load Next</a>
                        </div>
                    @endif
                </div>

                <!-- Withdrawals Tab -->
                <div class="tab-pane fade" id="withdrawals" role="tabpanel">
                    <!-- Filters -->
                    <div class="filter-bar">
                        <div class="d-flex justify-content-between mb-2">
                            <select class="form-select form-select-sm w-50 me-2">
                                <option>Last 30 Days</option>
                            </select>
                            <select class="form-select form-select-sm w-50">
                                <option>Status: All</option>
                            </select>
                        </div>
                        <div class="search-bar">
                            <input type="text" class="form-control form-control-sm" placeholder="Search by amount or ID" />
                        </div>
                    </div>
                    @if (count($withdrawalRows) < 1)
                        <p class="text-muted text-center mt-5">No Withdrawals yet.</p>
                    @else
                        @php
                            $i = 0;
                            $visibilityDm = count($withdrawalRows) > 5 ? ' d-block' : ' d-none';
                        @endphp
                        @foreach ($withdrawalRows as $row)
                            @php
                                // dd($row->status);
                                $date = new DateTime($row->date, new DateTimeZone('UTC'));
                                $date->setTimezone(new DateTimeZone('America/Toronto'));
                                $formatted = $date->format('M d, Y • G:i A');

                                $status = 'Complete';
                                if ($row->status == 'PAYMENT PENDING') {
                                    $status = 'Pending';
                                }

                                $paymentIconsByName = [
                                    'Cash drop off in store' => ['/img/payments/store.png'],
                                    'Bank transfer' => ['/img/payments/ibtf.png'],
                                    'Credit card' => ['/img/payments/visa.png', '/img/payments/master.png', '/img/payments/amx.png', '/img/payments/discover.png'],
                                    'Pay/Pal' => ['/img/payments/paypal.png'],
                                    'From Balance Account' => ['/img/payments/wallet.png'],
                                    'E-Transfer' => ['/img/payments/etrans.png'],
                                    'Debit in store' => ['/img/payments/debit.png'],
                                ];
                            @endphp
                            <!-- Deposit Transactions -->
                            <div class="transaction-card" data-bs-toggle="modal" data-bs-target="#txnModal"
                                data-index="{{ $loop->index }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="fw-bold">{{$row->currencycode}} $ {{number_format($row->value, 2)}}</div>
                                        <div class="text-muted small">{{$formatted}}</div>
                                        <div class="d-flex align-items-center mt-1">
                                            @if(isset($paymentIconsByName[$row->payment]))
                                                @foreach($paymentIconsByName[$row->payment] as $icon)
                                                    <img src="{{ asset($icon) }}" alt="icon" style="height: 24px; margin-right: 5px;">
                                                @endforeach
                                            @endif
                                            <span class="small">{{$row->payment}}</span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-{{ $status === 'Pending' ? 'warning' : 'success' }}">
                                            {{ $status}}
                                        </span><br />

                                        <small class="id-copy">{{$row->id}}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="load-more-dm text-center{{ $visibilityDm }}">
                            <a href="#" class="load-next-mb dm">Load Next</a>
                        </div>
                    @endif
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

    {{-- Transaction Details Modal --}}
    <!-- Dynamic modal for Transaction Details -->
    <div class="modal fade" id="txnModal" tabindex="-1" aria-labelledby="txnModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content txn-modal-content">

            </div>
        </div>
    </div>


    {{-- Transaction Details Script --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('txnModal');

            modal.addEventListener('show.bs.modal', function (event) {
                const trigger = event.relatedTarget;
                const index = trigger.getAttribute('data-index');  // assume your trigger button has data-index attribute
                const transaction = window.transactionData[index];

                if (!transaction) {
                    modal.querySelector('.modal-body').innerHTML = '<p>No transaction data found.</p>';
                    return;
                }

                // Format date/time (adjust timezone/format as needed)
                const date = new Date(transaction.date);

                const datePart = new Intl.DateTimeFormat('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                }).format(date); // e.g., "May 14, 2025"

                const timePart = new Intl.DateTimeFormat('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                }).format(date); // e.g., "15:39"

                const formattedDateWithBreak = `${datePart}<br />${timePart}`;

                // Example dynamic content, adjust fields as per your transaction structure
                modal.querySelector('.modal-content').innerHTML = `
                                                    <div class="modal-header txn-modal-header d-block text-center">
                                                        <h5 class="modal-title txn-modal-title w-100" id="txnModalLabel">
                                                        ${transaction.currencycode} $${Number(transaction.value).toFixed(2)}
                                                        </h5>
                                                        <div class="txn-status-badge bg-${transaction.status === 'PAYMENT PENDING' ? 'warning' : 'success'}">
                                                        ${transaction.status === 'PAYMENT PENDING' ? 'Pending' : 'Completed'}
                                                        </div>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="txn-details px-2">

                                                        <div class="txn-row">
                                                            <div class="txn-label">Date</div>
                                                            <div class="txn-value">${formattedDateWithBreak}</div>
                                                        </div>

                                                        <div class="txn-row">
                                                            <div class="txn-label">Transaction ID</div>
                                                            <div class="txn-value">${transaction.id}</div>
                                                        </div>

                                                        <div class="txn-row">
                                                            <div class="txn-label">Payment Method</div>
                                                            <div class="txn-value">
                                                            ${transaction.payment || 'N/A'}
                                                            </div>
                                                        </div>

                                                        <div class="txn-row">
                                                            <div class="txn-label">Deposit Type</div>
                                                            <div class="txn-value">${transaction.depositType || 'Manual'}</div>
                                                        </div>

                                                        <div class="txn-row">
                                                            <div class="txn-label">Reference</div>
                                                            <div class="txn-value">${transaction.reference || '-'}</div>
                                                        </div>

                                                        </div>
                                                    </div>

                                                    <div class="modal-footer txn-modal-footer justify-content-center">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                        Close
                                                        </button>
                                                    </div>
                                                    `;

            });
        });
    </script>

@endsection