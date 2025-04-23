@extends('voyager::master')

@section('content')
    @include('header.utils')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <div class="container">
        <h1>Product Orders</h1>

        <table class="table table-striped" id="orders-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>User</th>
                    <th>Shipping</th>
                    <th>Shipping Status</th>
                    <th>Currency</th>
                    <th>Status</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

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


@push('javascript')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.orders.products.data') }}',
                columns: [{
                        data: 'order_code',
                        name: 'order_code'
                    },
                    {
                        data: 'user_email',
                        name: 'user_email'
                    },
                    {
                        data: 'shipping_method',
                        name: 'shipping_method'
                    },
                    {
                        data: 'shipping_status',
                        name: 'shipping_status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'currency',
                        name: 'currency'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status',
                        orderable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ],
            });
        });
    </script>
@endpush
