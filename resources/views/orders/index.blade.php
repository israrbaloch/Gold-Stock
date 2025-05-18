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
                            <tr class="toogle-details display-row-{{ $content_counter }}" data-deposit-id="{{ $content_counter }}">
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
            <div class="px-3 py-3">
                <h2 class="order-history-title mb-3">Order History</h2>

                <div class="mb-3 position-relative">
                    <input type="text" class="form-control ps-5 order-history-search" placeholder="Search" />
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ps-3 text-muted"></i>
                </div>

                <button class="btn text-decoration-none order-history-filter">
                    <i class="bi bi-filter"></i> Filter
                </button>

                <div class="table-responsive order-history-responsive">
                    <table class="table order-history-table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deposits as $index => $deposit)
                                @php
                                    // dd($deposit);
                                @endphp
                                @foreach ($deposit['product'] as $key => $product)
                                    @php
                                        $productData = App\Helper\Helper::getProductData($product['product_id']);
                                        $deposits[$loop->parent->index]['product'][$key]['images'] = json_decode($productData->images) ?? [];
                                    @endphp
                                @endforeach
                                <tr data-bs-toggle="modal" data-bs-target="#orderDetailsModal" data-index="{{ $index }}">
                                    <td>PL{{ $deposit['id'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($deposit['created_at'])->format('M d, Y') }}</td>
                                    <td>{{ $deposit['product'][0]['name'] ?? '-' }}</td>
                                    <td>{{ number_format($deposit['total'], 2) }}</td>
                                    <td><span class="badge {{$deposit['shipping_status']  === 'Pending' ? 'bg-warning' : 'bg-success'}}">{{ $deposit['shipping_status']  }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    {{-- Mobile Version Details --}}
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3 rounded-4">
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <script>
        const STORAGE_PATH = "{{ asset('storage') }}";
        const BASE_URL = "{{ url('/') }}"; // example: http://localhost:3000

    </script>

    <script>
        window.depositData = @json($deposits);
        console.log(window.depositData);

        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('orderDetailsModal');

            modal.addEventListener('show.bs.modal', function (event) {
                const trigger = event.relatedTarget;
                const index = trigger.getAttribute('data-index');
                const deposit = window.depositData[index];

                const product = Array.isArray(deposit.products) && deposit.products[0] ? deposit.products[0] : {};
                const payment = Array.isArray(deposit.payments) && deposit.payments[0] ? deposit.payments[0] : {};

                const date = new Date(deposit.created_at);
                const options = {
                    timeZone: 'America/Toronto',
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false,
                };

                const formatter = new Intl.DateTimeFormat('en-US', options);
                const parts = formatter.formatToParts(date);

                const get = (type) => parts.find(p => p.type === type)?.value;

                const formatted = `${get('month')} ${get('day')}, ${get('year')} - ${get('hour')}:${get('minute')}`;

                const paymentIcons = {
                    1: ['/img/payments/store.png'],                          // Cash drop off
                    2: ['/img/payments/ibtf.png'],                 // Bank transfer
                    3: ['/img/payments/visa.png', '/img/payments/master.png', '/img/payments/amx.png', '/img/payments/discover.png'], // Credit card
                    4: ['/img/payments/paypal.png'],                        // PayPal
                    5: ['/img/payments/wallet.png'],                        // From Balance Account
                    6: ['/img/payments/etrans.png'],                     // E-Transfer
                    7: ['/img/payments/debit.png']                          // Debit in store
                };

                const getPaymentIconsHtml = (id) => {
                    const icons = paymentIcons[id] || [];
                    return icons.map(src => `<img src="${src}" width="32" class="me-2">`).join('');
                };

                modal.querySelector('.modal-body').innerHTML = `
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-0 fw-bold">#PL${deposit.id}</h5>
                            <div class="text-muted small">BUY</div>
                            <div class="text-secondary small">${formatted}</div>
                        </div>
                        <span class="badge ${deposit.shipping_status === 'Pending' ? 'bg-warning' : 'bg-success'}">
                            ${deposit.shipping_status}
                        </span>
                    </div>

                    ${Array.isArray(deposit.product) ? deposit.product.map(product => `
                        <div class="d-flex align-items-center mb-3">
                            <img src="${product.images?.[0] ? BASE_URL + '/storage/' + product.images[0] : BASE_URL + '/gold-coin.png'}" class="me-3" width="40">
                            <div>
                                <div class="fw-semibold">${product.name ?? 'N/A'}</div>
                                <div class="text-muted small">Qty: ${product.quantity ?? 1} • $${product.price ?? 0}</div>
                            </div>
                            <div class="ms-auto fw-bold">$${((product.price || 0) * (product.quantity || 1)).toFixed(2)}</div>
                        </div>
                    `).join('') : ''}

                    <ul class="list-unstyled small mb-3">
                        <li class="d-flex justify-content-between"><span>Subtotal</span><span>$${deposit.subtotal ?? 0}</span></li>
                        <li class="d-flex justify-content-between text-success"><span>Discount</span><span>–$${deposit.promo_code_discount ?? 0}</span></li>
                        <li class="d-flex justify-content-between"><span>Shipping</span><span>$${deposit.shipping_option.price ?? 0}</span></li>
                        <li class="d-flex justify-content-between"><span>Tax</span><span>$${deposit.paid_fee ?? 0}</span></li>
                    </ul>

                    <div class="d-flex justify-content-between fw-bold border-top pt-2 mb-3">
                        <span>Total Paid</span>
                        <span>$${deposit.total ?? 0}</span>
                    </div>

                    <div class="mb-2 fw-medium">Payment</div>
                    <div class="border rounded p-2 mb-2">
                        <div class="d-flex justify-content-between">
                            <div>
                            ${getPaymentIconsHtml(payment.payment_method_id)}
                            ${payment.method ?? 'Payment'}
                        </div>
                                <span class="badge ${deposit.payment_status === 'Pending' ? 'bg-warning' : 'bg-success'}">
                            ${deposit.payment_status}
                        </span>
                        </div>
                        <div class="small text-muted">${payment.method ?? ''} – $${deposit.total ?? 0}</div>
                        <div class="text-muted small">Paid on ${deposit.created_at ?? ''}</div>
                    </div>
                `;

            });
        });
    </script>

    {{-- Desktop Version Details --}}

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