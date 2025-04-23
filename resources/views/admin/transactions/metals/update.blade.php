@extends('voyager::master')

@section('content')
    @include('header.utils')

    <div class="container">
        <h1>Order {{ $metalTransaction->orderid }}</h1>

        <form id="form" onsubmit="onSubmit()">
            @csrf
            <div class="form-group">
                <label for="email">User Mail</label>
                <input type="text" name="email" id="email" class="form-control" value="{{ $metalTransaction->email }}"
                    disabled>
            </div>
            <div class="form-group">
                <label for="metal">Metal</label>
                <input type="text" name="metal" id="metal" class="form-control"
                    value="{{ $metalTransaction->metal_id }}" disabled>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" name="type" id="type" class="form-control"
                    value="{{ $metalTransaction->mode }}" disabled>
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <input type="text" name="payment_method" id="payment_method" class="form-control"
                    value="{{ $metalTransaction->payment_method }}" disabled>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" name="amount" id="amount" class="form-control"
                    value="{{ addCommas($metalTransaction->oz, 4) }} oz" disabled>
            </div>
            <div class="form-group">
                <label for="metal">Metal</label>
                <input type="text" name="metal" id="metal" class="form-control"
                    value="{{ $metalTransaction->metal }}" disabled>
            </div>
            @if ($metalTransaction->metal_order_id)
                <div class="form-group">
                    <label for="price">Metal Order</label>
                    <a href="{{ route('admin.orders.metals.view', ['id' => $metalTransaction->metal_order_id]) }}"
                        target="_blank">
                        MT{{ $metalTransaction->metal_order_id }}
                    </a>
                </div>
            @endif

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    @foreach ($orderStatuses as $key => $orderStatus)
                        <option value="{{ $key }}" @if ($key == $metalTransaction->status_id) selected @endif>
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
            const id = '{{ $metalTransaction->id }}';
            const type = '{{ $metalTransaction->mode }}';

            $.ajax({
                url: `/admin/transactions/metals/${id}/${type}`,
                type: "PUT",
                data: {
                    status,
                },
                success: (res) => {
                    alert('Transaction updated successfully');
                    window.location.href = '/admin/transactions/metals';
                },
            });
        }
    </script>
@endsection
