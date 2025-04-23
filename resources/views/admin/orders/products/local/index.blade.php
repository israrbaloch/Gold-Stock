@extends('voyager::master')

@section('content')
    @include('header.utils')

    <div class="container">
        <h1>Local Product Orders</h1>

        <div class="voyager-buttons">
            <a href="{{ route('admin.orders.products.local.create.view') }}" class="btn btn-success">Create</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>User</th>
                    <th>Shipping</th>
                    <th>Shipping Status</th>
                    <th>Currency</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productOrders as $productOrder)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.products.view', $productOrder->id) }}">
                                {{ $productOrder->orderid }}
                            </a>
                        </td>
                        <td>
                            {{ $productOrder->email }}
                        </td>
                        <td>
                            {{ $productOrder->shipping_option }}
                        </td>
                        <td>
                            {{ $productOrder->shipping_status }}
                        </td>
                        <td>
                            {{ $productOrder->currency }}
                        </td>
                        <td>
                            {{ $productOrder->status }}
                        </td>
                        <td>
                            {{ $productOrder->created_at }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
