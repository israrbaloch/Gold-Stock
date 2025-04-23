@extends('admin.layout')

@section('css')
    <link rel="stylesheet" href="{{ mix('css/admin.order.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/admin-custom.css') }}?v=1">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
@endsection

@php
    $shippingStatus = array_key_exists($productOrder->shipping_status_id, $shippingStatuses) ? $shippingStatuses[$productOrder->shipping_status_id] : 'Unknown Status';

    if (in_array($productOrder->status_id, [4, 5, 15, 17])) {
        $status_badge = 'success';
    } elseif (in_array($productOrder->status_id, [7, 9, 10, 18])) {
        $status_badge = 'danger';
    } elseif (in_array($productOrder->status_id, [3, 11, 14])) {
        $status_badge = 'info';
    } elseif (in_array($productOrder->status_id, [2])) {
        $status_badge = 'primary';
    } else {
        $status_badge = 'warning';
    }

    if ($productOrder->shipping_status_id == 3) {
        $shiiping_badge = 'warning';
    } elseif ($productOrder->shipping_status_id == 4) {
        $shiiping_badge = 'success';
    } elseif ($productOrder->shipping_status_id == 5) {
        $shiiping_badge = 'info';
    } elseif ($productOrder->shipping_status_id == 6) {
        $shiiping_badge = 'success';
    } else {
        $shiiping_badge = 'danger';
    }
@endphp

@section('body')
    @include('header.utils')


    <div class="container-fluid">
        <h4 class="heading">Order {{ $productOrder->orderid }}</h4>

        {{-- muted text --}}
        <p class="text-muted">
            Order Created: {{ $productOrder->created_at->format('d M Y h:i a') }}
        </p>

        <div class="order-details">
            <div class="col-lg-12 row col-md-12">
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="header">
                            <h5>Customer Details</h5>
                            <a href="{{ route('admin.orders.products.edit-order-customer-details', $productOrder->id) }}"
                                class="edit-button">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                        <div class="card-body-details">
                            <table class="table">
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $productOrder->first_name }} {{ $productOrder->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td><a href="mailto:{{ $productOrder->email }}">{{ $productOrder->email }}</a></td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $productOrder->phone }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="header">
                            <h5>Shipping Address</h5>
                            <a href="{{ route('admin.orders.products.edit-shipping-address', $productOrder->id) }}"
                                class="edit-button">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                        <div class="card-body-details">
                            <table class="table">
                                <tr>
                                    <th>Address 1:</th>
                                    <td>{{ $productOrder->shipping_address_1 }}</td>
                                </tr>
                                <tr>
                                    <th>Address 2:</th>
                                    <td>{{ $productOrder->shipping_address_2 }}</td>
                                </tr>
                                <tr>
                                    <th>City:</th>
                                    <td>{{ $productOrder->shipping_city }}</td>
                                </tr>
                                <tr>
                                    <th>Country:</th>
                                    <td>{{ $productOrder->shipping_country }}</td>
                                </tr>
                                <tr>
                                    <th>Postal Code:</th>
                                    <td>{{ $productOrder->shipping_postal_code }}</td>
                                </tr>
                                <tr>
                                    <th>Province:</th>
                                    <td>{{ $productOrder->shipping_province }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="header">
                            <h5>Billing Address</h5>
                            <a href="{{ route('admin.orders.products.edit-billing-address', $productOrder->id) }}"
                                class="edit-button">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                        <div class="card-body-details">
                            <table class="table">
                                <tr>
                                    <th>Address 1:</th>
                                    <td>{{ $productOrder->billing_address_1 }}</td>
                                </tr>
                                <tr>
                                    <th>Address 2:</th>
                                    <td>{{ $productOrder->billing_address_2 }}</td>
                                </tr>
                                <tr>
                                    <th>City:</th>
                                    <td>{{ $productOrder->billing_city }}</td>
                                </tr>
                                <tr>
                                    <th>Country:</th>
                                    <td>{{ $productOrder->billing_country }}</td>
                                </tr>
                                <tr>
                                    <th>Postal Code:</th>
                                    <td>{{ $productOrder->billing_postal_code }}</td>
                                </tr>
                                <tr>
                                    <th>Province:</th>
                                    <td>{{ $productOrder->billing_province }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-12 row">
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="header">
                            <h5>Product info</h5>
                            <a href="{{ route('admin.orders.products.edit-product-info', $productOrder->id) }}"
                                class="edit-button">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                        <div class="card-body-details">
                            <table class="table">
                                <tr>
                                    <th>Moneris Order ID:</th>
                                    <td>{{ $productOrder->moneris_order_id }}</td>
                                </tr>
                                <tr>
                                    <th>Moneris Ticket:</th>
                                    <td>{{ $productOrder->moneris_ticket }}</td>
                                </tr>
                                <tr>
                                    <th>Currency:</th>
                                    <td>{{ $productOrder->currency }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span
                                            class="badgeMain badge-{{ $status_badge }}">{{ $orderStatuses[$productOrder->status_id] }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Shipping:</th>
                                    <td>
                                        {{-- @php
                                            dd($shippingOptions[$productOrder->shipping_option_id]);
                                        @endphp --}}
                                        {{-- {{ optional(isset($shippingOptions[$productOrder->shipping_option_id]) ? $shippingOptions[$productOrder->shipping_option_id] : null)->name ?: 'N/A' }} --}}
                                        {{ $productOrder->shipping_option }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Shipping Status:</th>

                                    <td>
                                        <span class="badgeMain badge-{{ $shiiping_badge }}">{{ $shippingStatus }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="header">
                            <h5>Payment info</h5>
                            <a href="{{ route('admin.orders.products.edit-payment-info', $productOrder->id) }}"
                                class="edit-button">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                        <div class="card-body-details">
                            <table class="table">
                                <tr>
                                    <th>Total:</th>
                                    <td>${{ number_format($productOrder->total + $shippingFee, 2) }}</td>
                                </tr>
                                @if ($productOrder->payment_method == 2)
                                    <tr>
                                        <th>10% Deposit:</th>
                                        <td>${{ number_format($productOrder->payed - $productOrder->fee, 2) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>3.75% Fee:</th>
                                    <td>${{ number_format($productOrder->fee, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping Service:</th>
                                    {{-- <td>
                                        <span class="shipping_service_fee"></span>
                                    </td> --}}
                                    <td>
                                        ${{ number_format($shippingFee, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payed:</th>
                                    <td>${{ number_format($productOrder->payed, 2) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2"><span class="border-line"></span></th>
                                </tr>
                                <tr>
                                    <th>Outstanding:</th>
                                    <td>${{ number_format($productOrder->total - $productOrder->payed, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="header">
                            <h5>Order info</h5>
                            <a href="{{ route('admin.orders.products.edit-order-info', $productOrder->id) }}"
                                class="edit-button">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                        <div class="card-body-details">
                            <table class="table">
                                <tr>
                                    <th>Payment Status:</th>
                                    <td>
                                        <span
                                            class="badgeMain badge-{{ $status_badge }}">{{ $orderStatuses[$productOrder->status_id] }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Shipping Status:</th>
                                    <td>
                                        <span class="badgeMain badge-{{ $shiiping_badge }}">{{ $shippingStatus }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-lg-12 row px-0">
                <div class="col-lg-12 col-md-12" style="padding: 0">
                    <div class="card">
                        <div class="header">
                            <h5>Products</h5>
                            <a href="{{ route('admin.orders.products.edit-order-products', $productOrder->id) }}"
                                class="edit-button">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                        <div class="card-body-details">
                            <table class="table product-table" id="products-table1">
                                <tr>
                                    <th>Name</th>
                                    <th>Unit Price</th>
                                    <th>Weight</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                </tr>
                                <tbody>
                                    @foreach ($currentProducts as $product)
                                        <tr>
                                            <td>
                                                {{ $product->name }}
                                            </td>

                                            <td>
                                                ${{ $product->price }}
                                            </td>

                                            <td>
                                                {{ $product->weight }}
                                            </td>

                                            <td>
                                                {{ $product->quantity }}
                                            </td>

                                            <td>
                                                ${{ $product->price * $product->quantity }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row" style="display: flex; justify-content: space-between;">
                                {{-- subtotal --}}
                                <div class="col-lg-3 col-md-6" style="margin-left: auto;">
                                    <table class="table total-table">
                                        <tr>
                                            <th>Subtotal:</th>
                                            <td>$<span id="subtotal">{{ number_format($productOrder->total, 2) }}</span>
                                            </td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tax:</th>
                                            {{-- <td>${{ $productOrder->tax }}</td> --}}
                                            <td>N/A</td>
                                        </tr>
                                        <tr>
                                            <th>Shipping Service:</th>
                                            <td>
                                                {{-- <input type="hidden" name="shipping_option" id="shipping_option" value="{{ $productOrder->shipping_option_id }}">
                                                <span class="shipping_service_fee"></span> --}}
                                                ${{ number_format($shippingFee, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">
                                                <span class="border-line"></span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                <span class="grand-total">
                                                    Grand Total:
                                                </span>
                                            </th>
                                            <td>
                                                <div class="grand-total">
                                                    {{-- $<span id="grandTotal">{{ $productOrder->total }}</span> --}}
                                                    ${{ number_format($productOrder->total + $shippingFee, 2) }}
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection



@section('javascript')
    {{-- <script>
        const productOrder = @json($productOrder);
        const products = @json($products);
        const currencies = @json($_currencies);
        const metals = @json($_metals);
        const currentProducts = @json($currentProducts);
        const shippingOptions = @json($shippingOptions);
        const oldMetals = @json($_oldMetals);
    </script>

    <script src="{{ mix('js/admin/order.js') }}"></script>

    <script>
        $("#form").submit(function(e) {
            e.preventDefault();

            if (!confirm('Are you sure you want to update this order?')) {
                return;
            }

            const orderId = '{{ $productOrder->id }}';
            const shippingOption = document.getElementById('shipping_option').value;
            const shippingStatus = document.getElementById('shipping_status').value;
            const currency = document.getElementById('currency').value;
            const status = document.getElementById('status').value;

            const first_name = document.getElementById('first_name').value;
            const last_name = document.getElementById('last_name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;

            const shipping_address_1 = document.getElementById('shipping_address_1').value;
            const shipping_address_2 = document.getElementById('shipping_address_2').value;
            const shipping_city = document.getElementById('shipping_city').value;
            const shipping_country = document.getElementById('shipping_country').value;
            const shipping_province = document.getElementById('shipping_province').value;
            const shipping_postal_code = document.getElementById('shipping_postal_code').value;

            const billing_address_1 = document.getElementById('billing_address_1').value;
            const billing_address_2 = document.getElementById('billing_address_2').value;
            const billing_city = document.getElementById('billing_city').value;
            const billing_country = document.getElementById('billing_country').value;
            const billing_province = document.getElementById('billing_province').value;
            const billing_postal_code = document.getElementById('billing_postal_code').value;

            const table = document.getElementById('products-table');
            const products = [];
            table.querySelectorAll('tr').forEach((tr, index) => {
                const productId = tr.querySelector('[data-type="product"]').value;
                const quantity = tr.querySelector('[data-type="quantity"]').value;
                const price = tr.querySelector('[data-type="price"]').value;
                products.push({
                    id: productId,
                    quantity: quantity,
                    price: price,
                });
            });

            $.ajax({
                url: `/admin/orders/products/${orderId}`,
                type: "PUT",
                data: {
                    _token: '{{ csrf_token() }}',
                    first_name,
                    last_name,
                    email,
                    phone,
                    shipping_address_1,
                    shipping_address_2,
                    shipping_city,
                    shipping_country,
                    shipping_province,
                    shipping_postal_code,
                    billing_address_1,
                    billing_address_2,
                    billing_city,
                    billing_country,
                    billing_province,
                    billing_postal_code,
                    shippingOption,
                    shippingStatus,
                    currency,
                    status,
                    products,
                },
                success: (res) => {
                    alert('Order updated successfully');
                    // window.location.href = '/admin/orders/products';
                },
            });
        })
    </script> --}}
@endsection
