@extends('voyager::master')

@section('content')
    @include('header.utils')

    <div class="container">
        <h1>Order {{ $cashTransaction->orderid }}</h1>

        <form id="form" onsubmit="onSubmit()">
            @csrf
            <div class="form-group">
                <label for="email">User Mail</label>
                <input type="text" name="email" id="email" class="form-control" value="{{ $cashTransaction->email }}"
                    disabled>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" name="type" id="type" class="form-control"
                    value="{{ $cashTransaction->mode }}" disabled>
            </div>
            <div class="form-group">
                <label for="currency">Currency</label>
                <input type="text" name="currency" id="currency" class="form-control"
                    value="{{ $cashTransaction->currency }}" disabled>
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <input type="text" name="payment_method" id="payment_method" class="form-control"
                    value="{{ $cashTransaction->payment_method }}" disabled>
            </div>
            <div class="form-group">
                <label for="value">Value</label>
                <input type="text" name="value" id="value" class="form-control"
                    value="${{ addCommas($cashTransaction->value, 2) }}" disabled>
            </div>
            @if ($cashTransaction->metal_order_id)
                <div class="form-group">
                    <label for="price">Metal Order</label>
                    <a href="{{ route('admin.orders.metals.view', ['id' => $cashTransaction->metal_order_id]) }}"
                        target="_blank">
                        MT{{ $cashTransaction->metal_order_id }}
                    </a>
                </div>
            @endif

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    @foreach ($orderStatuses as $key => $orderStatus)
                        <option value="{{ $key }}" @if ($key == $cashTransaction->status_id) selected @endif>
                            {{ $orderStatus }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="buttons-container">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script>
        function onSubmit() {
            const status = document.getElementById('status').value;
            const id = '{{ $cashTransaction->id }}';
            const type = '{{ $cashTransaction->mode }}';

            $.ajax({
                url: `/admin/transactions/cash/${id}/${type}`,
                type: "PUT",
                data: {
                    status,
                },
                success: (res) => {
                    alert('Transaction updated successfully');
                    window.location.href = '/admin/transactions/cash';
                },
            });
        }
    </script>
@endsection
