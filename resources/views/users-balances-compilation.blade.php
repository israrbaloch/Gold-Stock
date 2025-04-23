@extends('voyager::master')
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            Balances Compilation
        </h1>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')

        @php
            $cad = 0;
            $usd = 0;
            $euro = 0;
            foreach ($usersbalances['cash'] as $balances) {
                foreach ($balances as $k => $v) {
                    if ($k == 'CAD') {
                        $cad += $v['total'];
                    }
                    if ($k == 'USD') {
                        $usd += $v['total'];
                    } 
                    if ($k == 'EUR'){
                        $euro += $v['total'];
                    }
                }
            }
            
            $gold = 0;
            $silver = 0;
            $platinum = 0;
            $palladium = 0;
            foreach ($usersbalances['metals'] as $balances) {
                foreach ($balances as $k => $v) {
                    if ($k == 'Gold') {
                        $gold += $v['total'];
                    }
                    if ($k == 'Silver') {
                        $silver += $v['total'];
                    }
                    if ($k == 'Platinum') {
                        $platinum += $v['total'];
                    }
                    if ($k == 'Palladium') {
                        $palladium += $v['total'];
                    }
                }
            }
        @endphp
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div>
                            <h4>Users Balance Compilation</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-3" onclick="totalUsd()" style="cursor: pointer;">
                                    <div class="row">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px; margin-left: 10px;">
                                            <p style="margin-top: 8px;">Total USD</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;"><?= number_format($usd, 2) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row" onclick="totalCad()" style="cursor: pointer;">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px; margin-left: 10px;">
                                            <p style="margin-top: 8px;">Total CAD</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;"><?= number_format($cad, 2) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row" onclick="totalEur()" style="cursor: pointer;">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px; margin-left: 10px;">
                                            <p style="margin-top: 8px;">Total EUR</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;"><?= number_format($euro, 2) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row" onclick="totalGold()" style="cursor: pointer;">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px; margin-left: 10px;">
                                            <p style="margin-top: 8px;">Total Gold</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;"><?= number_format($gold, 5) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row" onclick="totalSilver()" style="cursor: pointer;">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px; margin-left: 10px;">
                                            <p style="margin-top: 8px;">Total Silver</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;"><?= number_format($silver, 5) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row" onclick="totalPlatinum()" style="cursor: pointer;">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px; margin-left: 10px;">
                                            <p style="margin-top: 8px;">Total Platinum</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;"><?= number_format($platinum, 5) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row" onclick="totalPalladium()" style="cursor: pointer;">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px; margin-left: 10px;">
                                            <p style="margin-top: 8px;">Total Palladium</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;"><?= number_format($palladium, 5) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <h4>Users with <h id="typeB">USD</h> Balances</h4>
                            <hr>
                            <table id="dataTable" class="table table-hover"
                                style="border-collapse: collapse; border-spacing: 0;">
                                <thead class="thead">
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>
                                            <h id="type">USD</h> Balance
                                        </th>
                                        <th class="d-none">                                            
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    <?php 
                                    foreach ($usersbalances['cash'] as $userId => $balance){
                                        foreach($balance as $k => $v){
                                            if($v['total'] > 0){
                                            ?>
                                                <tr class="balances" data-c="{{ $k }}">
                                                    <td class="fname">{{ $v['fname'] }}</td>
                                                    <td class="lname">{{ $v['lname'] }}</td>
                                                    <td class="email">{{ $v['email'] }}</td>
                                                    <td class="balance">${{ number_format($v['total'], 2) }}</td>
                                                    <td class="d-none">{{ $k }}</td>
                                                </tr>
                                            <?php
                                            }
                                        } 
                                    } 
                                    foreach( $usersbalances['metals'] as $userId => $balance ) { 
                                        foreach($balance as $k => $v){
                                            if($v['total'] > 0){
                                            ?>
                                                <tr class="balances" data-c="{{ $k }}">
                                                    <td class="fname">{{ $v['fname'] }}</td>
                                                    <td class="lname">{{ $v['lname'] }}</td>
                                                    <td class="email">{{ $v['email'] }}</td>
                                                    <td class="balance">{{ number_format($v['total'], 5) }}</td>
                                                    <td class="d-none">{{ $k }}</td>
                                                </tr>
                                            <?php
                                            }
                                        } 
                                    } 
                                    ?>
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
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <style>
        .d-none {
            display: none;
        }

        #dataTable,
        #dataTable thead,
        #dataTable tr,
        #dataTable tbody {
            width: 100% !important;
        }

        #dataTable .fname {
            width: 25% !important;
        }

        #dataTable .lname {
            width: 20% !important;
        }

        #dataTable .email {
            width: 33% !important;
        }

        #dataTable .balance {
            width: 22% !important;
        }

    </style>
@stop

@section('javascript')
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <!-- DataTables -->
    <script>
        var table;
        $(function() {
            table = $('#dataTable').DataTable({
                "order": [],
                "language": {!! json_encode(__('voyager::datatable'), true) !!},
                @if (config('dashboard.data_tables.responsive'))
                    , responsive: true
                @endif
            });
            
            updaterows('USD');
        });

        function updaterows(ttype) {
            let wd = $(window).width() * 0.92;
            $('#dataTable *').width(wd);
            var regExSearch = '^\\' + ttype +'\\s*$';
            table.column(4).search(regExSearch, true, false).draw();
        }
    </script>

    <!-- Toogle Data Table -->
    <script>
        function totalUsd() {
            updaterows("USD");
            document.getElementById("type").innerHTML = "USD";
            document.getElementById("typeB").innerHTML = "USD";
        }

        function totalCad() {
            updaterows("CAD");
            document.getElementById("type").innerHTML = "CAD";
            document.getElementById("typeB").innerHTML = "CAD";
        }

        function totalEur() {
            updaterows("EUR");
            document.getElementById("type").innerHTML = "EUR";
            document.getElementById("typeB").innerHTML = "EUR";
        }

        function totalGold() {
            updaterows("Gold");
            document.getElementById("type").innerHTML = "Gold";
            document.getElementById("typeB").innerHTML = "Gold";
        }

        function totalSilver() {
            updaterows("Silver");
            document.getElementById("type").innerHTML = "Silver";
            document.getElementById("typeB").innerHTML = "Silver";
        }

        function totalPlatinum() {
            updaterows("Platinum");
            document.getElementById("type").innerHTML = "Platinum";
            document.getElementById("typeB").innerHTML = "Platinum";
        }

        function totalPalladium() {
            updaterows("Palladium");
            document.getElementById("type").innerHTML = "Palladium";
            document.getElementById("typeB").innerHTML = "Palladium";
        }
    </script>
@stop
