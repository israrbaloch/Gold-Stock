<div class="d-none d-md-block">
    <div id="to-scroll" class="row">

        <table class="table metals">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>24H Change</th>
                    <th>24H High</th>
                    <th>24H Low</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prices as $priceId => $price)
                    <tr id="desktop-metal-{{ $priceId }}" class="option {{ $priceId == $get_id ? 'active' : '' }}"
                        data-id="{{ $priceId }}">
                        <td>
                            {{ $metals[$priceId] }}/{{ $currency }}
                        </td>
                        <td>
                            $ <span>{{ number_format($price['bfakeprice'], 2) }}</span>
                        </td>
                        <td
                            class="{{ $price['change_percent'] > 0 ? 'high' : '' }} {{ $price['change_percent'] < 0 ? 'low' : '' }}">
                            <span>{{ number_format($price['change_percent'], 2) }}%</span>
                        </td>
                        <td>
                            $ <span>{{ number_format($price['highest'], 2) }}</span>
                        </td>
                        <td>
                            $ <span>{{ number_format($price['lowest'], 2) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="chart">
            <div class="metal-container">
                <div class="coin-container">
                    <div class="image-container">
                        <img id="exchangeMetalIcon" class="thumby-big" width="40px">
                    </div>
                    <div class="description-container">
                        <div class="title">
                            <span id="exchangeMetalTitle"></span>/{{ $currency }}
                        </div>
                    </div>
                </div>
                <div class="details-container">
                    <div class="detail">
                        <div class="subtitle">
                            Price
                        </div>
                        <div class="title">
                            $ <span id="exchangeMetalPrice"></span>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="subtitle">
                            24h change
                        </div>
                        <div class="title">
                            <span id="exchangeMetal24Change"></span>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="subtitle">
                            24h high
                        </div>
                        <div class="title">
                            $ <span id="exchangeMetal24High"></span>
                        </div>
                    </div>
                    <div class="detail">
                        <div class="subtitle">
                            24h low
                        </div>
                        <div class="title">
                            $ <span id="exchangeMetal24Low">{{ number_format($price['lowest'], 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="values col-md-5">
                    <div class="prices">
                        <div class="title">
                            Trade history
                        </div>
                        <div id="trade-history-table" class="metals">
                            <span>loading...</span>
                        </div>
                    </div>

                    <div class="prices">
                        <div class="title">
                            <div class="col-6 text-left">Spot Price Per Ounce</div>
                            <div class="col-6 text-right">Price</div>
                        </div>
                        <div id="prices-history-table" class="metals">
                            <span>Loading...</span>
                        </div>
                    </div>
                </div>

                <div class="chart col-md-7">
                    <div class="row title">
                        <div class="col-6 text-left">History Chart</div>
                        <div class="col-6 text-right"></div>
                    </div>
                    <br>
                    <div id="chart-top-bar" class="row g-0">
                        <button type="button" class="btn btn-light drawchart interval-btn col-2"
                            data-inteval="15">15M</button>
                        <button type="button" class="btn drawchart interval-btn col-2" data-inteval="60">1H</button>
                        <button type="button" class="btn drawchart interval-btn col-2" data-inteval="360">6H</button>
                        <button type="button" class="btn drawchart interval-btn col-2" data-inteval="1440">1D</button>
                        <button type="button" class="btn drawchart interval-btn col-2" data-inteval="10080">1W</button>
                        <button type="button" class="btn drawchart interval-btn col-2" data-inteval="43200">1M</button>
                    </div>
                    <br>
                    <div>
                        <img class="loader-img" src="{{ '/img/loader.gif' }}" />
                    </div>
                    <div id="chart_div" style="width: 100%; height: 500px;" class="color-gold">

                    </div>
                    <div class="loading-prices">
                        <span>Updating Prices...</span>
                    </div>
                    <div id="desk-exchange-actions" class="exchange-buttons-container buttons-container row g-0"
                        style="display: none">
                        <div class="col-6">
                            <button type="button" class="btn btn-sell-sp btn-action" disabled id="button-sell">
                                SELL
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-buy-sp btn-action" disabled id="button-buy">
                                BUY
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <br><br>
    <div class="row">
    </div>

    <div id="sell-modal" class="modal-container">
        <div id="trade-section">
            <div class="exchange-modal">

                {{-- <button type="button" id="modal-close" class="modal-close" aria-label="x"></button> --}}


                <div class="title">
                    Sell {{ $metals[$priceId] }}/{{ $currency }}
                </div>

                <div class="sell-section operation">
                    <br class="d-md-none">
                    <br class="d-md-none">
                    <br class="d-md-none">
                    {{-- <div class="row equal-height">
                        <div class="col-6 color-yellow text-bold">
                            Sell <span class="active-metal-name">{{ $get_name }}</span>
                        </div>
                        <div class="col-6 text-right color-yellow">
                            <span class="available-metal-value text-bold"></span>/oz <span
                                class="metal-code text-bold">BTC</span>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="green-top"></div>
                        </div>
                    </div>
                    <br>

                    <div class="row trade-table-row">
                        <span>Price:</span>
                        <input class="text-right text-bold metal-price new" disabled />
                    </div>

                    <div class="row trade-table-row">
                        <span>Amount:</span>
                        <div class="input-container">
                            <input id="transaction-amount-fake"
                                class="text-right metal-amount-fake makeup-input input-with-unit"
                                data-real-class="metal-amount" type="number" value="1" />
                            <input id="transaction-amount" type="hidden"
                                class="text-right metal-amount makeup-input input-with-unit" value="1" />
                            <span class="input-unit">/oz</span>
                        </div>
                    </div>
                    <br>
                    <div class="row trade-table-row">
                        <div class="col-12 col-md-9 offset-md-3">
                            <div class="row g-0">
                                <div class="col-3">
                                    <a class="btn percent-trigger" data-val="0.25" data-type="sell">25%</a>
                                </div>
                                <div class="col-3" style="padding-left: 2.5%;">
                                    <a class="btn percent-trigger" data-val="0.5" data-type="sell">50%</a>
                                </div>
                                <div class="col-3" style="padding-left: 2.5%;">
                                    <a class="btn percent-trigger" data-val="0.75" data-type="sell">75%</a>
                                </div>
                                <div class="col-3" style="padding-left: 2.5%;">
                                    <a class="btn percent-trigger" data-val="1" data-type="sell">100%</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row trade-table-row">
                        <div class="col-3 text-left text-cap">
                            Total:
                        </div>
                        <div class="col-9 total-price-container">
                            <input class="text-right total-price-fake" data-real-class="total-price" />
                            <input type="hidden" class="text-right total-price" />
                        </div>
                    </div>
                    <br>
                    <div class="row trade-table-row">
                        <div class="col-4">
                            <a href="#" class="btn cancel" id="cancel-sell">Cancel</a>
                        </div>
                        <div class="col-8">
                            <a href="#" class="btn sell">Sell</a>
                        </div>
                    </div>
                    <br>
                </div>


            </div>
        </div>
    </div>

    <div id="buy-modal" class="modal-container">
        <div id="trade-section">
            <div class="exchange-modal">
                <div class="title">
                    Buy <span class="active-metal-name">{{ $get_name }}</span>
                </div>

                <div class="sell-section operation">
                    <br class="d-md-none">
                    <br class="d-md-none">
                    <br class="d-md-none">
                    {{-- <div class="row equal-height">
                        <div class="col-6 color-yellow text-bold">
                            Sell <span class="active-metal-name">{{ $get_name }}</span>
                        </div>
                        <div class="col-6 text-right color-yellow">
                            <span class="available-metal-value text-bold"></span>/oz <span
                                class="metal-code text-bold">BTC</span>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="green-top"></div>
                        </div>
                    </div>
                    <br>

                    <div class="row trade-table-row">
                        <span>Price:</span>
                        <input class="text-right text-bold metal-price new" disabled />
                    </div>

                    <div class="row trade-table-row">
                        <span>Amount:</span>
                        <div class="input-container">
                            <input id="transaction-amount-fake"
                                class="text-right metal-amount-fake makeup-input input-with-unit"
                                data-real-class="metal-amount" type="number" value="1" />
                            <input id="transaction-amount" type="hidden"
                                class="text-right metal-amount makeup-input input-with-unit" value="1" />
                            <span class="input-unit">/oz</span>
                        </div>
                    </div>

                    <br>
                    <div class="row trade-table-row">
                        <div class="col-12 col-md-9 offset-md-3">
                            <div class="row g-0">
                                <div class="col-3">
                                    <a class="btn percent-trigger" data-val="0.25" data-type="buy">25%</a>
                                </div>
                                <div class="col-3" style="padding-left: 2.5%;">
                                    <a class="btn percent-trigger" data-val="0.5" data-type="buy">50%</a>
                                </div>
                                <div class="col-3" style="padding-left: 2.5%;">
                                    <a class="btn percent-trigger" data-val="0.75" data-type="buy">75%</a>
                                </div>
                                <div class="col-3" style="padding-left: 2.5%;">
                                    <a class="btn percent-trigger" data-val="1" data-type="buy">100%</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row trade-table-row">
                        <div class="col-3 text-left text-cap">
                            Total:
                        </div>
                        <div class="col-9 total-price-container">
                            <input class="text-right buy-total-price total-price-fake text-bold color-yellow"
                                data-real-class="total-price">
                            <input type="hidden"
                                class="text-right buy-total-price total-price text-bold color-yellow">
                        </div>
                    </div>
                    <br>
                    <div class="row trade-table-row">
                        <div class="col-4">
                            <a href="#" class="btn cancel" id="cancel-buy">Cancel</a>
                        </div>
                        <div class="col-8">
                            <a href="#" class="btn buy">Buy</a>
                        </div>
                    </div>
                    <br>
                </div>


            </div>
        </div>
    </div>

    {{-- Trade Section --}}
    {{-- <div id="trade-section">
        <div class="modal fade exchange-modal" id="buy-modal"
            style="background-image: url('{{ '/img/exchange-bg.jpg' }}'); background-repeat: repeat;">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="x"></button>
            <div class="modal-dialog">
                <div class="modal-content"
                    style="background-image: url('{{ '/img/exchange-bg.jpg' }}'); background-repeat: repeat;">
                    <br>
                    <div id="left-trade-section" class="buy-section operation">
                        <div class="row equal-height">
                            <div class="col-6 color-yellow text-bold">
                                Buy <span class="active-metal-name">{{ $get_name }}</span>
                            </div>
                            <div class="col-6 text-right color-yellow text-bold">
                                <span>$
                                    {{ Auth::check() && $cashBalance > 0 ? number_format($cashBalance, 2) : 0 }}</span>
                                {{ $currency }}</span>
                                <input type="hidden" id="cash-funds-value" name="cash-funds-value"
                                    value="{{ $cashBalance }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="green-top"></div>
                            </div>
                        </div>
                        <br>
                        <div class="row trade-table-row">
                            <div class="col-3 text-left text-cap">
                                Price:
                            </div>
                            <div class="col-9">
                                <input class="text-right text-bold metal-price new disabled" disabled />
                            </div>
                        </div>
                        <br>
                        <div class="row trade-table-row">
                            <div class="col-3 text-left taskete text-cap">
                                Amount:
                            </div>
                            <div class="col-9 relative">
                                <input class="text-right metal-amount-fake makeup-input input-with-unit"
                                    data-real-class="metal-amount" value="1" />
                                <input type="hidden" class="text-right metal-amount makeup-input input-with-unit"
                                    value="1" />
                                <span class="input-unit">/oz</span>
                            </div>
                        </div>
                        <br>
                        <div class="row trade-table-row">
                            <div class="col-12 col-md-9 offset-md-3">
                                <div class="row g-0">
                                    <div class="col-3">
                                        <a class="btn per-btn percent-trigger text-bold" data-val="0.25"
                                            data-type="buy">25%</a>
                                    </div>
                                    <div class="col-3" style="padding-left: 2.5%;">
                                        <a class="btn per-btn percent-trigger text-bold" data-val="0.5"
                                            data-type="buy">50%</a>
                                    </div>
                                    <div class="col-3" style="padding-left: 2.5%;">
                                        <a class="btn per-btn percent-trigger text-bold" data-val="0.75"
                                            data-type="buy">75%</a>
                                    </div>
                                    <div class="col-3" style="padding-left: 2.5%;">
                                        <a class="btn per-btn percent-trigger text-bold" data-val="1"
                                            data-type="buy">100%</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row trade-table-row">
                            <div class="col-3 text-left text-bold color-yellow text-cap">
                                Total:
                            </div>
                            <div class="col-9">
                                <input class="text-right buy-total-price total-price-fake text-bold color-yellow"
                                    data-real-class="total-price">
                                <input type="hidden"
                                    class="text-right buy-total-price total-price text-bold color-yellow">
                            </div>
                        </div>
                        <br>
                        <div class="row trade-table-row">
                            <div class="col-12 text-right">
                                <a href="#" class="btn makeup-btn-dark-green buy-btn">Buy</a>
                            </div>
                        </div>
                        <br>
                    </div>

                </div>
            </div>
        </div>
    </div> --}}
    <br><br>
    <div style="display: none;" class="trade-bg"
        style="background-image: url('{{ '/img/exchange-bg.jpg' }}'); background-repeat: repeat;"></div>
    <br style="display: none;"><br style="display: none;">

    <div style="display: none;" id="trade-section-old" class="row desktop-trade-history">
    </div>
    {{-- <div class="row d-none d-md-flex">
        <div class="col-3">
            <a href="{{ URL::to('/') }}/shop">
                <img class="exchange-img" src="{{ '/img/exchange/shop-banner.jpg' }}" alt="Shop">
            </a>
        </div>
        <div class="col-3">
            <a href="{{ URL::to('/') }}/faq">
                <img class="exchange-img" src="{{ '/img/exchange/how-it-works-banner.jpg' }}" alt="How It Works">
            </a>
        </div>
        <div class="col-3">
            <a href="{{ URL::to('/') }}/shop">
                <img class="exchange-img" src="{{ '/img/exchange/luxury-watches-banner.jpg' }}"
                    alt="Luxury Watches">
            </a>
        </div>
        <div class="col-3">
            <a href="{{ URL::to('/') }}/shop">
                <img class="exchange-img" src="{{ '/img/exchange/luxury-diamonds-banner.jpg' }}"
                    alt="Luxury Diamonds">
            </a>
        </div>

    </div> --}}
</div>
