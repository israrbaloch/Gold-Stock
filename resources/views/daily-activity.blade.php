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
                            @if($orders)
                            <div id="table-daily">
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
                                                        <button data-id="{{ $order['orderid'] }}" class="btn btn-actions btn-details me-4">Click to show/hide details</button>
                                                        <a href="/admin/{{ $order['mtp'] }}-orders/{{ $order['id'] }}/edit" target="_blank" data-type="{{ $order['mtp'] }}-orders" data-id="{{ $order['orderid'] }}" class="btn btn-primary btn-edit">Edit</a>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="tr-{{ $order['orderid'] }}" class="d-none">
                                                <td colspan="4" class="p-md-6 my-4">
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
                            @else
                                <div id="no-daily-data" class="w-80 mx-auto center">
                                    <h4 class="text-gray">No data available</h4>
                                </div>
                            @endif
                            <br>
                            <hr>
                            <form action="{{ route('admin.daily-activity') }}" method="get">
                                <div class="row w-98 mx-auto px-2em">
                                    <div class="col-12 col-md-10 col-md-offset-1">
                                        <div class="row">
                                            <div class="col-12 col-md-12 center">
                                                <h3>Or select date interval: </h3>
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
                                    </div>
                                </div>
                            </form>
                            <br>
                            <hr>
                            <div class="row w-90 mx-auto">
                                <div class="col-12 col-md-offset-1 col-md-10 center">
                                    <h3>Search by User Name/User Email/Account number:</h3>
                                </div>
                                <div class="col-12 col-md-offset-1 col-md-10 center">
                                    <select id="users-select" class="w-90 h-20 mx-auto">
                                        <option></option>
                                        @foreach($accounts as $account)
                                            @if( !empty($account->name_for_admins) )
                                                <option value="{{ $account->id }}" data-name="{{ $account->name_for_admins }}" data-account-number="{{ $account->number }}">{{ $account->name_for_admins }} - {{ $account->number }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div id="user-actions" data-id="" class="d-none row w-98 mx-auto px-2em">
                                 <div class="col-12 col-md-10 col-md-offset-1">
                                    <div class="row">
                                        <div class="col-12 px-sm-2em py-sm-1em col-md-3">
                                            <button data-action="balance" class="w-90 mx-auto btn btn-actions">Show Balance</button>
                                        </div>
                                        <div class="col-12 px-sm-2em py-sm-1em col-md-3">
                                            <button data-action="orders" class="w-90 mx-auto btn btn-actions">Show Orders</button>
                                        </div>
                                        <div class="col-12 px-sm-2em py-sm-1em col-md-3">
                                            <button data-action="deposits" class="w-90 mx-auto btn btn-actions">Show Deposits</button>
                                        </div>
                                        <div class="col-12 px-sm-2em py-sm-1em col-md-3">
                                            <button data-action="withdrawals" class="w-90 mx-auto btn btn-actions">Show Withdrawals</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="user-orders" class="d-none row user-data">
                                <div class="col-12 col-md-10 col-md-offset-1 center">
                                    <br class="d-none d-md-block">
                                    <br class="d-none d-md-block">
                                    <span class="user-name"></span>
                                    <div id="table-orders-container" class="center">
                                        <br class="d-none d-md-block">
                                        <table id="table-orders" class="table table-hover table-recent w-98">
                                            <thead>
                                                <tr>
                                                    <th class="user_email">Order Id</th>
                                                    <th class="order_type">Type</th>
                                                    <th class="order_date">Date</th>
                                                    <th class="tt"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="user-balance" class="d-none user-data center">
                                <br>
                                <br class="d-none d-md-block">
                                <span class="user-name"></span>
                                <div class="px-sm-2em">
                                    <br>
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-md-offset-4">
                                            <div class="row">
                                                <div class="col-6 col-md-6" style="background-color: #f3a30c; color: #fff; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;">Total USD</span>
                                                </div>
                                                <div class="col-6 col-md-6 text-right" style="background-color: #f0f0f0; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;" id="usd">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-md-offset-4">
                                            <div class="row" style="margin-top: -30px">
                                                <div class="col-6 col-md-6" style="background-color: #f3a30c; color: #fff; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;">Total CAD</span>
                                                </div>
                                                <div class="col-6 col-md-6 text-right" style="background-color: #f0f0f0; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;" id="cad">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-md-offset-4">
                                            <div class="row" style="margin-top: -30px">
                                                <div class="col-6 col-md-6" style="background-color: #f3a30c; color: #fff; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;">Total EUR</span>
                                                </div>
                                                <div class="col-6 col-md-6 text-right" style="background-color: #f0f0f0; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;" id="eur">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-md-offset-4">
                                            <div class="row" style="margin-top: -30px">
                                                <div class="col-6 col-md-6" style="background-color: #f3a30c; color: #fff; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;">Total Gold</span>
                                                </div>
                                                <div class="col-6 col-md-6 text-right" style="background-color: #f0f0f0; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;" id="gold">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-md-offset-4">
                                            <div class="row" style="margin-top: -30px">
                                                <div class="col-6 col-md-6" style="background-color: #f3a30c; color: #fff; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;">Total Silver</span>
                                                </div>
                                                <div class="col-6 col-md-6 text-right" style="background-color: #f0f0f0; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;" id="silver">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-md-offset-4">
                                            <div class="row" style="margin-top: -30px">
                                                <div class="col-6 col-md-6" style="background-color: #f3a30c; color: #fff; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;">Total Platinum</span>
                                                </div>
                                                <div class="col-6 col-md-6 text-right" style="background-color: #f0f0f0; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;" id="platinum">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4 col-md-offset-4">
                                            <div class="row" style="margin-top: -30px">
                                                <div class="col-6 col-md-6" style="background-color: #f3a30c; color: #fff; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;">Total Palladium</span>
                                                </div>
                                                <div class="col-6 col-md-6 text-right" style="background-color: #f0f0f0; height: 40px; line-height: 40px;">
                                                    <span style="margin-top: 8px;" id="palladium">0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="user-transactions" class="d-none user-data col-12 col-md-10 col-md-offset-1 center">
                                <br>
                                <br class="d-none d-md-block">
                                <span class="user-name"></span>
                                <table id="table-transactions" class="table table-hover table-transactions w-98">
                                    <thead>
                                        <tr class="text-left">
                                            <td>Type</td>
                                            <td>Payment Method</td>
                                            <td>Value</td>
                                            <td>Status</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div id="table-no-data" class="d-none row center user-data">
                                <div class="col-12 col-md-10 col-md-offset-1 center">
                                    <h4 class="text-gray">No data available</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-md-4 col-md-offset-2 center">
                <button onclick="location.href='/admin/product-orders'" class="btn btn-primary">See all product orders</button>
            </div>
            <div class="col-6 center col-md-4 offset-md-2">
                <button onclick="location.href='/admin/metal-orders'" class="btn btn-primary">See all metal orders</button>
            </div>
        </div>
    </div>
@stop

@section('css')
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
        .h-20{
            height: 20px !important;
        }
        .justify-content-between {
            -webkit-box-pack: justify!important;
            -ms-flex-pack: justify!important;
            justify-content: space-between!important;
            display: flex!important;
        }
        .text-gray{
            color: gray;
        }
        .text-right{
            text-align: right;
        }
        tr.px-4 td{
            padding-left: 2.5em !important;
            padding-right: 2.5em !important;
        }
        .mx-auto{
            margin-left: auto;
            margin-right: auto;
        }
        .px-2em{
            padding-left: 2em !important;
            padding-right: 2em !important;
        }
        .select2-container{
            width: 100% !important;
        }
        .select2-search--dropdown .select2-search__field {
            width: 98% !important;
        }
        .user-data{
            overflow-x: auto;
        }
        @media (max-width: 768px){
            h3{
                font-size: 16px !important;
            }
            .py-sm-1em{
                padding-top: 1em !important;
                padding-bottom: 1em !important;
            }
            .px-sm-2em{
                padding-left: 2em !important;
                padding-right: 2em !important;
            }
            .p-sm-2em{
                padding: 2em !important;
            }
            .dataTables_filter{
                margin-left: -30% !important;
            }
            #user-balance span{
                width: 100%;
                padding: 0 1em;
            }
        }
    </style>
@stop

@section('javascript')
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        var user_data = [];
        $(function () {
            $('#users-select').select2({
                placeholder: "Type name, email or account number",
                allowClear: true
            });
            $('#users-select').on('select2:select', function (e) {
                $('#user-actions').removeClass('d-none').addClass('d-flex');
                $('#dataTable_wrapper').removeClass('d-block').addClass('d-none');
                var data = e.params.data;
                $('#user-actions').attr('data-id', data.element.value);
                $('.btn-actions').removeAttr('disabled');
                $(".user-data").addClass('d-none').removeClass('d-flex').removeClass('d-block');
            });
            $("#users-select").on("select2:unselecting", function(e) {
                $('.btn-actions').removeAttr('disabled');
                $('#user-actions').removeClass('d-flex').addClass('d-none');
                $('#dataTable_wrapper').removeClass('d-none').addClass('d-block');
                $(".user-data").addClass('d-none').removeClass('d-flex').removeClass('d-block');
            });
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
            var wwidth = window.innerWidth;
            var responsive = wwidth < 767 ? true : false;
            if(responsive){
                $('#dataTable').DataTable({
                    "order": [],
                    "lengthChange": false,
                    "paging": false,
                    "bInfo" : false,
                    "bFilter": false,
                    "language": {!! json_encode(__('voyager::datatable'), true) !!},
                    "columnDefs": [
                        {"targets": [ -1 ], "bFilter":  false, "orderable": false},
                        {"width": "60%", "targets": 0},
                        {"width": "10%", "targets": 1},
                        {"width": "10%", "targets": 2},
                        {"width": "20%", "targets": 3}
                    ],
                    "responsive": true,
                });
            } else {
                $('#dataTable').DataTable({
                    "order": [],
                    "lengthChange": false,
                    "paging": false,
                    "bInfo" : false,
                    "bFilter": false,
                    "language": {!! json_encode(__('voyager::datatable'), true) !!},
                    "columnDefs": [
                        {"targets": [ -1 ], "bFilter":  false, "orderable": false},
                        {"width": "60%", "targets": 0},
                        {"width": "10%", "targets": 1},
                        {"width": "10%", "targets": 2},
                        {"width": "20%", "targets": 3}
                    ],
                    "responsive": false,
                });
            }
            
            $('#user-actions .btn-actions').on('click', function (e) {
                $('.btn-actions').attr('disabled', 'disabled');
                $('.user-data').removeClass('d-flex').removeClass('d-block').addClass('d-none');
                e.preventDefault();
                
                let acc_id = $('#user-actions').attr('data-id');
                let action = $(this).attr('data-action');
                getData(acc_id, action, this);
            });
            $('#table-orders-container').on('click', '.btn-details', function () {
                let id = $(this).attr('data-id');
                console.log(id);
                $('#table-orders-container').find('#tr-' + id ).toggleClass('d-none').toggleClass('d-tablerow');
            });
            $('#reset').on('click', function (e) {
                e.preventDefault();
                window.location.replace(arr[0]);
            });
            $('#dataTable tbody').on('click', '.btn-actions', function () {
                $(this).attr('disabled', 'disabled');
                let id = $(this).attr('data-id');
                $('#tr-' + id).toggleClass('d-none').toggleClass('d-tablerow');
            });  
        });
        
        function getData(acc_id, action, btn){
            var url = "";
            switch (action) {
                case 'balance':
                    url = '/admin/da-user-balances';
                    break;
                case 'orders':
                    url = '/admin/da-user-orders';
                    break;
                case 'deposits':
                    url = '/admin/da-user-deposits';
                    break;
                case 'withdrawals':
                    url = '/admin/da-user-withdrawals';
                    break;
            }    
            $.ajax({
                url: url,
                type: "post",
                data: {
                    acc_id: acc_id
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (resp) {
                    if (resp.success)
                    {
                        $('.btn-actions').removeAttr('disabled');
                        $(btn).attr('disabled', 'disabled');
                        if(action === 'orders'){
                            var el = '';
                            if(resp.user_data.length > 0){
                                $('#user-orders .user-name').html(resp.name_for_admins);
                                var tbody = $('#table-orders').find('tbody');
                                $(tbody).empty();
                                el = populateUserOrders(resp.user_data);
                                $(tbody).append(el);
                                $("#user-orders").removeClass('d-none').addClass('d-flex');
                                $("#table-no-data").addClass('d-none').removeClass('d-flex');
                            } else {
                                $("#user-orders").addClass('d-none').removeClass('d-flex');
                                $("#table-no-data").removeClass('d-none').addClass('d-flex');
                            }
                        } else if(action === 'balance'){
                            populateUserBalance(resp.user_data, action);
                            $('#user-balance .user-name').html(resp.name_for_admins);
                            $("#user-balance").removeClass('d-none').addClass('d-block');
                        } else {
                            var el = '';
                            if(resp.user_data.length > 0){
                                var tbody = $('#table-transactions').find('tbody');
                                $(tbody).html('');
                                el = populateUserTransactions(resp.user_data, action);
                                console.log(el);
                                $(tbody).append(el);
                                $("#user-transactions").removeClass('d-none').addClass('d-flex');
                                $("#table-no-data").addClass('d-none').removeClass('d-flex');
                                
//                                var wwidth = window.innerWidth;
//                                var responsive = wwidth < 767 ? true : false;
//                                if(responsive){
//                                    $('#table-transactions').DataTable({
//                                        "destroy": true,
//                                        "order": [],
//                                        "lengthChange": false,
//                                        "paging": false,
//                                        "bInfo" : false,
//                                        "bFilter": false,
//                                        "language": {!! json_encode(__('voyager::datatable'), true) !!},
//                                        "columnDefs": [
//                                            {"targets": [ -1 ], "orderable": false},
//                                            {"width": "60%", "targets": 0},
//                                            {"width": "10%", "targets": 1},
//                                            {"width": "10%", "targets": 2},
//                                            {"width": "20%", "targets": 3}
//                                        ],
//                                        "responsive": true,
//                                    });
//                                } else {
//                                    $('#table-transactions').DataTable({
//                                        "destroy": true,
//                                        "order": [],
//                                        "lengthChange": false,
//                                        "paging": false,
//                                        "bInfo" : false,
//                                        "bFilter": false,
//                                        "language": {!! json_encode(__('voyager::datatable'), true) !!},
//                                        "columnDefs": [
//                                            {"targets": [ -1 ], "orderable": false},
//                                            {"width": "60%", "targets": 0},
//                                            {"width": "10%", "targets": 1},
//                                            {"width": "10%", "targets": 2},
//                                            {"width": "20%", "targets": 3}
//                                        ],
//                                        "responsive": false,
//                                    });
//                                }
                            } else {
                                $("#user-transactions").addClass('d-none').removeClass('d-flex');
                                $("#table-no-data").removeClass('d-none').addClass('d-flex');
                            }
                        }
                    } else {
                        alert('Something went wrong, please try again');
                    }
                }
            });
        }
        function populateUserTransactions(data, action){
            var el = '';
            data.forEach(function(transaction) {
                el += '<tr class="text-left">';
                    el += '<td>' + transaction.product.name + '</td>';
                    el += '<td>' + transaction.payment_method + '</td>';
                    el += '<td>'; 
                        el += transaction.type === 'cash' ? '$' : '';
                        el += transaction.type === 'cash' ? addCommas(transaction.product.price.toFixed(2)) : transaction.product.price.toFixed(5);
                        el += transaction.type === 'metal' ? '/oz' : '';
                    el += '</td>';
                    el += '<td>' + transaction.status + '</td>';
                    el += '<td>';
                    if(action === 'deposits'){
                        if(transaction.type === 'cash'){
                            el += '<a href="/admin/cash-deposits/' + transaction.id + '/edit" target="_blank" class="btn btn-primary">Edit</a>';
                        } else {
                            el += '<a href="/admin/metal-deposits/' + transaction.id + '/edit" target="_blank" class="btn btn-primary">Edit</a>'
                        }
                    } else {
                        if(transaction.type === 'cash'){
                            el += '<a href="/admin/cash-withdrawals/' + transaction.id + '/edit" target="_blank" class="btn btn-primary">Edit</a>';
                        } else {
                            el += '<a href="/admin/metal-withdrawals/' + transaction.id + '/edit" target="_blank" class="btn btn-primary">Edit</a>'
                        }
                    }
                    el += '</td>';
                el += '</tr>';
            });
            return el;
        }
        function populateUserBalance(data){
            data.cash.forEach(function(balance) {
                parseFloat(balance.total) > 0.009 ? $('#' + balance.currency.toLowerCase() + '').text('$' + addCommas(balance.total)) : 0;
            });
            data.metals.forEach(function(balance) {
                console.log(balance);
                parseFloat(balance.total) > 0.00009 ? $('#' + balance.metalName.toLowerCase() + '').text(balance.total + '/oz') : 0;
            });
        }
        function populateUserOrders(data){
            let el = '';
            for(var i = 0; i < data.length ; i++){
                el += '<tr>';
                    el += '<td>' + data[i].orderid + '</td>';
                    el += '<td>' + data[i].order_type + '</td>';
                    el += '<td>' + formatDate(data[i].date) + '</td>';
                    el += '<td>';
                        el += '<div class="w-100 d-flex justify-content-between">';
                            el += '<div class="clearfix"></div>';
                            el += '<button data-id="' + data[i].orderid + '" class="btn btn-actions btn-details me-4">Click to show/hide details</button>';
                            el += '<a href="/admin/' + data[i].mtp + '-orders/' + data[i].id + '/edit" target="_blank" data-type="' + data[i].mtp + '-orders" data-id="' + data[i].orderid + '" class="btn btn-primary btn-edit">Edit</a>';
                            el += '<div class="clearfix"></div>';
                        el += '</div>';
                    el += '</td>';
                el += '</tr>';
                el += '<tr id="tr-' + data[i].orderid + '" class="d-none text-left px-4">';
                    el += '<td colspan="4" class="p-md-6 my-4">';
                        el += '<div class="clearfix"></div>';
                        el += '<div class="orders">';
                            el += '<div id="tab-order-details" class="tab-order-details d-md-block">';
                                el += '<div class="row title py-2">';
                                    el += '<div class="col-6 col-md-3 text-cap text-bold color-dark-green">';
                                        el += '<h4>Order <span class="order-number">' + data[i].orderid + '</span></h4>';
                                    el += '</div>';
                                    el += '<div class="col-6 col-md-3 text-cap text-bold color-dark-green">';
                                        el += '<span class="order-date">' + formatDate(data[i].date) + '</span>';
                                    el += '</div>';
                                    el += '<div class="col-6 col-md-3 text-bold color-yellow">';
                                        el += '<span class="status-pay">' + data[i].payment_status + '</span>';
                                    el += '</div>';
                                    el += '<div class="col-6 col-md-3 text-bold color-yellow">';
                                        el += '<span class="status-shipping">' + data[i].mtp === 'product' ? data[i].shipping_status : ""+ '</span>';
                                    el += '</div>';
                                el += '</div>';
                                el += '<hr>';
                                el += '<div class="content-title text-bold row py-2">';
                                    el += '<div class="text-cap col-md-5">';
                                        el += 'Product:';
                                    el += '</div>';
                                    el += '<div class="text-cap col-md-2">';
                                        el += 'Qty';
                                    el += '</div>';
                                    el += '<div class="text-cap col-md-5">';
                                        el += 'Price';
                                    el += '</div>';
                                el += '</div>';
                                if(data[i].mtp === 'product'){
                                    data[i].product.forEach(function($product) {
                                        el += '<div class="content row product-rows py-2">';
                                            el += '<div class="text-cap col-md-5 color-yellow">';
                                                el += $product.name;
                                            el += '</div>';
                                            el += '<div class="text-cap col-md-2 color-yellow">';
                                                el += $product.quantity;
                                            el += '</div>';
                                            el += '<div class="text-cap col-md-5 color-yellow">';
                                                el += '$' + addCommas($product.price) + '/' + data[i].currency;
                                            el += '</div>';
                                        el += '</div>';
                                    });
                                } else {
                                    el += '<div class="content row product-rows py-2">';
                                        el += '<div class="text-cap col-md-5 color-yellow">';
                                            el += data[i].metal_name;
                                        el += '</div>';
                                        el += '<div class="text-cap col-md-2 color-yellow">';
                                            el += data[i].quantity_oz;
                                        el += '</div>';
                                        el += '<div class="text-cap col-md-5 color-yellow">';
                                            el += addCommas(data[i].price_per_oz) + '/' + data[i].currency;
                                        el += '</div>';
                                    el += '</div>';
                                }
                                if(data[i].mtp === 'product'){
                                    var $shippingoption = data[i].shipping_option === 'Delivery' ? 'FEDEX' : data[i].shipping_option;

                                    if(data[i].fedex_details){
                                        el += '<div class="shipping-opt row py-2">';
                                            el += '<div class="col-md-7 text-cap">';
                                                el += 'Shipping Option:';
                                            el += '</div>';
                                            el += '<div class="col-md-5 color-yellow text-cap">';
                                                el += '<span class="shipping-option">' + $shippingoption + '</span>';
                                            el += '</div>';
                                        el += '</div>';
                                        var $fedexPrice = 0;
                                        if($shippingoption === 'FEDEX'){
                                            if(data[i].fedex_details.tracking_number){
                                                el += '<div class="shipping-track row py-2">';
                                                    el += '<div class="col-md-7 text-cap">';
                                                        el += 'Tracking Number';
                                                    el += '</div>';
                                                    el += '<div class="col-md-5 color-yellow text-cap">';
                                                        el += '#<span class="tracking-number">' + data[i].fedex_details.tracking_number + '</span>';
                                                    el += '</div>';
                                                el += '</div>';
                                            }
                                            $fedexPrice = data[i].fedex_details.price > 0 ? data[i].fedex_details.price : $fedexPrice;
                                            el += '<div class="shipping-opt row py-2">';
                                                el += '<div class="col-md-7 text-cap">';
                                                    el += '<span class="fedex-name">' + data[i].fedex_details.service + '</span>';
                                                el += '</div>';
                                                el += '<div class="col-md-5 color-yellow text-cap">';
                                                    el += '<span class="fedex-price">' + $fedexPrice + '</span>/<span class="currency">' + data[i].fedex_details.currency + '</span>';
                                                el += '</div>';
                                            el += '</div>';
                                        }
                                    }
                                }
                                el += '<hr>';
                                el += '<div class="subtotal row py-2">';
                                    el += '<div class="text-cap col-md-7">';
                                        el += 'Subtotal:';
                                    el += '</div>';
                                    el += '<div class="col-md-5 color-yellow">';
                                        el += '$<span class="sub-total">' + addCommas(data[i].subtotal) + '</span>/<span class="currency">' + data[i].currency + '</span>';
                                    el += '</div>';
                                el += '</div>';
                                if(data[i].has_fee){
                                    el += '<div class="fee row py-2">';
                                        el += '<div class="text-cap col-md-7">';
                                            el += '3.75% processing fee:';
                                        el += '</div>';
                                        el += '<div class="col-md-5 color-yellow">';
                                            el += '$<span class="fee-paid">' + addCommas(data[i].paid_fee) + '</span>/<span class="currency">' + data[i].currency + '</span>';
                                        el += '</div>';
                                    el += '</div>';
                                }
                                el += '<hr>';
                                el += '<div class="total row py-2">';
                                    el += '<div class="col-md-7 text-cap">';
                                        el += 'Total:';
                                    el += '</div>';
                                    $fedexPrice = data[i].fedex_details ? $fedexPrice : 0;
                                    el += '<div class="col-md-5 color-yellow">';
                                        el += '$<span class="total-order">' + addCommas(data[i].priceproduct + $fedexPrice + data[i].paid_fee) + '</span>/<span class="currency">' + data[i].currency + '</span>';
                                    el += '</div>';
                                el += '</div>';
                                el += '<div class="percent row py-2">';
                                    el += '<div class="text-cap col-md-7">';
                                        el += 'Paid:';
                                    el += '</div>';
                                    el += '<div class="col-md-5 color-yellow">';
                                        el += '$<span class="total-paid">' + addCommas(data[i].paid + data[i].paid_fee) + '</span>/<span class="currency">' + data[i].currency + '</span>';
                                    el += '</div>';
                                el += '</div>';
                                el += '<hr>';
                                el += '<div class="percent-pay row payments-title d-flex py-2">';
                                    el += '<div class="text-cap col-12 text-bold">';
                                        el += 'PAYMENTS:';
                                    el += '</div>';
                                el += '</div>';
                                el += '<div class="content-title row m-0 payments-order py-2">';
                                    el += '<div class="d-none d-md-block">';
                                        el += '<div class="content-title text-bold row">';
                                            el += '<div class="text-cap col-md-4">';
                                                el += 'Date';
                                            el += '</div>';
                                            el += '<div class="text-cap col-md-3">';
                                                el += 'Value';
                                            el += '</div>';
                                            el += '<div class="text-cap col-md-5">';
                                                el += 'Method';
                                            el += '</div>';
                                        el += '</div>';
                                        data[i].payments.forEach(function($payment) {
                                            el += '<div class="row">';
                                                el += '<div class="text-cap col-md-4 color-yellow">';
                                                    el += formatDate($payment.date);
                                                el += '</div>';
                                                el += '<div class="text-cap col-md-3 color-yellow">';
                                                    var $value = $payment.payment_method_id === 3 ? $payment.value * 1.0375 : $payment.value;
                                                    el += '$' + addCommas($value) + '/' + data[i].currency;
                                                el += '</div>';
                                                el += '<div class="text-cap col-md-5 color-yellow">';
                                                    el += $payment.method;
                                                el += '</div>';
                                            el += '</div>';
                                        });
                                    el += '</div>';
                                    el += '<div class="d-md-none d-block">';
                                        data[i].payments.forEach(function($payment) {
                                            el += '<div class="row">';
                                                el += '<div class="content-title text-bold text-cap col-6">';
                                                    el += 'Date';
                                                el += '</div>';
                                                el += '<div class="text-cap col-6 color-yellow">';
                                                    el += formatDate($payment.date);
                                                el += '</div>';
                                                el += '<div class="content-title text-bold text-cap col-6">';
                                                    el += 'Value';
                                                el += '</div>';
                                                el += '<div class="text-cap col-6 color-yellow">';
                                                    var $value = $payment.payment_method_id === 3 ? $payment.value * 1.0375 : $payment.value;
                                                    el += '$' + addCommas($value) + '/' + data[i].currency;
                                                el += '</div>';
                                                el += '<div class="content-title text-bold text-cap col-6">';
                                                    el += 'Method';
                                                el += '</div>';
                                                el += '<div class="text-cap col-6 color-yellow">';
                                                    el += $payment.method;
                                                el += '</div>';
                                                el += '<br>';
                                            el += '</div>';
                                        });
                                    el += '</div>';
                                el += '</div>';
                                if(data[i].subtotal - data[i].paid > 0.01){
                                    el += '<div class="pending row payment-pending py-2">';
                                        el += '<div class="text-cap col-md-7">';
                                            el += 'PENDING BALANCE:';
                                        el += '</div>';
                                        el += '<div class="col-md-5 color-yellow">';
                                            el += '$<span class="pending-pay">' + addCommas(data[i].subtotal - data[i].paid) + '</span>/<span class="currency">' + data[i].currency + '</span>';
                                        el += '</div>';
                                    el += '</div>';
                                }else {
                                    el += '<div class="pending row payment-pending py-2">';
                                        el += 'PAYMENT COMPLETE';
                                    el += '</div>';
                                }
                            el += '</div>';
                        el += '</div>';
                    el += '</td>';
                    el += '<td style="display: none;"></td>';
                    el += '<td style="display: none;"></td>';
                    el += '<td style="display: none;"></td>';
                el += '</tr>';                
            }
            return el;
        }
        
        function noResults(){
            $('#no-daily-data').removeClass('d-none');
        }
        
        function addCommas(str) {
            var parts = (str + "").split("."),
                    main = parts[0],
                    len = main.length,
                    output = "",
                    first = main.charAt(0),
                    i;

            if (first === '-') {
                main = main.slice(1);
                len = main.length;
            } else {
                first = "";
            }
            i = len - 1;
            while (i >= 0) {
                output = main.charAt(i) + output;
                if ((len - i) % 3 === 0 && i > 0) {
                    output = "," + output;
                }
                --i;
            }
            // put sign back
            output = first + output;
            // put decimal part back
            if (parts.length > 1) {
                output += "." + parts[1];
            }
            return output;
        }

        function formatDate(strdate){
            const f = new Date();
            let diff = f.getTimezoneOffset()/60;
            var res = new Date(strdate.replace(/-/g, '/').replace('T', ' ').replace('.000000Z', ''));
            var time = res.getTime();
            var newDate = new Date(time - (diff*60*60000));
            var date = new Date(newDate.toISOString().slice(0, -1) );
            var d = date.getDate();
            d = d < 10 ? "0" + d : d;
            var m =  date.getMonth() + 1;
            m = m < 10 ? "0" + m : m;
            var y = date.getFullYear();
            var h = date.getHours();
            var tt = "AM";
            if(h > 12){
                tt = "PM";
                h -= 12;
            }
            var min = date.getMinutes() < 10? "0" + date.getMinutes() : date.getMinutes();

            return h + ":" + min + " " + tt + ", " + y + "-" + m + "-" + d;
        }
    </script>
@stop