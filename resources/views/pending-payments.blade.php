@extends('voyager::master')
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            Pending Payments
        </h1>
    </div>
@stop
@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="user_name">Account</th>
                                        <th class="order_id">Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                {{ $order['id'] }}
                                            </td>
                                            <td>
                                                {{ $order['name'] }}
                                            </td>
                                            <td>
                                                <button data-id="{{ $order['id'] }}" class="btn btn-actions">Show
                                                    Orders</button>
                                            </td>
                                        </tr>
                                        <tr id="tr-{{ $order['id'] }}" class="d-none">
                                            <td colspan="3" class="p-4 my-4">
                                                <div class="pending-orders">
                                                    @if (isset($order['items']))
                                                        @foreach ($order['items'] as $item)
                                                            <div class="pending-order-item row m-4 p-2">
                                                                <div class="col-md-4">
                                                                    <p>Reference #: {{ $item['orderid'] }}</p>
                                                                    <p>Total:
                                                                        ${{ number_format($item['priceproduct'], 2) }}
                                                                        {{ $item['currency'] }}</p>
                                                                    <p>Shipping Option :{{ $item['shipping_option'] }}</p>
                                                                    <br>
                                                                    <p>Paid: ${{ number_format($item['paid'], 2) }}
                                                                        {{ $item['currency'] }}</p>
                                                                    @php
                                                                        $fedexId = $item['fedex_details'] ? $item['fedex_details']->id : '';
                                                                        $fedexPrice = $item['fedex_details'] ? $item['fedex_details']->price : 0;
                                                                        $trackingNumber = $item['fedex_details'] ? $item['fedex_details']->tracking_number : '';
                                                                    @endphp
                                                                    <p>Pending:
                                                                        ${{ number_format($item['priceproduct'] - $fedexPrice, 2) }}
                                                                        {{ $item['currency'] }}</p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    Products:
                                                                    @foreach ($item['product'] as $product)
                                                                        <p>{{ $product->name }} x
                                                                            {{ $product->quantity }}</p>
                                                                    @endforeach
                                                                </div>
                                                                <div class="col-md-4">
                                                                    @php
                                                                        $date = date_create($item['date']);
                                                                    @endphp
                                                                    Date:
                                                                    <p>{{ date_format($date, 'g:i A\, Y-m-d') }}</p>
                                                                    <br>
                                                                    Payment Status:
                                                                    <p>{{ $item['payment_status'] }}</p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="{{ URL::to('/') }}/css/admin/custom.css?ver=1.0.0" rel="stylesheet">
@stop

@section('javascript')
    <script>
        $(function() {
            $('.btn-actions').on('click', function() {
                let id = $(this).attr('data-id');
                $('#tr-' + id).toggleClass('d-none').toggleClass('d-tablerow');
            });

        });
    </script>
@stop
