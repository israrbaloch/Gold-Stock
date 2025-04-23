@extends('voyager::master')
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            Users balances
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
                            <div style="height: 40px"></div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-11" style="height: 40px;">
                                            <select id="users" class="form-select" style="width: 100%; height: 40px;" onchange="getData()">
                                                <option >Select User for Details</option>
                                                @foreach ($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name_for_admins}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px;">
                                            <p style="margin-top: 8px;">Total USD</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;" id="usd"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="row" style="margin-top: -30px">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px;">
                                            <p style="margin-top: 8px;">Total CAD</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;" id="cad"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="row" style="margin-top: -30px">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px;">
                                            <p style="margin-top: 8px;">Total EUR</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;" id="eur"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="row" style="margin-top: -30px">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px;">
                                            <p style="margin-top: 8px;">Total Gold</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;" id="gold"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="row" style="margin-top: -30px">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px;">
                                            <p style="margin-top: 8px;">Total Silver</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;" id="silver"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="row" style="margin-top: -30px">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px;">
                                            <p style="margin-top: 8px;">Total Platinum</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;" id="platinum"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="row" style="margin-top: -30px">
                                        <div class="col-md-5"
                                            style="background-color: #f3a30c; color: #fff; height: 40px;">
                                            <p style="margin-top: 8px;">Total Palladium</p>
                                        </div>
                                        <div class="col-md-6" style="background-color: #f0f0f0;height: 40px;">
                                            <p style="margin-top: 8px;" id="palladium"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@stop

@section('javascript')
    <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    <script>
        $(function() {
            $('#users').select2();
        });
        function getData(){
            $('#usd').html(0);
            $('#cad').html(0);
            $('#eur').html(0);
            $('#gold').html(0);
            $('#silver').html(0);
            $('#platinum').html(0);
            $('#palladium').html(0);

            let id = document.getElementById('users').value;
            $.ajax({
                url: '/admin/users-balances-data/'+ id,
                type: "GET",
                success: (result) => {
                    // console.log(result);
                    // console.log(result.metals)
                    for (const key in result.metals) {
                        var metal = result.metals[key];
                        var mt = (metal.total > 0 ? parseFloat(metal.total).toFixed(5) : 0) 
                        mt += metal.total > 0 ? "/Oz" : "";
                        if (metal.metalName == "Gold") {
                            $('#gold').html(mt);
                        }
                        if (metal.metalName == "Silver") {
                            $('#silver').html(mt);
                        }
                        if (metal.metalName == "Platinum") {
                            $('#platinum').html(mt);
                        }
                        if (metal.metalName == "Palladium") {
                            $('#palladium').html(mt);
                        }
                    }

                    for (const key in result.cash) {
                        var cash = result.cash[key];
                        var ct = cash.total > 0 ? "$" + parseFloat(cash.total).toFixed(2) : 0;
                        // console.log(cash);
                        if (cash.currency == "USD") {
                            $('#usd').html(ct);
                        }
                        if (cash.currency == "CAD") {
                            $('#cad').html(ct);
                        }
                        if (cash.currency == "EUR") {
                            $('#eur').html(ct);
                        }
                    }
                }
            })
        }
    </script>
@stop
