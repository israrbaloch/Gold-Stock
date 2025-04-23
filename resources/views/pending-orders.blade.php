@extends('voyager::master')
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            Pending Orders
        </h1>
    </div>
@stop
@php
 $totalorders=sizeof($orders);
 $totalcompletes=sizeof($orderscompletes);
 $totalpendingpay=sizeof($orderspendingpay);
 $totalorderpendingship=sizeof($orderpendingship);   
@endphp
@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')

       
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div>
                            <h4>Pending Orders</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-3" onclick="totalOrders()" style="cursor: pointer;">
                                    <div class="row">
                                        <div class="col-md-5" style="background-color: #f3a30c; color: #fff; height: 50px; margin-left: 10px;">
                                            <p style="margin-top: 8px;">Total Orders</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 50px;">
                                            <p style="margin-top: 8px;"><?= $totalorders ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row" onclick="totalCompletes()" style="cursor: pointer;">
                                        <div class="col-md-5" style="background-color: #f3a30c; color: #fff; height: 50px; margin-left: 10px;">
                                            <p style="margin-top: 8px;">Complete</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 50px;">
                                            <p style="margin-top: 8px;"><?= $totalcompletes ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row" onclick="totalPendingPay()" style="cursor: pointer;">
                                        <div class="col-md-5" style="background-color: #f3a30c; color: #fff; height: 50px; margin-left: 10px;">
                                            <p style="margin-top: 8px;">Pending Payment</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 50px;">
                                            <p style="margin-top: 8px;"><?= $totalpendingpay ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row" onclick="totalPendingShip()" style="cursor: pointer;">
                                        <div class="col-md-5" style="background-color: #f3a30c; color: #fff; height: 50px; margin-left: 10px;">
                                            <p style="margin-top: 8px;">Pending Shipping</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 50px;">
                                            <p style="margin-top: 8px;"><?= $totalorderpendingship ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <br><br><h4>Users with <h id="typeB">Orders</h> Balances</h4>
                            <hr>
                            <table id="dataTable" class="table table-hover"
                            style="border-collapse: collapse; border-spacing: 0;">
                                <thead class="thead">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email Name</th>
                                        <th>Product</th>
                                        <th>Currency</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                        <th class="tt"><h id="type">Order</h></th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    @foreach ($orders as $order)
                                    
                                    <tr class="datarows" data-c="orders">
                                        <td class="user">{{$order['nameuser']}}</td>
                                        <td class="email">{{$order['email']}}</td>
                                        <td class="product">
                                            @if (is_array($order['product']))
                                                @foreach($order['product'] as $product)
                                                    {{ $product['name'] }}<br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="currency">{{$order['currency']}}</td>
                                        <td class="value">{{$order['priceproduct']}}</td>
                                        <td class="quantity">{{$order['quantity']}}</td>
                                        <td class="date">{{$order['date']}}</td>
                                        <td class="tt">Orders</td>
                                        
                                    </tr>
                                    @endforeach

                                    @foreach ($orderscompletes as $ordercomplete)
                                    <tr class="datarows" data-c="orderscompletes">
                                        <td class="user">{{$ordercomplete['nameuser']}}</td>
                                        <td class="email">{{$ordercomplete['email']}}</td>
                                        <td class="product">
                                            @if (is_array($ordercomplete['product']))
                                                @foreach($ordercomplete['product'] as $product)
                                                    {{ $product['name'] }}<br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="currency">{{$ordercomplete['currency']}}</td>
                                        <td class="value">{{$ordercomplete['priceproduct']}}</td>
                                        <td class="quantity">{{$ordercomplete['quantity']}}</td>
                                        <td class="date">{{$ordercomplete['date']}}</td>
                                        <td class="tt">Complete</td>
                                    </tr>
                                    @endforeach

                                    @foreach ($orderspendingpay as $orderpendingpay)
                                    <tr class="datarows" data-c="orderspendingpay">
                                        <td class="user">{{$orderpendingpay['nameuser']}}</td>
                                        <td class="email">{{$orderpendingpay['email']}}</td>
                                        <td class="product">
                                            @if (is_array($orderpendingpay['product']))
                                                @foreach($orderpendingpay['product'] as $product)
                                                    {{ $product['name'] }}<br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="currency">{{$orderpendingpay['currency']}}</td>
                                        <td class="value">{{$orderpendingpay['priceproduct']}}</td>
                                        <td class="quantity">{{$orderpendingpay['quantity']}}</td>
                                        <td class="date">{{$orderpendingpay['date']}}</td>
                                        <td class="tt">Pending Payment</td>
                                    </tr>
                                    @endforeach

                                    @foreach ($orderpendingship as $pendingship)
                                    <tr class="datarows" data-c="orderpendingship">
                                        <td class="user">{{$pendingship['nameuser']}}</td>
                                        <td class="email">{{$pendingship['email']}}</td>
                                        <td class="product">
                                            @foreach($pendingship['product'] as $product)
                                                {{ $product['name'] }}<br>
                                            @endforeach
                                        </td>
                                        <td class="currency">{{$pendingship['currency']}}</td>
                                        <td class="value">{{$pendingship['priceproduct']}}</td>
                                        <td class="quantity">{{$pendingship['quantity']}}</td>
                                        <td class="date">{{$pendingship['date']}}</td>
                                        <td class="tt">Pending Shipping</td>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <style>
        .tt,
        .d-none{
            display: none;
        }
        #dataTable,
        #dataTable thead,
        #dataTable tr,
        #dataTable tbody{
            width: 100% !important;
        }
       
    </style>
@stop

@section('javascript')
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <!-- DataTables -->
    <script>
        var table;
        $(function() {
            table = $('#dataTable').DataTable({
                "order": [6],
                "language": {!! json_encode(__('voyager::datatable'), true) !!},
                @if (config('dashboard.data_tables.responsive'))
                    , responsive: true
                @endif
            });
            updaterows("Orders");
        });

        function updaterows(ttype) {
            let wd = $(window).width() * 0.92;
            $('#dataTable *').width(wd);
            var regExSearch = '^\\' + ttype +'\\s*$';
            table.column(7).search(regExSearch, true, false).draw();
        }
    </script>

    <!-- Toogle Data Table -->
    <script>

        function totalOrders() {
            updaterows("Orders");
            document.getElementById("type").innerHTML = "Orders";
            document.getElementById("typeB").innerHTML = "Orders";
        }

        function totalCompletes() {
            updaterows("Complete");
            document.getElementById("type").innerHTML = "Complete";
            document.getElementById("typeB").innerHTML = "Complete";
        }

        function totalPendingPay() {
            updaterows("Pending Payment");
            document.getElementById("type").innerHTML = "Pending Payment";
            document.getElementById("typeB").innerHTML = "Pending Payment";
        }

        function totalPendingShip() {
            updaterows("Pending Shipping");
            document.getElementById("type").innerHTML = "Pending Shipping";
            document.getElementById("typeB").innerHTML = "Pending Shipping";
        }
       

    </script>
@stop
