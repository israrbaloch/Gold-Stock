@extends('voyager::master')
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            Pending Shippings
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
                                        <th class="tt"></th>
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
                                                    @if (count($order['items']) > 0)
                                                        @foreach ($order['items'] as $item)
                                                            <div class="pending-order-item row m-4 p-2">
                                                                <div class="col-12 col-md-3">
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
                                                                <div class="col-12 col-md-3">
                                                                    Products:
                                                                    @foreach ($item['product'] as $product)
                                                                        <p>{{ $product['name'] }} x
                                                                            {{ $product['quantity'] }}</p>
                                                                    @endforeach
                                                                </div>
                                                                <div class="col-12 col-md-3">
                                                                    @php
                                                                        $date = date_create($item['date']);
                                                                    @endphp
                                                                    Date:
                                                                    <p>{{ date_format($date, 'g:i A\, Y-m-d') }}</p>
                                                                    <br>
                                                                    Payment Status:
                                                                    <p>{{ $item['payment_status'] }}</p>
                                                                </div>
                                                                <div class="col-12 col-md-3 p-2">
                                                                    <div class="w-100">
                                                                        <label class="w-50 m-0 d-flex"
                                                                            for="shipping_status">Shipping Status:</label>
                                                                        <select class="w-50 m-0 d-flex"
                                                                            id="shipping_status-{{ $item['id'] }}">
                                                                            @foreach ($statuses as $status)
                                                                                <option
                                                                                    value="{{ $status->id }}"{{ $status->id == $item['shipping_status_id'] ? 'selected' : '' }}>
                                                                                    {{ $status->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <br>
                                                                    <br>
                                                                    <div class="w-100">
                                                                        <label class="w-50 m-0 d-flex"
                                                                            for="tracking_number">Tracking Number:</label>
                                                                        <input class="w-50 m-0 d-flex" type="text"
                                                                            id="tracking_number-{{ $item['id'] }}"
                                                                            value="{{ $trackingNumber }}" />
                                                                    </div>
                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                    <div class="w-100 center pb-2 pb-md-0">
                                                                        <button data-id="{{ $item['id'] }}"
                                                                            data-shipping-id="{{ $fedexId }}"
                                                                            class="save-status">Update</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </td>
                                            <td style="display: none;"></td>
                                            <td style="display: none;"></td>
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link href="{{ URL::to('/') }}/css/admin/custom.css?ver=1.0.0" rel="stylesheet">
    <style>
        .pb-2{
            padding-bottom: 0.5em !important;
        }
        @media (min-width: 768px){
            .pb-md-0{
                padding-bottom: 0 !important;
            }
        }
    </style>
@stop

@section('javascript')
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(function () {
            let wwidth = window.innerWidth;
            let responsive = wwidth < 767 ? true : false;
            $('#dataTable').DataTable({
                "order": [],
                "lengthChange": false,
                "paging": false,
                "bInfo" : false,
                "language": {!! json_encode(__('voyager::datatable'), true) !!},
                "columnDefs": [
                    {"targets": [ -1 ], "searchable":  false, "orderable": false},
                    {"width": "30%", "targets": 0},
                    {"width": "60%", "targets": 1},
                    {"width": "10%", "targets": 2}
                ],
                "responsive": responsive,
            });
            
            $('#dataTable tbody').on('click', '.btn-actions', function () {
                let id = $(this).attr('data-id');
                $('#tr-' + id).toggleClass('d-none').toggleClass('d-tablerow');
            });
            
            $('.save-status').on('click', function(e){
                e.preventDefault();
                var order_id = $(this).attr('data-id');
                var fedex_id = $(this).attr('data-shipping-id');
                var shipping_status = $('#shipping_status-' + order_id).val();
                var tracking_number = $('#tracking_number-' + order_id).val();
                $.ajax({
                    url: "/admin/update-shipping-status",
                    type: "post",
                    data: {
                        order_id: order_id,
                        fedex_id: fedex_id,
                        shipping_status: shipping_status,
                        tracking_number: tracking_number
                    },
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (resp) {
                        if (resp.success)
                        {
                            alert('Status updated successfully');
                        } else {
                            alert('The action could not be completed');
                        }
                    }
                });
            });

        });
    </script>
@stop
