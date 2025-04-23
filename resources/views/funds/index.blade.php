@extends('header.index')

@push('styles')
    <link href="{{ URL::to('/') }}/css/funds.css?ver=1.2.0" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ URL::to('/') }}/js/funds.js?ver=1.2.0"></script>
@endpush
@php
    $currency = Cookie::get('currency');
    $totalmetals = [];
    $totalmetals['Gold'] = 0;
    $totalmetals['Silver'] = 0;
    $totalmetals['Platinum'] = 0;
    $totalmetals['Palladium'] = 0;
    foreach ($userBalance['metals'] as $k => $value) {
        if ($k == 'Gold') {
            $totalmetals['Gold'] = $value;
        } elseif ($k == 'Silver') {
            $totalmetals['Silver'] = $value;
        } elseif ($k == 'Platinum') {
            $totalmetals['Platinum'] = $value;
        } else {
            $totalmetals['Palladium'] = $value;
        }
    }
    $totalcashs = [];
    $totalcashs['CAD'] = 0;
    $totalcashs['USD'] = 0;
    $totalcashs['EUR'] = 0;
    foreach ($userBalance['cash'] as $k => $value) {
        if ($k == 'CAD') {
            if ($value > 0) {
                $totalcashs['CAD'] = $value;
            }
        } elseif ($k == 'USD') {
            if ($value > 0) {
                $totalcashs['USD'] = $value;
            }
        } else {
            if ($value > 0) {
                $totalcashs['EUR'] = $value;
            }
        }
    }
@endphp

@php
    $i = 0;
    if ($userBalance) {
        $userCashBalances = [];
        foreach ($userBalance['cash'] as $k => $balance) {
            $userCashBalances[$i]['currency'] = $k;
            $userCashBalances[$i]['total'] = $balance;
            $i++;
        }
        $i = count($userCashBalances);

        foreach ($currencies as $currency) {
            $exist = 0;
            foreach ($userCashBalances as $balance) {
                if ($exist != 1 && $balance['currency'] == $currency->code) {
                    $exist = 1;
                }
            }
            if ($exist != 1) {
                $userCashBalances[$i]['currency'] = $currency->code;
                $userCashBalances[$i]['total'] = 0;
                $i++;
            }
        }
        $i = 0;
        $userMetalBalances = [];
        foreach ($userBalance['metals'] as $k => $balance) {
            $userMetalBalances[$i]['metalName'] = $k;
            $userMetalBalances[$i]['total'] = $balance;
            $i++;
        }
        $i = count($userMetalBalances);
        foreach ($metals as $metal) {
            $exist = 0;
            foreach ($userMetalBalances as $balance) {
                if ($exist != 1 && $balance['metalName'] == $metal->name) {
                    $exist = 1;
                }
            }
            if ($exist != 1) {
                $userMetalBalances[$i]['metalName'] = $metal->name;
                $userMetalBalances[$i]['total'] = 0;
                $i++;
            }
        }
    }
@endphp

@section('content')
    @include('header.utils')

    <div class="page-container container funds-container">
        @if (
            $totalcashs['CAD'] > 0 ||
                $totalcashs['USD'] > 0 ||
                $totalcashs['EUR'] > 0 ||
                $totalmetals['Gold'] > 0 ||
                $totalmetals['Silver'] > 0 ||
                $totalmetals['Platinum'] > 0 ||
                $totalmetals['Palladium'] > 0)
            <div class="row">
                <div class="col-12 text-right">
                    <br>
                    <span class="show-my-funds-chart">&#8681;</span>
                    <br><br>
                </div>
            </div>

            <div id="my-balance-chart" class="row bg-white">
                <div class="col-12 col-md-9">
                    <div id="piechart_3d" style="width: 100%; height: auto;"></div>
                </div>
                <div class="d-none d-md-flex col-3">
                    <p class="holding">Account Holding: <br> <b>$<?= number_format($totalcashs[$currency->code], 2) ?>
                            <?= $currency->code ?></b></p>
                </div>
            </div>

            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load("current", {
                    packages: ["corechart"]
                });
                google.charts.setOnLoadCallback(chart - interval);

                function chart - interval() {
                    var data = google.visualization.arrayToDataTable([
                        ['Fund', 'Balance'],
                        ['USD', {{ $totalcashs['USD'] }}],
                        ['CAD', {{ $totalcashs['CAD'] }}],
                        ['EUR', {{ $totalcashs['EUR'] }}],
                        ['Gold', {{ $totalmetals['Gold'] }}],
                        ['Silver', {{ $totalmetals['Silver'] }}],
                        ['Platinum', {{ $totalmetals['Platinum'] }}],
                        ['Palladium', {{ $totalmetals['Palladium'] }}]
                    ]);

                    var options = {
                        title: 'Balance Breakdown',
                        pieHole: 0.7,
                        tooltip: {
                            trigger: 'none'
                        },
                        pieSliceText: 'none',
                        pieSliceTextStyle: {
                            fontSize: 12
                        },
                        legend: {
                            position: 'labeled'
                        }
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                    chart.draw(data, options);
                }
            </script>
        @endif

        {{-- Mobile --}}
        @include('funds.mobile')

        {{-- Desktop --}}
        @include('funds.desktop')

    </div>
@endsection
