@extends('voyager::master')
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            Users Transactions Compilation
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
                        <div>
                            <h4>Users Transactions Compilation</h4>
                            <hr>
                            <div class="row">
                                <div class="col-6 col-md-3 p-2 p-md-6" onclick="totalDep()" style="cursor: pointer;">
                                    <div class="row">
                                        <div class="col-7 col-md-7" style="background-color: #f3a30c; color: #fff; height: 50px; text-align: center;">
                                            <p style="margin-top: 8px;">Total Deposits</p>
                                        </div>
                                        <div class="col-5 col-md-5" style="background-color: #f0f0f0;height: 50px; text-align: center;">
                                            <p style="margin-top: 8px;"><?= $totaldeposits ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 p-2 p-md-6">
                                    <div class="row" onclick="totalWith()" style="cursor: pointer;">
                                        <div class="col-7 col-md-7" style="background-color: #f3a30c; color: #fff; height: 50px; text-align: center;">
                                            <p style="margin-top: 8px;">Total Whithdrawal</p>
                                        </div>
                                        <div class="col-5 col-md-5" style="background-color: #f0f0f0;height: 50px; text-align: center;">
                                            <p style="margin-top: 8px;"><?= $totalwithdrawals ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 p-2 p-md-6">
                                    <div class="row" onclick="totalCompDepo()" style="cursor: pointer;">
                                        <div class="col-7 col-md-7" style="background-color: #f3a30c; color: #fff; height: 50px; text-align: center;">
                                            <p style="margin-top: 8px;">Complete Deposits</p>
                                        </div>
                                        <div class="col-5 col-md-5" style="background-color: #f0f0f0;height: 50px; text-align: center;">
                                            <p style="margin-top: 8px;"><?= $totalcompletedeposits ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 p-2 p-md-6">
                                    <div class="row" onclick="totalCompWhit()" style="cursor: pointer;">
                                        <div class="col-7 col-md-7" style="background-color: #f3a30c; color: #fff; height: 50px; text-align: center;">
                                            <p style="margin-top: 8px;">Complete Whithdrawals</p>
                                        </div>
                                        <div class="col-5 col-md-5" style="background-color: #f0f0f0;height: 50px; text-align: center;">
                                            <p style="margin-top: 8px;"><?= $totalcompletewithdrawals ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 p-2 p-md-6">
                                    <div class="row" onclick="totalPenDepo()" style="cursor: pointer;">
                                        <div class="col-7 col-md-7" style="background-color: #f3a30c; color: #fff; height: 50px; text-align: center;">
                                            <p style="margin-top: 8px;">Pending Deposits</p>
                                        </div>
                                        <div class="col-5 col-md-5" style="background-color: #f0f0f0;height: 50px; text-align: center;">
                                            <p style="margin-top: 8px;"><?= $totalpendingdeposits ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 p-2 p-md-6">
                                    <div class="row" onclick="totalPenWhit()" style="cursor: pointer;">
                                        <div class="col-7 col-md-7" style="background-color: #f3a30c; color: #fff; height: 50px; text-align: center;">
                                            <p style="margin-top: 8px;">Pending Whithdrawals</p>
                                        </div>
                                        <div class="col-5 col-md-5" style="background-color: #f0f0f0;height: 50px; text-align: center;">
                                            <p style="margin-top: 8px;"><?= $totalpendigwithdrawals ?></p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <br><br><h4>Users <h id="typeB">Transactions</h> Compilation</h4>
                            <hr>
                            <table id="dataTable" class="table table-hover"
                            style="border-collapse: collapse; border-spacing: 0;">
                                <thead class="thead">
                                    <tr>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Value</th>
                                        <th>Currency/Metal</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class="tt"><h id="type">Deposit</h> Transactions</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    <script type="text/javascript">
                                        var deposits = "";
                                        @php foreach($deposits as $deposit) { @endphp
                                            deposits += '<tr class="datarows" data-c="deposit">';
                                            deposits += '<td class="user">{{$deposit->user}}</td>';
                                            deposits += '<td class="email">{{$deposit->email}}</td>';
                                            deposits += '<td class="value">{{$deposit->value}}</td>';
                                            deposits += '<td class="currency">{{$deposit->currencycode}}</td>';
                                            deposits += '<td class="status">{{$deposit->status}}</td>';
                                            deposits += '<td class="currency">{{$deposit->date}}</td>';
                                            deposits += '<td class="tt">Deposit</td>';
                                            deposits += '</tr>';
                                        @php } @endphp
                                    </script>
                                    @foreach ($deposits as $deposit)
                                    <tr class="datarows" data-c="deposit">
                                        <td class="user">{{$deposit->user}}</td>
                                        <td class="email">{{$deposit->email}}</td>
                                        <td class="value">{{$deposit->value}}</td>
                                        <td class="currency">{{$deposit->currencycode}}</td>
                                        <td class="status">{{$deposit->status}}</td>
                                        <td class="currency">{{$deposit->date}}</td>
                                        <td class="tt">Deposit</td>
                                    </tr>
                                    @endforeach
                                    @foreach ($withdrawals as $withdrawal)
                                    <tr class="datarows" data-c="withdrawal">
                                        <td class="user">{{$withdrawal->user}}</td>
                                        <td class="email">{{$withdrawal->email}}</td>
                                        <td class="value">{{$withdrawal->value}}</td>
                                        <td class="currency">{{$withdrawal->currencycode}}</td>
                                        <td class="status">{{$withdrawal->status}}</td>
                                        <td class="currency">{{$withdrawal->date}}</td>
                                        <td class="tt">Withdrawal</td>
                                    </tr>
                                    @endforeach

                                    @foreach ($completedeposits as $completedeposit)
                                    <tr class="datarows" data-c="completedeposit">
                                        <td class="user">{{$completedeposit->user}}</td>
                                        <td class="email">{{$completedeposit->email}}</td>
                                        <td class="value">{{$completedeposit->value}}</td>
                                        <td class="currency">{{$completedeposit->currencycode}}</td>
                                        <td class="status">{{$completedeposit->status}}</td>
                                        <td class="currency">{{$completedeposit->date}}</td>
                                        <td class="tt">Complete Deposit</td>
                                    </tr>
                                    @endforeach

                                    @foreach ($completewithdrawals as $completewithdrawal)
                                    <tr  class="datarows" data-c="completewithdrawal">
                                        <td class="user">{{$completewithdrawal->user}}</td>
                                        <td class="email">{{$completewithdrawal->email}}</td>
                                        <td class="value">{{$completewithdrawal->value}}</td>
                                        <td class="currency">{{$completewithdrawal->currencycode}}</td>
                                        <td class="status">{{$completewithdrawal->status}}</td>
                                        <td class="currency">{{$completewithdrawal->date}}</td>
                                        <td class="tt">Complete Withdrawal</td>
                                    </tr>
                                    @endforeach

                                    @foreach ($pendingdeposits as $pendingdeposit)
                                    <tr class="datarows" data-c="pendingdeposit">
                                        <td class="user">{{$pendingdeposit->user}}</td>
                                        <td class="email">{{$pendingdeposit->email}}</td>
                                        <td class="value">{{$pendingdeposit->value}}</td>
                                        <td class="currency">{{$pendingdeposit->currencycode}}</td>
                                        <td class="status">{{$pendingdeposit->status}}</td>
                                        <td class="currency">{{$pendingdeposit->date}}</td>
                                        <td class="tt">Pending Deposits</td>
                                    </tr>
                                    @endforeach

                                    @foreach ($pendingwithdrawals as $pendingwithdrawal)
                                    <tr class=" datarows"  data-c="pendingwithdrawal">
                                        <td class="user">{{$pendingwithdrawal->user}}</td>
                                        <td class="email">{{$pendingwithdrawal->email}}</td>
                                        <td class="value">{{$pendingwithdrawal->value}}</td>
                                        <td class="currency">{{$pendingwithdrawal->currencycode}}</td>
                                        <td class="status">{{$pendingwithdrawal->status}}</td>
                                        <td class="currency">{{$pendingwithdrawal->date}}</td>
                                        <td class="tt">Pending Withdrawal</td>
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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<link href="{{ URL::to('/') }}/css/admin/custom.css?ver=1.0.0" rel="stylesheet">
<style>
    .d-none{
        display: none;
    }
    #dataTable,
    #dataTable thead,
    #dataTable tr,
    #dataTable tbody{
        width: 100% !important;
    }
    .tt{
        display: none;
    }
   
</style>
@stop

@section('javascript')
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<link href="{{ URL::to('/') }}/css/admin/custom.css?ver=1.0.0" rel="stylesheet">
<!-- DataTables -->
<script>
    $(function () {
        let wd = $(window).width() * 0.92;
        $('#dataTable *').width(wd);
        var paginate = ""
        if(window.matchMedia("(max-width: 767px)").matches){
            paginate = "numbers"
        } else {
            paginate = "first_last_numbers"
        }
        
        var table = $('#dataTable').DataTable( {
            "destroy": true,
            "order": [[5, "desc"]],
            "processing": true,
            "serverSide": false,
            "paging": true,
            "scrollX": true,
            "responsive": true,
            "pagingType": paginate,
            "language": {!! json_encode(__('voyager::datatable'), true) !!}
        });
    });
    function updaterows(ttype){
        var table = $('#dataTable').DataTable();
        $.fn.dataTable.ext.search.pop();
        table.draw();
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                return $(table.row(dataIndex).node()).attr('data-c') === ttype;
            }
        );
        table.draw();
        $.fn.DataTable.ext.pager.numbers_length = 4;
    }
</script>

<!-- Toogle Data Table -->
<script>

    function totalDep() {
        updaterows("deposit");
        document.getElementById("type").innerHTML = "Deposit";
        document.getElementById("typeB").innerHTML = "Deposit";
    }

    function totalWith() {
        updaterows("withdrawal");
        document.getElementById("type").innerHTML = "Withdrawal";
        document.getElementById("typeB").innerHTML = "Withdrawal";
    }

    function totalCompDepo() {
        updaterows("completedeposit");
        document.getElementById("type").innerHTML = "Complete Deposit";
        document.getElementById("typeB").innerHTML = "Complete Deposit";
    }

    function totalCompWhit() {
        updaterows("completewithdrawal");
        document.getElementById("type").innerHTML = "Complete Withdrawal";
        document.getElementById("typeB").innerHTML = "Complete Withdrawal";
    }

    function totalPenDepo() {
        updaterows("pendingdeposit");
        document.getElementById("type").innerHTML = "Pending Deposit";
        document.getElementById("typeB").innerHTML = "Pending Deposit";
    }

    function totalPenWhit() {
        updaterows("pendingwithdrawal");
        document.getElementById("type").innerHTML = "Pending Withdrawal";
        document.getElementById("typeB").innerHTML = "Pending Withdrawal";
    }

   

</script>
@stop
