@extends('header.index')

@section('extratitle')
    Live Prices
@endsection

@push('styles')
    <link href="{{ URL::to('/') }}/css/liveprices.css?ver=1.3.0" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.1.0/apexcharts.min.css"
        integrity="sha512-P/8zp3yWsYKLYgykcnVdWono7iWa9VXcoNLFnUhC82oBjt/6z5BIHXTQsMKBgYJjp6K+JAkt4yrID1cxfoUq+g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ URL::to('/') }}/js/liveprices.js?ver=1.3.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.1.0/apexcharts.min.js"
        integrity="sha512-pX8wly6uaNHjO2Idm8xpq7Fu52iU/F3IK2rS8vTUlw7138ZsDCgfljwotyOpQxycTqK4MryB4Pv7ArDmzx7sPQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var options = {
            series: [{
                name: 'Gold',
                data: JSON.parse("{{ $goldSeries }}")
            }, {
                name: 'Silver',
                data: JSON.parse("{{ $silverSeries }}")
            }, {
                name: 'Platinum',
                data: JSON.parse("{{ $platinumSeries }}")
            }, {
                name: 'Palladium',
                data: JSON.parse("{{ $palladiumSeries }}")
            }],
            colors: ['#FFCC00', '#12b68d', '#5856D6', '#FF2D55'],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight',
                width: 2
            },
            grid: {
                show: true, // Enable grid
                borderColor: '#e0e0e0', // Grid line color
                strokeDashArray: 0, // Solid grid lines
                xaxis: {
                    lines: {
                        show: true // Show vertical grid lines
                    }
                },
                yaxis: {
                    lines: {
                        show: true // Show horizontal grid lines
                    }
                }
            },
            xaxis: {
                categories: ['1 year', '6 months', '1 month', '1 week', 'today'],
                labels: {
                    show: true,
                    style: {
                        colors: ['#999', '#999', '#999', '#999', '#999'],
                        fontSize: '12px',
                        fontFamily: undefined,
                        fontWeight: 400,
                        cssClass: 'apexcharts-xaxis-label',
                    },
                },
            },
            yaxis: {
                // min: -1000,
                labels: {
                    // show: false,
                    formatter: function(val) {
                        // return '$' + val;
                        return val.toFixed(2);
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return '$' + val.toFixed(2);
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'center'
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endpush

@php
    $data = [];
    $asset_code_array = ['gold', 'silver', 'platinum', 'palladium'];
    $last_refreshed = date('h:i:sa') . ' ' . date('Y/m/d');
    $possibleImgs = ['CAD' => 'CAD.png', 'USD' => 'USA.png', 'EUR' => 'EUR.png'];
    $currencies = ['CAD', 'USD', 'EUR'];
@endphp

@section('content')
    <section class="live-prices-section desktop d-md-block d-none">
        <div class="container">
            <h2 class="section-title text-center mb-5">
                Live Prices
            </h2>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="currency-switcher">
                    <span>Currency:</span>
                    {{-- <a href="#" class="text-warning fw-bold ms-2">CAD</a>
                    <a href="#" class="text-muted fw-normal ms-2">USD</a>
                    <a href="#" class="text-muted fw-normal ms-2">EUR</a> --}}

                    @foreach ($currencies as $c)
                        <a href="#" class="ms-2 currency-trigger {{ $loop->first ? 'active' : '' }}"
                            data-currency="<?= $c ?>"><?= $c ?></a>
                    @endforeach
                    <input type="hidden" id="active-currency" name="active-currency" value="<?= $currencies[0] ?>">

                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Metal</th>
                            <th>Spot Bid</th>
                            <th>Spot Ask</th>
                            <th>Selling (Ounce)</th>
                            <th>Buying (Ounce)</th>
                            <th>Selling (Kilo)</th>
                            <th>Buying (Kilo)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="d-flex align-items-center">
                                <img src="{{ asset('img/section-5-1.png') }}" alt="gold" class="me-2 table-metal" />
                                Gold
                                <span
                                    class="arrow gold-arrow {{ $prices['gold']['change_percent'] > 0 ? 'up' : 'down' }}"></span>
                            </td>
                            <td>
                                $<span class="gold-bid">{{ number_format($prices['gold']['bid'], 2) }}</span>
                            </td>
                            <td>$<span class="gold-ask">{{ number_format($prices['gold']['ask'], 2) }}</span></td>
                            <td>$<span
                                    class="gold-selling-ounce">{{ number_format($prices['gold']['sellingounce'], 2) }}</span>
                            </td>
                            <td>$<span
                                    class="gold-buying-ounce">{{ number_format($prices['gold']['buyingounce'], 2) }}</span>
                            </td>
                            <td>$<span
                                    class="gold-selling-kilo">{{ number_format($prices['gold']['sellingkilo'], 2) }}</span>
                            </td>
                            <td>$<span
                                    class="gold-buying-kilo">{{ number_format($prices['gold']['buyingkilo'], 2) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="d-flex align-items-center">
                                <img src="{{ asset('img/section-5-2.png') }}" alt="silver" class="me-2 table-metal" />
                                Silver
                                <span
                                    class="arrow silver-arrow {{ $prices['silver']['change_percent'] > 0 ? 'up' : 'down' }}"></span>
                            </td>
                            <td>$<span class="silver-bid">{{ number_format($prices['silver']['bid'], 2) }}</span></td>
                            <td>$<span class="silver-ask">{{ number_format($prices['silver']['ask'], 2) }}</span></td>
                            <td>$<span
                                    class="silver-selling-ounce">{{ number_format($prices['silver']['sellingounce'], 2) }}</span>
                            </td>
                            <td>$<span
                                    class="silver-buying-ounce">{{ number_format($prices['silver']['buyingounce'], 2) }}</span>
                            </td>
                            <td>$<span
                                    class="silver-selling-kilo">{{ number_format($prices['silver']['sellingkilo'], 2) }}</span>
                            </td>
                            <td>$<span
                                    class="silver-buying-kilo">{{ number_format($prices['silver']['buyingkilo'], 2) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="d-flex align-items-center">
                                <img src="{{ asset('img/section-5-3.png') }}" alt="platinium" class="me-2 table-metal" />
                                Platinum
                                <span
                                    class="arrow platinum-arrow {{ $prices['platinum']['change_percent'] > 0 ? 'up' : 'down' }}"></span>
                            </td>
                            <td>$<span class="platinum-bid">{{ number_format($prices['platinum']['bid'], 2) }}</span></td>
                            <td>$<span class="platinum-ask">{{ number_format($prices['platinum']['ask'], 2) }}</span></td>
                            <td>$<span
                                    class="platinum-selling-ounce">{{ number_format($prices['platinum']['sellingounce'], 2) }}</span>
                            </td>
                            <td>$<span
                                    class="platinum-buying-ounce">{{ number_format($prices['platinum']['buyingounce'], 2) }}</span>
                            </td>
                            <td>$<span
                                    class="platinum-selling-kilo">{{ number_format($prices['platinum']['sellingkilo'], 2) }}</span>
                            </td>
                            <td>$<span
                                    class="platinum-buying-kilo">{{ number_format($prices['platinum']['buyingkilo'], 2) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="d-flex align-items-center">
                                <img src="{{ asset('img/section-5-4.png') }}" alt="palladium" class="me-2 table-metal" />
                                Palladium
                                <span
                                    class="arrow palladium-arrow {{ $prices['palladium']['change_percent'] > 0 ? 'up' : 'down' }}"></span>
                            </td>
                            <td>$<span class="palladium-bid">{{ number_format($prices['palladium']['bid'], 2) }}</span>
                            </td>
                            <td>$<span class="palladium-ask">{{ number_format($prices['palladium']['ask'], 2) }}</span>
                            </td>
                            <td>$<span
                                    class="palladium-selling-ounce">{{ number_format($prices['palladium']['sellingounce'], 2) }}</span>
                            </td>
                            <td>$<span
                                    class="palladium-buying-ounce">{{ number_format($prices['palladium']['buyingounce'], 2) }}</span>
                            </td>
                            <td>$<span
                                    class="palladium-selling-kilo">{{ number_format($prices['palladium']['sellingkilo'], 2) }}</span>
                            </td>
                            <td>$<span
                                    class="palladium-buying-kilo">{{ number_format($prices['palladium']['buyingkilo'], 2) }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="live-prices-section mobile d-md-none d-block">
        <div class="container">
            <h2 class="section-title text-center mb-5">
                Live Prices
            </h2>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="currency-switcher">
                    <span>Currency:</span>
                    @foreach ($currencies as $c)
                        <a href="#" class="ms-2 currency-trigger {{ $loop->first ? 'active' : '' }}"
                            data-currency="<?= $c ?>"><?= $c ?></a>
                    @endforeach
                    <input type="hidden" id="active-currency" name="active-currency" value="<?= $currencies[0] ?>">
                </div>
            </div>

            <!-- Mobile View Table -->
            <div class="d-block d-md-none">
                @foreach (['gold', 'silver', 'platinum', 'palladium'] as $metal)
                    <table class="table table-bordered mb-4">
                        <thead class="table-light">
                            <tr>
                                <th colspan="2" class="text-center">
                                    <span class="d-flex">
                                        <img src="{{ asset('img/section-5-' . ($loop->index + 1) . '.png') }}"
                                            alt="{{ $metal }}" class="me-2 table-metal my-auto" />
                                        <span class="my-auto">{{ ucfirst($metal) }}</span>
                                        <span
                                            class="my-auto arrow {{ $metal }}-arrow {{ $prices[$metal]['change_percent'] > 0 ? 'up' : 'down' }}"></span>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Spot Bid</td>
                                <td>$<span
                                        class="{{ $metal }}-bid">{{ number_format($prices[$metal]['bid'], 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Spot Ask</td>
                                <td>$<span
                                        class="{{ $metal }}-ask">{{ number_format($prices[$metal]['ask'], 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Selling (Ounce)</td>
                                <td>$<span
                                        class="{{ $metal }}-selling-ounce">{{ number_format($prices[$metal]['sellingounce'], 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Bullying (Ounce)</td>
                                <td>$<span
                                        class="{{ $metal }}-buying-ounce">{{ number_format($prices[$metal]['buyingounce'], 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Selling (Kilo)</td>
                                <td>$<span
                                        class="{{ $metal }}-selling-kilo">{{ number_format($prices[$metal]['sellingkilo'], 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Bullying (Kilo)</td>
                                <td>$<span
                                        class="{{ $metal }}-buying-kilo">{{ number_format($prices[$metal]['buyingkilo'], 2) }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    </section>


    <section class="chart-section">
        <div class="container">
            <h2 class="section-title text-center mb-5">Price change (<span class="currency">{{$currency}}</span>/oz)</h2>

            <div class="col-lg-7 mx-auto">
                <div id="chart"></div>
            </div>
        </div>
    </section>

    <section class="gold-silver-ratio">
        <div class="container">
            <h2 class="section-title text-center mb-5">
                Gold Silver Ratio
            </h2>

            <div class="col-lg-8 mx-auto">
                <div class="table-responsive" id="ratioTableMain">
                    <table class="table table-bordered text-center align-middle" id="ratioTable">
                        <thead class="table-light">
                            <tr>
                                <th>Current</th>
                                <th>High</th>
                                <th>low</th>
                                <th>Change</th>
                            </tr>
                        </thead>
                        @php
                            // dd($prices);
                            $current_ratio = $prices['gold']['current_value'] / $prices['silver']['current_value'];

                            $ratioDiff = $oldRatio - $current_ratio;
                            $ratioPercentage = ($ratioDiff / $oldRatio) * 100;

                            $gold_silver_ratio = [
                                'current' => $current_ratio,
                                'high' => $prices['gold']['highest'] / $prices['silver']['highest'],
                                'low' => $prices['gold']['lowest'] / $prices['silver']['lowest'],
                            ];
                        @endphp
                        <tbody>
                            <tr>
                                <td>
                                    <span
                                        class="gold-silver-ratio-current fw-normal">{{ number_format($gold_silver_ratio['current'], 2) }}</span>
                                </td>
                                <td>
                                    <span
                                        class="gold-silver-ratio-high">{{ number_format($gold_silver_ratio['high'], 2) }}</span>
                                </td>
                                <td>
                                    <span
                                        class="gold-silver-ratio-low">{{ number_format($gold_silver_ratio['low'], 2) }}</span>
                                </td>
                                <td>
                                    <span class="gold-silver-ratio-change">
                                        <span
                                            class="{{ $ratioDiff > 0 ? 'text-success' : ($ratioDiff < 0 ? 'text-danger' : '') }}">{{ number_format($ratioDiff, 3) }}</span>
                                        <span
                                            class="{{ $ratioPercentage > 0 ? 'text-success' : ($ratioPercentage < 0 ? 'text-danger' : '') }}">({{ number_format($ratioPercentage, 2) }}%)</span>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <section class="portfolio-calculator">
        <div class="container">
            <h2 class="section-title text-center mb-5">Simple Portfolio Calculator</h2>

            <p class="mb-4">Please enter the item's purchase price and select the metal type:</p>

            <div class="col-lg-8 mx-auto form-container">
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <label for="purchasePrice" class="form-label me-3" style="width: 50%;">Purchase
                                Price:</label>
                            <input type="number" class="form-control" id="purchasePrice" placeholder="0.00">
                            <span class="ms-2">oz</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <label for="metalType" class="form-label me-3" style="width: 50%;">Metal Type:</label>
                            <select class="form-select" id="metalType">
                                <option value="gold">Gold</option>
                                <option value="silver">Silver</option>
                                <option value="platinum">Platinum</option>
                                <option value="palladium">Palladium</option>
                            </select>
                        </div>
                    </div>
                </div>

                <p class="my-5">Here's your portfolio change:</p>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <label for="todayPrice" class="form-label me-3" style="width: 50%;">Today's Price:</label>
                            <input type="text" class="form-control" id="todayPrice" placeholder="0.00" disabled>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <label for="portfolioGain" class="form-label me-3" style="width: 50%;">Portfolio
                                Gain:</label>
                            <input type="text" class="form-control" id="portfolioGain" placeholder="0.00%" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('home.news_2')



    <div class="container page-container d-none">
        <div class="row head-info color-white">
            <div class="col-12 col-md-6 text-center">
                <div class="row g-0 last-refreshed-cont">
                    <div class="col-5 col-md-4 text-left">
                        Last Refreshed at:
                    </div>
                    <div class="col-7 text-right text-md-left">
                        <span class="last-refreshed text-bold"><?= $last_refreshed ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row head-info color-white">
            <div class="col-12 col-md-4 text-center">
                <div class="row g-0">
                    <div class="col-6 text-right">
                        US Rate:
                    </div>
                    <div class="col-6 text-left">
                        &nbsp;&nbsp;<span class="us-rate-value"><?= $rate->us_rate ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 text-center">
                <div class="row g-0">
                    <div class="col-6 text-right">
                        CAD Rate:
                    </div>
                    <div class="col-6 text-left">
                        &nbsp;&nbsp;<span class="cad-rate-value"><?= $rate->cad_rate ?></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 text-center">
                <div class="row g-0">
                    <div class="col-6 text-right">
                        EUR Rate:
                    </div>
                    <div class="col-6 text-left">
                        &nbsp;&nbsp;<span class="eur-rate-value"><?= $rate->eur_rate ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
