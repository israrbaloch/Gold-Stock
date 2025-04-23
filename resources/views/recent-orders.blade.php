@extends('voyager::master')
@section('page_header')
    <div class="container-fluid row center">
        <h1 class="page-title">
            DAILY ACTIVITY
        </h1>
    </div>
@stop
@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div class="w-90 center period-info">
                                <br class="d-block d-md-none">
                                <h3>Showing activity from <br class="d-block d-md-none"><d>{{ $start }}</d> @if($now) <br class="d-block d-md-none">to  <br class="d-block d-md-none"><d>{{ $end }} @endif</d></h3>
                            </div>
                            <br>
                            <hr>
                            <form action="{{ route('admin.recent-orders') }}" method="get">
                                <div class="row w-90">
                                    <div class="col-12 col-md-12 center">
                                        <span>Or select date interval: </span>
                                    </div>
                                    <div class="col-12 col-md-5 center">
                                        <br class="d-block d-md-none">
                                        <input type="text" id="start" name="start" value="{{ $start }}" class="form-control dpicker dpicker1 w-100 f-none">
                                        <br class="d-block d-md-none">
                                    </div>
                                    <div class="col-12 col-md-5 center">
                                        <input type="text" id="end" name="end" value="{{ $end }}" class="form-control dpicker dpicker2 w-100 f-none">
                                        <br class="d-block d-md-none">
                                        <br class="d-block d-md-none">
                                    </div>
                                    <div class="col-12 col-md-1 center px-1">
                                        <button type="submit" class="btn btn-primary w-100">Apply</button>
                                    </div>
                                    <div class="col-12 col-md-1 center px-1">
                                        <button id="reset" type="submit" class="btn btn-primary w-100">Clear</button>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <hr>
                            <table id="dataTable" class="table table-hover table-recent w-98">
                                <thead>
                                    <tr>
                                        <th class="user_email">User</th>
                                        <th class="order_type">Type</th>
                                        <th class="order_date">Date</th>
                                        <th class="tt"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                {{ $order['name'] }}
                                            </td>
                                            <td>
                                                {{ $order['order_type'] }}
                                            </td>
                                            <td>
                                                {{ $order['date'] }}
                                            </td>
                                            <td>
                                                <div class="w-100 d-flex justify-content-between">
                                                    <div class="clearfix"></div>
                                                    <button data-id="{{ $order['orderid'] }}" class="btn btn-actions btn-details mr-4">Click to show/hide details</button>
                                                    <a href="/admin/{{ $order['mtp'] }}-orders/{{ $order['id'] }}/edit" target="_blank" data-type="{{ $order['mtp'] }}-orders" data-id="{{ $order['orderid'] }}" class="btn btn-primary btn-edit">Edit</a>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr id="tr-{{ $order['orderid'] }}" class="d-none">
                                            <td colspan="4" lass="p-md-6 my-4">
                                                <div class="clearfix"></div>
                                                <div class="orders">
                                                    <div id="tab-order-details" class="tab-order-details d-md-block">
                                                        <div class="row title py-2">
                                                            <div class="col-6 col-md-3 text-cap text-bold color-dark-green">
                                                                <h4>Order <span class="order-number">{{ $order['orderid'] }}</span></h4>
                                                            </div>
                                                            <div class="col-6 col-md-3 text-cap text-bold color-dark-green">
                                                                <span class="order-date">{{ date_format(date_create($order['date']), 'g:i A\, Y-m-d') }}</span>
                                                            </div>
                                                            <div class="col-6 col-md-3 text-bold color-yellow">
                                                                <span class="status-pay">{{ $order['payment_status'] }}</span>
                                                            </div>
                                                            <div class="col-6 col-md-3 text-bold color-yellow">
                                                                <span class="status-shipping">{{ $order['mtp'] == 'product' ? $order['shipping_status'] : ""}}</span>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="content-title text-bold row py-2">
                                                            <div class="text-cap col-md-5">
                                                                Product:
                                                            </div>
                                                            <div class="text-cap col-md-2">
                                                                Qty
                                                            </div>
                                                            <div class="text-cap col-md-5">
                                                                Price
                                                            </div>
                                                        </div>
                                                        @if($order['mtp'] == 'product')
                                                            @foreach($order['product'] as $product)
                                                                <div class="content row product-rows py-2">
                                                                    <div class="text-cap col-md-5 color-yellow">
                                                                        {{ $product['name'] }}
                                                                    </div>
                                                                    <div class="text-cap col-md-2 color-yellow">
                                                                        {{ $product['quantity'] }}
                                                                    </div>
                                                                    <div class="text-cap col-md-5 color-yellow">
                                                                        ${{ number_format($product['price'], 2) }}/{{ $order['currency'] }}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                        <div class="content row product-rows py-2">
                                                            <div class="text-cap col-md-5 color-yellow">
                                                                {{ $order['metal_name'] }}
                                                            </div>
                                                            <div class="text-cap col-md-2 color-yellow">
                                                                {{ $order['quantity_oz'] }}
                                                            </div>
                                                            <div class="text-cap col-md-5 color-yellow">
                                                                {{ number_format($order['price_per_oz'], 2) }}/{{ $order['currency'] }}
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if($order['mtp'] == 'product')
                                                            @php
                                                                $shippingoption = $order['shipping_option'] === 'Delivery' ? 'FEDEX' : $order['shipping_option'];
                                                            @endphp
                                                            @if($order['fedex_details'])
                                                                <div class="shipping-opt row py-2">
                                                                    <div class="col-md-7 text-cap">
                                                                        Shipping Option:
                                                                    </div>
                                                                    <div class="col-md-5 color-yellow text-cap">
                                                                        <span class="shipping-option">{{ $shippingoption }}</span>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $fedexPrice = 0;
                                                                @endphp
                                                                @if($shippingoption == 'FEDEX')
                                                                    @if($order['fedex_details']->tracking_number)                                                                    
                                                                        <div class="shipping-track row py-2">
                                                                            <div class="col-md-7 text-cap">
                                                                                Tracking Number
                                                                            </div>
                                                                            <div class="col-md-5 color-yellow text-cap">
                                                                                #<span class="tracking-number">{{ $order['fedex_details']->tracking_number }}</span>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @php
                                                                        $fedexPrice = $order['fedex_details']->price > 0 ? $order['fedex_details']->price : $fedexPrice;
                                                                    @endphp
                                                                    <div class="shipping-opt row py-2">
                                                                        <div class="col-md-7 text-cap">
                                                                            <span class="fedex-name">{{ $order['fedex_details']->service }}</span>
                                                                        </div>
                                                                        <div class="col-md-5 color-yellow text-cap">
                                                                            <span class="fedex-price">{{ $fedexPrice }}</span>/<span class="currency">{{ $order['fedex_details']->currency }}</span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endif
                                                        <hr>
                                                        <div class="subtotal row py-2">
                                                            <div class="text-cap col-md-7">
                                                                Subtotal:
                                                            </div>
                                                            <div class="col-md-5 color-yellow">
                                                                $<span class="sub-total">{{ number_format($order['subtotal'], 2) }}</span>/<span class="currency">{{ $order['currency'] }}</span>
                                                            </div>
                                                        </div>
                                                        @if($order['has_fee'])
                                                            <div class="fee row py-2">
                                                                <div class="text-cap col-md-7">
                                                                    3.75% processing fee:
                                                                </div>
                                                                <div class="col-md-5 color-yellow">
                                                                    $<span class="fee-paid">{{ number_format($order['paid_fee'], 2) }}</span>/<span class="currency">{{ $order['currency'] }}</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <hr>
                                                        <div class="total row py-2">
                                                            <div class="col-md-7 text-cap">
                                                                Total: 
                                                            </div>
                                                            @php
                                                                $fedexPrice = $order['fedex_details'] ? $fedexPrice : 0;
                                                            @endphp
                                                            <div class="col-md-5 color-yellow">
                                                                $<span class="total-order">{{ number_format($order['priceproduct'] + $fedexPrice + $order['paid_fee'], 2) }}</span>/<span class="currency">{{ $order['currency'] }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="percent row py-2">
                                                            <div class="text-cap col-md-7">
                                                                Paid:
                                                            </div>
                                                            <div class="col-md-5 color-yellow">
                                                                $<span class="total-paid">{{ number_format($order['paid'] + $order['paid_fee'], 2) }}</span>/<span class="currency">{{ $order['currency'] }}</span>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="percent-pay row payments-title d-flex py-2">
                                                            <div class="text-cap col-12 text-bold">
                                                                PAYMENTS:
                                                            </div>
                                                        </div>
                                                        <div class="content-title row m-0 payments-order py-2">
                                                            <div class="d-none d-md-block">
                                                                <div class="content-title text-bold row">
                                                                    <div class="text-cap col-md-4">
                                                                        Date
                                                                    </div>
                                                                    <div class="text-cap col-md-3">
                                                                        Value
                                                                    </div>
                                                                    <div class="text-cap col-md-5">
                                                                        Method
                                                                    </div>
                                                                </div>
                                                                @foreach($order['payments'] as $payment)
                                                                    <div class="row">
                                                                        <div class="text-cap col-md-4 color-yellow">
                                                                            {{ date_format(date_create($payment['date']), 'g:i A\, Y-m-d') }}
                                                                        </div>
                                                                        <div class="text-cap col-md-3 color-yellow">
                                                                            @php
                                                                                $value = $payment['payment_method_id'] == 3 ? $payment['value'] * 1.0375 : $payment['value'];
                                                                            @endphp
                                                                            ${{ number_format($value, 2) }}/{{ $order['currency'] }}
                                                                        </div>
                                                                        <div class="text-cap col-md-5 color-yellow">
                                                                            {{ $payment['method'] }}
                                                                        </div>
                                                                    </div>                                                                
                                                                @endforeach
                                                            </div>
                                                            <div class="d-md-none d-block">
                                                                @foreach($order['payments'] as $payment)
                                                                    <div class="row">
                                                                        <div class="content-title text-bold text-cap col-6">
                                                                            Date
                                                                        </div>
                                                                        <div class="text-cap col-6 color-yellow">
                                                                            {{ date_format(date_create($payment['date']), 'g:i A\, Y-m-d') }}
                                                                        </div>
                                                                        <div class="content-title text-bold text-cap col-6">
                                                                            Value
                                                                        </div>
                                                                        <div class="text-cap col-6 color-yellow">
                                                                            @php
                                                                                $value = $payment['payment_method_id'] == 3 ? $payment['value'] * 1.0375 : $payment['value'];
                                                                            @endphp
                                                                            ${{ number_format($value, 2) }}/{{ $order['currency'] }}
                                                                        </div>
                                                                        <div class="content-title text-bold text-cap col-6">
                                                                            Method
                                                                        </div>                                                                    
                                                                        <div class="text-cap col-6 color-yellow">
                                                                            {{ $payment['method'] }}
                                                                        </div>
                                                                        <br>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        @if($order['subtotal'] - $order['paid'] > 0.01)
                                                        <div class="pending row payment-pending py-2">
                                                            <div class="text-cap col-md-7">
                                                                PENDING BALANCE:
                                                            </div>
                                                            <div class="col-md-5 color-yellow">
                                                                $<span class="pending-pay">{{ number_format($order['subtotal'] - $order['paid'], 2) }}</span>/<span class="currency">{{ $order['currency'] }}</span>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="pending row payment-pending py-2">
                                                            PAYMENT COMPLETE
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="display: none;"></td>
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
        <div class="row">
            <div class="col-6 col-md-4 center">
                <button onclick="location.href='/admin/product-orders'" class="btn btn-primary">See all product orders</button>
            </div>
            <div class="col-6 centero col-md-4 offset-md-2">
                <button onclick="location.href='/admin/metal-orders'" class="btn btn-primary">See all metal orders</button>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link href="{{ URL::to('/') }}/css/admin/custom.css?ver=1.0.0" rel="stylesheet">
    <style>
        .dtr-details{
            width: 100%;
        }
        .dtr-details .dtr-data{
            white-space: normal;
            width: 100%;
        }
        #dataTable_wrapper {
            /*display: none;*/
        }
        .w-90{
            width: 90% !important;
            margin: auto !important;
        }
        .justify-content-between {
            -webkit-box-pack: justify!important;
            -ms-flex-pack: justify!important;
            justify-content: space-between!important;
            display: flex!important;
        }
        @media (max-width: 768px){
            .dataTables_filter{
                margin-left: -30% !important;
            }
        }
    </style>
@stop

@section('javascript')
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(function () {
            var url = window.location.href;
            var arr = url.split('?');
            if (arr.length === 1) {
                $('#reset').attr('disabled', true);
                $('#reset').css('opacity', "0.6");
                $('#reset').css('background', "lightgray");
            }
            $(".dpicker1").datetimepicker({
                format: 'DD/MM/YYYY',
                date: '{{ $start }}'
            });
            $(".dpicker2").datetimepicker({
                format: 'DD/MM/YYYY',
                date: '{{ $end }}'
            });
            $(".dpicker").on("dp.change", function(){
                $('#reset').attr('disabled', false);
                $('#reset').css('opacity', "1");
                $('#reset').css('background', "#22a7f0");
            });
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
                    {"width": "60%", "targets": 0},
                    {"width": "10%", "targets": 1},
                    {"width": "10%", "targets": 2},
                    {"width": "20%", "targets": 3}
                ],
                "responsive": responsive,
            });
            
            $('#reset').on('click', function (e) {
                e.preventDefault();
                window.location.replace(arr[0]);
            });
            $('#dataTable tbody').on('click', '.btn-actions', function () {
                let id = $(this).attr('data-id');
                $('#tr-' + id).toggleClass('d-none').toggleClass('d-tablerow');
            });  
        });
    </script>
@stop