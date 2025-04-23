@extends('admin.layout')

@section('css')
    <link rel="stylesheet" href="{{ mix('css/admin.order.css') }}">
@endsection

@section('body')
    @include('header.utils')


    <div class="container">
        <h1>Order {{ $productOrder->orderid }}</h1>

        <form id="form">
            @csrf
            <div class="form-data-group">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control"
                        value="{{ $productOrder->first_name }}">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control"
                        value="{{ $productOrder->last_name }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control"
                        value="{{ $productOrder->email }}">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control"
                        value="{{ $productOrder->phone }}">
                </div>
            </div>
            <hr>
            <div class="form-data-group">
                <div class="form-group">
                    <label for="shipping_address_1">Shipping Address 1</label>
                    <input type="text" name="shipping_address_1" id="shipping_address_1" class="form-control"
                        value="{{ $productOrder->shipping_address_1 }}">
                </div>
                <div class="form-group">
                    <label for="shipping_address_2">Shipping Address 2</label>
                    <input type="text" name="shipping_address_2" id="shipping_address_2" class="form-control"
                        value="{{ $productOrder->shipping_address_2 }}">
                </div>
                <div class="form-group">
                    <label for="shipping_city">Shipping City</label>
                    <input type="text" name="shipping_city" id="shipping_city" class="form-control"
                        value="{{ $productOrder->shipping_city }}">
                </div>
                <div class="form-group">
                    <label for="shipping_country">Shipping Country</label>
                    <input type="text" name="shipping_country" id="shipping_country" class="form-control"
                        value="{{ $productOrder->shipping_country }}">
                </div>
                <div class="form-group">
                    <label for="shipping_province">Shipping Province</label>
                    <input type="text" name="shipping_province" id="shipping_province" class="form-control"
                        value="{{ $productOrder->shipping_province }}">
                </div>
                <div class="form-group">
                    <label for="shipping_postal_code">Shipping Postal Code</label>
                    <input type="text" name="shipping_postal_code" id="shipping_postal_code" class="form-control"
                        value="{{ $productOrder->shipping_postal_code }}">
                </div>
            </div>
            <hr>
            <div class="form-data-group">
                <div class="form-group">
                    <label for="billing_address_1">Billing Address 1</label>
                    <input type="text" name="billing_address_1" id="billing_address_1" class="form-control"
                        value="{{ $productOrder->billing_address_1 }}">
                </div>
                <div class="form-group">
                    <label for="billing_address_2">Billing Address 2</label>
                    <input type="text" name="billing_address_2" id="billing_address_2" class="form-control"
                        value="{{ $productOrder->billing_address_2 }}">
                </div>
                <div class="form-group">
                    <label for="billing_city">Billing City</label>
                    <input type="text" name="billing_city" id="billing_city" class="form-control"
                        value="{{ $productOrder->billing_city }}">
                </div>
                <div class="form-group">
                    <label for="billing_country">Billing Country</label>
                    <input type="text" name="billing_country" id="billing_country" class="form-control"
                        value="{{ $productOrder->billing_country }}">
                </div>
                <div class="form-group">
                    <label for="billing_province">Billing Province</label>
                    <input type="text" name="billing_province" id="billing_province" class="form-control"
                        value="{{ $productOrder->billing_province }}">
                </div>
                <div class="form-group">
                    <label for="billing_postal_code">Billing Postal Code</label>
                    <input type="text" name="billing_postal_code" id="billing_postal_code" class="form-control"
                        value="{{ $productOrder->billing_postal_code }}">
                </div>
            </div>
            <hr>
            <div class="form-data-group">
                <div class="form-group">
                    <label for="moneris_order_id">Moneris Order ID</label>
                    <input type="text" name="moneris_order_id" id="moneris_order_id" class="form-control"
                        value="{{ $productOrder->moneris_order_id }}" disabled>
                </div>
                <div class="form-group">
                    <label for="moneris_ticket">Moneris Ticket</label>
                    <input type="text" name="moneris_ticket" id="moneris_ticket" class="form-control"
                        value="{{ $productOrder->moneris_ticket }}" disabled>
                </div>
            </div>
            <hr>
            <div class="form-data-group">
                <div class="form-group">
                    <label for="currency">Currency</label>
                    <select name="currency" id="currency" class="form-control" disabled>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->code }}" @if ($currency->code == $productOrder->currency) selected @endif>
                                {{ $currency->code }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        @foreach ($orderStatuses as $key => $orderStatus)
                            <option value="{{ $key }}" @if ($key == $productOrder->status_id) selected @endif>
                                {{ $orderStatus }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr>
            <div class="form-data-group">
                <div class="form-group">
                    <label for="shipping_option">Shipping</label>
                    <select name="shipping_option" id="shipping_option" class="form-control">
                        @foreach ($shippingOptions as $shippingOption)
                            <option value="{{ $shippingOption->id }}" @if ($shippingOption->id == $productOrder->shipping_option_id) selected @endif>
                                {{ $shippingOption->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="shipping_status">Shipping Status</label>
                    <select name="shipping_status" id="shipping_status" class="form-control">
                        <option value="">Select Shipping Status</option>
                        @foreach ($shippingStatuses as $key => $shippingStatus)
                            <option value="{{ $key }}" @if ($key == $productOrder->shipping_status_id) selected @endif>
                                {{ $shippingStatus }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr>
            <div class="form-data-group">
                <div class="form-group">
                    <label for="total">Total</label>
                    <input type="text" name="total" id="total" class="form-control"
                        value="${{ $productOrder->total }}" disabled>
                </div>
                <div class="form-group">
                    <label for="deposit">10% Deposit</label>
                    <input type="text" name="deposit" id="deposit" class="form-control"
                        value="${{ $productOrder->payed - $productOrder->fee }}" disabled>
                </div>
                <div class="form-group">
                    <label for="fee">3.75% Fee</label>
                    <input type="text" name="fee" id="fee" class="form-control"
                        value="${{ $productOrder->fee }}" disabled>
                </div>
                <div class="form-group">
                    <label for="shipping_service">Shipping Service</label>
                    <input type="text" name="shipping_service" id="shipping_service" class="form-control"
                        value="N/A" disabled>
                </div>
            </div>
            <hr>
            <div class="form-data-group">
                <div class="form-group">
                    <label for="payed">Payed</label>
                    <input type="text" name="payed" id="payed" class="form-control"
                        value="${{ $productOrder->payed }}" disabled>
                </div>
                <div class="form-group">
                    <label for="outstanding">Outstanding</label>
                    <input type="text" name="outstanding" id="outstanding" class="form-control"
                        value="${{ $productOrder->total - $productOrder->payed }}" disabled>
                </div>
            </div>
            <hr>

            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Weight</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Sub-Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="products-table">
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td>Shipping</td>
                        <td id="shipping">$0.00</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td>10% Deposit</td>
                        <td id="due-now">$0.00</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td>3.75% Fee</td>
                        <td id="fee">$0.00</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td>Total</td>
                        <td id="total">$0.00</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td>Outstanding Balance</td>
                        <td id="pending">$0.00</td>
                    </tr>
                </tfoot> --}}
            </table>


            <div class="buttons-container">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" id="add-product" class="btn btn-primary">
                    Add Product
                </button>
            </div>

            <hr>
        </form>
    </div>
@endsection



@section('javascript')
    <script>
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
    </script>
@endsection
