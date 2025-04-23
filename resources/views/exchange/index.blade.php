@extends('header.index')

@php
    $cashBalance = $_userBalances['cash'];
    $footer = false;
@endphp

@section('extratitle')
    @if (isset($currentMetal) != null)
        Exchange {{ ucfirst($currentMetal) }}
    @else
        Exchange
    @endif
@endsection

@push('styles')
    <link href="{{ URL::to('/') }}/css/exchange.css?ver=1.0.0" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" /> --}}
@endpush

@push('scripts')
    <script type="text/javascript"
        src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>

    <script src="{{ asset('/js/exchange/index.js') }}"></script>

    <script>
        window.app.metal = @json($_metal);
        window.app.currentMetal = @json($_currentMetal);
        window.app.ask = @json($_ask);
        window.app.bid = @json($_bid);

        const candles = {};
        @foreach ($_candles as $k => $v)
            candles['{{ $k }}'] = @json($v);
        @endforeach
        window.app.exchange = {};
        window.app.exchange.candles = candles;
    </script>

    <script>
        // if session has alert_created then swl
        @if (session('alert_created'))
            Swal.fire({
                icon: 'success',
                title: '{{ session('alert_created') }}',
                text: 'You will be notified when the price reaches the specified value.',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>
@endpush

@section('content')
    @include('header.utils')
    <div class="container exchange-container">
        @if (isset($_metal) != null)
            <input type="hidden" id="currentMetal" value="{{ $_metal }}" />
        @endif

        <div class="chart-container desktop">
            <div class="metal-container">
                <div class="coin-container">
                    <div class="image-container">
                        <img class="exchange-coin-icon" src="{{ asset('img/' . $_metal . '.png') }}">
                    </div>
                    @include('exchange.header')
                </div>

                @include('exchange.details')

                <div class="options-container">
                    <div class="option">
                        <button type="button" class="button small clean" data-option="chart">Chart</button>
                    </div>
                    <div class="option">
                        <button type="button" class="button small clean" data-option="metals">Metal/Currency</button>
                    </div>
                    <div class="option">
                        <button type="button" class="button small clean" data-option="currencies">Currencies</button>
                    </div>
                    <div class="option">
                        <button type="button" class="button small clean" data-option="trade">Trade History</button>
                    </div>
                </div>
            </div>

            <div class="section">

                <div class="left-container">
                    <div class="metals">
                        <div class="group-container">
                            <div class="group-title">
                                Metal/Currency
                            </div>
                            @include('exchange.metal-currency')
                        </div>
                    </div>
                    <div class="currencies">
                        <div class="group-container">
                            <div class="group-title">
                                Currencies
                            </div>
                            @include('exchange.currencies')
                        </div>
                    </div>
                </div>

                <div class="chart-container active">
                    <div class="group-container">
                        <div class="group-title">
                            History Chart
                        </div>
                        @include('exchange.chart.index')
                    </div>
                </div>

                <div class="right-container">
                    <div class="trade">
                        <div class="group-container">
                            <div class="group-title">
                                Trade history
                            </div>
                            <div class="trade-history" class="values">
                                @foreach ($_ask as $ask)
                                    <div class="trade-container">
                                        <div class="text-left ask">{{ addCommas($ask * $_currencyRate) }}</div>
                                        <div class="text-right bid">{{ addCommas($_bid[$loop->index] * $_currencyRate) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
