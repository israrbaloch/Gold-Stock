@extends('header.index')

@php
    $excluded_slugs = ['gold', 'silver', 'platinum', 'palladium'];
@endphp

@push('styles')
    <link href="{{ URL::to('/') }}/css/deposit.css?ver=1.2.0" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ URL::to('/') }}/js/deposit.js?ver=1.2.0"></script>
@endpush

@section('content')
    <div class="page-container container">
        <div class="title-page-1">Deposit</div>
        <div class="coins-container" style="margin-top: 20px;">
            <div id="imaginary_container">
                <div class="input-group stylish-input-group">
                    <input id="search-field" type="text" class="form-control makeup-input" placeholder="Search">
                </div>
            </div>
            <br>
            <div class="gray-bar"></div>
            <div class="cash-container" data-name="usd">

                <a href="/deposit-cash?currency=USD">USD <span class="coin-name">(USD Cash)</span></a>
            </div>
            <div class="cash-container" data-name="cad">

                <a href="/deposit-cash?currency=CAD">CAD <span class="coin-name">(CAD Cash)</span></a>
            </div>
            <div class="cash-container" data-name="eur">

                <a href="/deposit-cash?currency=EUR">EUR <span class="coin-name">(EUR Cash)</span></a>
            </div>
            @foreach ($metals as $metal)
                <div class="coin-container" data-code="<?= $metal['name'] ?>" data-name="<?= $metal['name'] ?>">

                    <a href="/deposit-coin?product_id=<?= $metal['id'] ?>" data-id="<?= $metal['id'] ?>">
                        <?= $metal['name'] ?> <span class="coin-name">(<?= $metal['name'] ?>)</span>
                    </a>
                </div>
            @endforeach

            <div class="gray-bar"></div>

        </div>

        <br>
    </div>
@endsection
