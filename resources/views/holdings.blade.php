@extends('header.index')

@push('styles')
    <link href="{{ URL::to('/') }}/css/coin-details.css?ver=1.2.0" rel="stylesheet">
@endpush


@section('content')
    <div class="page-container container">
        <div class="title-page-1 text-center">{{ $metal }}</div>
        <div class="title-page-2 text-center">{{ $metal }} Holdings</div>
        <br class="d-none d-md-block"><br class="d-none d-md-block">
        <div class="desktop">
            <div class="row">
                <div class="col-12 col-md-6 pe-md-4">
                    <div class="marked first">
                        <div class="row">
                            <div class="col-6 text-left text-bold">
                                Total
                            </div>
                            <div class="col-6 text-right">
                                <?= number_format($total, 5) ?>oz
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-left text-bold">
                                Available
                            </div>
                            <div class="col-6 text-right">
                                <?= number_format($total, 5) ?>oz
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-left text-bold">
                                In Order
                            </div>
                            <div class="col-6 text-right">
                                0
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 ps-md-4">
                    <div class="marked second">
                        <div class="row">
                            <div class="col-6 text-left text-bold">
                                Estimated USD
                            </div>
                            <div class="col-6 text-right">
                                $<?= number_format($value['USD'], 2) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-left text-bold">
                                Estimated CAD
                            </div>
                            <div class="col-6 text-right">
                                $<?= number_format($value['CAD'], 2) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-left text-bold">
                                Estimated EUR
                            </div>
                            <div class="col-6 text-right">
                                $<?= number_format($value['EUR'], 2) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row upper-block-sec">
                <div class="row justify-content-between">
                    <div class="row m-0 justify-content-between">
                        <div class="col-12 d-none d-md-block text-left go-to-txt color-dark-green">
                            <b>Go To Trade</b>
                        </div>
                        <div class="col-12 d-none d-md-block">
                            <br><br><br>
                        </div>
                        <div class="col-4 text-center">
                            <a href="/exchange">
                                <div data-currency="CAD" class="go-x makeup-btn-dark-gold">XAU/CAD</div>
                            </a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="/exchange">
                                <div data-currency="USD" class="go-x makeup-btn-dark-gold">XAU/USD</div>
                            </a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="/exchange">
                                <div data-currency="EUR" class="go-x makeup-btn-dark-gold">XAU/EUR</div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <br><br>
            <div class="row justify-content-between">
                <div class="col-6 text-center">
                    <a href="/deposit-coin"
                        class="btn btn-info btn-holding dep dps-button makeup-btn-dark-green"><span>Deposit</span></a>
                </div>
                <div class="col-6 text-center">
                    <a href="/convert-to-physical?metal={{ $metal }}"
                        class="btn btn-info btn-holding dps-button makeup-btn-red">convert physical</a>
                </div>
            </div>
            <br><br>
        </div>
    </div>
@endsection
