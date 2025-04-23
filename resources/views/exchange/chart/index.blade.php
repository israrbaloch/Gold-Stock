<div class="chart-interval-container">
    {{-- Desktop --}}
    <button type="button" class="button clean" data-interval="1m">1m</button>
    <button type="button" class="button clean" data-interval="5m">5m</button>
    <button type="button" class="button clean" data-interval="15m">15m</button>
    <button type="button" class="button clean" data-interval="1h">1h</button>
    <button type="button" class="button clean" data-interval="1d">1D</button>

    {{-- Mobile --}}
    <label class="chart-interval" for="chart-interval">
        Time
        <select class="select clean" id="chart-interval">
            <option value="1m">1m</option>
            <option value="5m">5m</option>
            <option value="15m">15m</option>
            <option value="1h">1h</option>
            <option value="1d">1D</option>
        </select>
    </label>
</div>

<div id="chart" class="chart"></div>

<div class="chart-trade-container">
    @include('exchange.chart.toggle')
    <div class="chart-trade-options-container">
        @include('exchange.chart.buy')
        @include('exchange.chart.sell')
    </div>

    <div class="exchange-currencies-container">
        <button type="button" class="button clean" data-currency="CAD">
            CAD
        </button>
        <button type="button" class="button clean" data-currency="USD">
            USD
        </button>
        <button type="button" class="button clean" data-currency="EUR">
            EUR
        </button>
    </div>
</div>
