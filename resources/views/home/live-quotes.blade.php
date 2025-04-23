<div class="live-quotes">

    {{-- Title --}}
    <a href="{{ URL::to('/') }}/live-prices">
        <h2>Live Quotes</h2>
    </a>

    <div class="quote-container">

        {{-- Gold --}}
        <div class="quote">
            <h3>Gold Price ({{ $currency }})</h3>
            <div class="price">
                <h4>Selling Gold Ounce</h4>
                <span class="live-value">$
                    <?= number_format($metalinfo['gold']['sellingounce'], 2) ?></span>
            </div>

            <div class="price">
                <h4>Selling Gold kilo</h4>
                <span class="live-value">$ <?= number_format($metalinfo['gold']['sellingkilo'], 2) ?></span>
            </div>
            {{-- TODO: Missing button --}}
            <a href="#" class="ms-auto">
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>

        {{-- Silver --}}
        <div class="quote">
            <h3>Silver Price ({{ $currency }})</h3>
            <div class="price">
                <h4>Selling Silver Ounce</h4>
                <span class="live-value silver-price">
                    $ <?= number_format($metalinfo['silver']['sellingounce'], 2) ?>
                </span>
            </div>

            <div class="price">
                <h4>Selling Silver kilo</h4>
                <span class="live-value">$
                    <?= number_format($metalinfo['silver']['sellingkilo'], 2) ?></span>
            </div>
            {{-- TODO: Missing button --}}
            <a href="#" class="ms-auto">
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
</div>
