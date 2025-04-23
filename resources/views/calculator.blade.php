@extends('header.index')

@push('styles')
    <link href="{{ URL::to('/') }}/css/calculator.css?ver=1.0.0" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ URL::to('/') }}/js/calculator.js?ver=1.0.0"></script>
@endpush

@section('content')
    <div class="page-container container">
        <div class="row g-0">
            @php
                $data = [];

                $asset_code_array = ['gold', 'silver', 'platinum', 'palladium'];
                $metal_names_array = [
                    'gold' => 'Gold',
                    'silver' => 'Silver',
                    'platinum' => 'Platinum',
                    'palladium' => 'Palladium',
                ];

                foreach ($asset_code_array as $ac) {
                    $data[$ac] = $prices[$ac];
                }

                $calc_minus_value = $calc_minus_percent / 100;

                $counter = 0;

            @endphp

            <div class="row g-0 head-info color-white">
                <div class="col-12 text-center">
                    Scrap Calculator
                </div>
            </div>

            <div class="row g-0">
                <div class="col-3 color-table-1 text-center text-bold metal-title">
                    Metal
                </div>
                <div class="col-3 color-table-1 text-center text-bold metal-title">
                    Weight (g)
                </div>
                <div class="col-3 color-table-1 text-center text-bold metal-title">
                    Purity (%)
                </div>
                <div class="col-3 color-table-1 text-center text-bold metal-title">
                    Total
                </div>
            </div>

            <input type="hidden" id="minus-value" name="minus-value" value="<?= $calc_minus_value ?>">
            <input type="hidden" id="active-currency" name="active-currency" value="<?= $active_currency ?>">

            <?php foreach($data as $key => $info) {  $counter++;?>
            <div class="row g-0">
                <div
                    class="col-3 text-center text-bold metal-title-2 color-table-<?= strtolower($metal_names_array[$key]) ?>">
                    <?= $metal_names_array[$key] ?>
                </div>
                <div class="col-3 text-center text-bold metal-content <?php if(1==1){ ?>color-table-1<?php } ?>">
                    <input id="weight-<?= strtolower($key) ?>" type="number"
                        class="calc-field form-control makeup-input-clear" placeholder="" style="width: 100%"
                        data-metal="<?= strtolower($key) ?>" data-buying-kilo="<?= $info['buyingkilo'] ?>">
                </div>
                <div class="col-3 text-center text-bold metal-content <?php if(1==1){ ?>color-table-1<?php } ?>">
                    <input id="purity-<?= strtolower($key) ?>" type="number"
                        class="calc-field form-control makeup-input-clear" placeholder="" style="width: 100%"
                        data-metal="<?= strtolower($key) ?>" data-buying-kilo="<?= $info['buyingkilo'] ?>">
                </div>
                <div class="col-3 text-center text-bold metal-title-2 <?php if(1==1){ ?>color-table-1<?php } ?>">
                    <span class="result-<?= strtolower($key) ?>"></span>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
@endsection
