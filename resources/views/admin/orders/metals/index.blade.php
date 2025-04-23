@extends('voyager::master')

@section('content')
    @include('header.utils')

    <div class="container">
        <h1>Metal Orders</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>User</th>
                    <th>Operation</th>
                    <th>Metal</th>
                    <th>Amount Oz</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Fee</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($metalOrders as $metalOrder)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.metals.view', $metalOrder->id) }}">
                                {{ $metalOrder->orderid }}
                            </a>
                        </td>

                        <td>
                            {{ $metalOrder->email }}
                        </td>
                        <td>
                            {{ $metalOrder->order_type }}
                        </td>
                        <td>
                            {{ $metalOrder->metal_id }}
                        </td>
                        <td>
                            {{ addCommas($metalOrder->quantity_oz, 4) }} oz
                        </td>
                        <td>
                            ${{ addCommas($metalOrder->price_per_oz) }}
                        </td>
                        <td>
                            ${{ addCommas($metalOrder->quantity_oz * $metalOrder->price_per_oz) }}
                        </td>
                        <td>
                            @if ($metalOrder->fee != null)
                                ${{ addCommas($metalOrder->fee) }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            {{ $metalOrder->status }}
                        </td>
                        <td>
                            {{ $metalOrder->created_at }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
