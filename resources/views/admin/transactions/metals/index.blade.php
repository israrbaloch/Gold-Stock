@extends('voyager::master')

@section('content')
    @include('header.utils')

    <div class="container">
        <h1>Metal Transactions</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Transaction</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Metal</th>
                    <th>Weight</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Metal Order</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($metalTransactions as $metalTransaction)
                    <tr>
                        <td>
                            <a href="{{ route('admin.transactions.metals.view', [
                                'id' => $metalTransaction->id,
                                'type' => $metalTransaction->mode,
                            ]) }}">
                                {{ $metalTransaction->id }}
                            </a>
                        </td>
                        <td>
                            {{ $metalTransaction->email }}
                        </td>
                        <td>
                            {{ $metalTransaction->mode }}
                        </td>
                        <td>
                            {{ $metalTransaction->metal_name }}
                        </td>
                        <td>
                            {{ addCommas($metalTransaction->oz, 4) }} oz
                        </td>
                        <td>
                            {{ $metalTransaction->payment_method }}
                        </td>
                        <td>
                            {{ $metalTransaction->status }}
                        </td>
                        <td>
                            @if ($metalTransaction->metal_order_id)
                                <a href="{{ route('admin.orders.metals.view', ['id' => $metalTransaction->metal_order_id]) }}"
                                    target="_blank">
                                    MT{{ $metalTransaction->metal_order_id }}
                                </a>
                            @endif
                        </td>
                        <td>
                            {{ $metalTransaction->created_at }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
