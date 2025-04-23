@extends('voyager::master')

@section('content')
    @include('header.utils')

    <div class="container">
        <h1>Create Local Order</h1>

        {{-- <form id="form" onsubmit="onSubmit()"> --}}
        <form id="form" action="{{ route('admin.orders.products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">User Mail</label>
                <input type="text" name="email" id="email" class="form-control">
            </div>

            <div></div>

            <div class="form-group">
                <label for="shipping_option">Shipping</label>
                <select name="shipping_option" id="shipping_option" class="form-control">
                    @foreach ($shippingOptions as $shippingOption)
                        <option value="{{ $shippingOption->id }}">
                            {{ $shippingOption->name }}
                        </option>Create Order
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="shipping_status">Shipping Status</label>
                <select name="shipping_status" id="shipping_status" class="form-control">
                    @foreach ($orderStatuses as $key => $orderStatuse)
                        <option value="{{ $key }}">
                            {{ $orderStatuse }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="currency">Currency</label>
                <select name="currency" id="currency" class="form-control">
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->code }}">
                            {{ $currency->code }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    @foreach ($orderStatuses as $key => $orderStatus)
                        <option value="{{ $key }}">
                            {{ $orderStatus }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="product-container">
                <div class="form-group">
                    <label for="product_id">Products</label>
                    <div class="product-details">
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
                            <tfoot>
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
                            </tfoot>
                        </table>
                    </div>
                    <button type="button" id="add-product" class="btn btn-primary">
                        Add Product
                    </button>
                </div>
            </div>

            <div class="buttons-container">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ mix('css/admin.order.css') }}">
@endsection

@section('javascript')
    <script>
        const products = @json($products);
        const currencies = @json($_currencies);
        const metals = @json($_metals);
        const shippingOptions = @json($shippingOptions);
    </script>
    <script src="{{ mix('js/admin/order.js') }}"></script>
@endsection
