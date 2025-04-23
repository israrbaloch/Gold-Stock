<div id="mobile-version" class="d-block d-md-none">
    <input type="hidden" id="available-metal" />
    <div class="page-container">
        <div class="row" id="top-actions">
            <div id="charts-btn" class="col-6 active text-center">
                <a class="charts" href="#">Charts</a>
            </div>
            <div id="trade-btn" class="col-6 text-center">
                <a class="trade" href="#">Trade</a>
            </div>
        </div>
        <br>
        <div class="row g-0">
            <div class="col-12">
                <div class="dropdown dropdown-metals">
                    <button id="selected-metal-btn" data-id="{{ $get_id }}"
                        class="btn btn-transparent dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="metal-code">{{ ucfirst($get_id) }}</span>/{{ $currency }}
                    </button>
                    <div class="dropdown-menu d-none" aria-labelledby="dropdownMenuButton">
                        @foreach ($prices as $priceId => $price)
                            @if ($priceId != $get_id)
                                <a id="dropdown-metal-{{ $priceId }}"
                                    data-metal-name="{{ strtolower($metals[$priceId]) }}" data-id="{{ $priceId }}"
                                    class="dropdown-item dropdown-metal" href="#">
                                    <span class="metal-code">
                                        {{ ucfirst($priceId) }}
                                    </span>/{{ $currency }}</a>
                            @else
                                <a id="dropdown-metal-{{ $priceId }}"
                                    data-metal-name="{{ strtolower($metals[$priceId]) }}" data-id="{{ $priceId }}"
                                    class="dropdown-item dropdown-metal d-none"
                                    href="#">{{ ucfirst($priceId) }}/{{ $currency }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-7">
                <div class="metal-price-container">
                    Last: <span class="metal-price text-bold">Loading...</span>
                </div>
                <div class="metal-price-diff-container text-bold">
                    <span class="metal-price-diff">0</span>
                    / <span class="metal-price-diff-avg">0</span>%
                </div>
            </div>
            <div class="col-5">
                <div>Low: <span class="metal-duration-low text-bold">Loading...</span></div>
                <div>High: <span class="metal-duration-high text-bold">Loading...</span></div>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <div id="mobile-duration-container" class="d-sm-none d-md-block row g-0">
        <button type="button" class="btn btn-light drawchart interval-btn col-2" data-inteval="15">15M</button>
        <button type="button" class="btn drawchart interval-btn col-2" data-inteval="60">1H</button>
        <button type="button" class="btn drawchart interval-btn col-2" data-inteval="360">6H</button>
        <button type="button" class="btn drawchart interval-btn col-2" data-inteval="1440">1D</button>
        <button type="button" class="btn drawchart interval-btn col-2" data-inteval="10080">1W</button>
        <button type="button" class="btn drawchart interval-btn col-2" data-inteval="43200">1M</button>

    </div>
    <div>
        <img class="loader-img" src="{{ '/img/loader.gif' }}" />
    </div>
    <div id="mobile_chart_div" style="width: 100%; height: 290px;" class="chart_div color-gold"></div>
    <div id="period-dates-mob" class="row"></div>
    <br>
    <hr>
    <div class="page-container">
        <div>
            <strong>Trade history</strong>
        </div>
        <div id="trade-history-container">
            <span>loading...</span>
        </div>
        <div id="mobile-transaction-buttons" class="row g-0">
            <div class="mobile-loading-prices d-block">
                <span>Updating prices...</span>
            </div>
            <div class="exchange-buttons-container col-12" id="mobile-exchange-actions">
                <div class="row">
                    <div class="col-6 text-center">
                        <a href="#" class="btn btn-success btn-action show-trade buy" style="width: 100%"
                            disabled>Buy</a>
                    </div>
                    <div class="col-6 text-center">
                        <a href="#" class="btn btn-danger btn-action show-trade sell" style="width: 100%"
                            disabled>Sell</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
