@extends('voyager::master')

@section('content')
    @include('header.utils')

    <div class="container">
        <h1>Cash Transactions</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Transaction</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Currency</th>
                    <th>Value</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Metal Order</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cashTransactions as $cashTransaction)
                    <tr>
                        <td>
                            <a
                                href="{{ route('admin.transactions.cash.view', [
                                    'id' => $cashTransaction->id,
                                    'type' => $cashTransaction->mode,
                                ]) }}">
                                {{ $cashTransaction->id }}
                            </a>
                        </td>
                        <td>
                            {{ $cashTransaction->email }}
                        </td>
                        <td>
                            {{ $cashTransaction->mode }}
                        </td>
                        <td>
                            {{ $cashTransaction->currency }}
                        </td>
                        <td>
                            ${{ addCommas($cashTransaction->value, 2) }}
                        </td>
                        <td>
                            {{ $cashTransaction->payment_method }}
                        </td>
                        <td>
                            {{ $cashTransaction->status }}
                        </td>
                        <td>
                            @if ($cashTransaction->metal_order_id)
                                <a href="{{ route('admin.orders.metals.view', ['id' => $cashTransaction->metal_order_id]) }}"
                                    target="_blank">
                                    MT{{ $cashTransaction->metal_order_id }}
                                </a>
                            @endif
                        </td>
                        <td>
                            {{ $cashTransaction->created_at }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
