@extends('voyager::master')

@section('content')
    @include('header.utils')

    <div class="container">
        <h1>Order {{ $metalOrder->orderid }}</h1>

        <form id="form" onsubmit="onSubmit()">
            @csrf
            <div class="form-group">
                <label for="email">User Mail</label>
                <input type="text" name="email" id="email" class="form-control" value="{{ $metalOrder->email }}"
                    disabled>
            </div>
            <div class="form-group">
                <label for="metal">Metal</label>
                <input type="text" name="metal" id="metal" class="form-control"
                    value="{{ $metalOrder->metal->name }}" disabled>
            </div>
            <div class="form-group">
                <label for="operation">Operation</label>
                <input type="text" name="operation" id="operation" class="form-control"
                    value="{{ $metalOrder->order_type }}" disabled>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" name="amount" id="amount" class="form-control"
                    value="{{ addCommas($metalOrder->quantity_oz, 4) }} oz" disabled>
            </div>
            <div class="form-group">
                <label for="currency">Currency</label>
                <input type="text" name="currency" id="currency" class="form-control"
                    value="{{ $metalOrder->currency }}" disabled>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" id="price" class="form-control"
                    value="${{ addCommas($metalOrder->price_per_oz) }}" disabled>
            </div>
            <div class="form-group">
                <label for="total">Total</label>
                <input type="text" name="total" id="total" class="form-control"
                    value="${{ addCommas($metalOrder->quantity_oz * $metalOrder->price_per_oz) }}" disabled>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    @foreach ($orderStatuses as $key => $orderStatus)
                        <option value="{{ $key }}" @if ($key == $metalOrder->status_id) selected @endif>
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
            const orderId = '{{ $metalOrder->id }}';

            $.ajax({
                url: `/admin/orders/metals/${orderId}`,
                type: "PUT",
                data: {
                    status,
                },
                success: (res) => {
                    alert('Order updated successfully');
                    window.location.href = '/admin/orders/metals';
                },
            });
        }
    </script>
@endsection
