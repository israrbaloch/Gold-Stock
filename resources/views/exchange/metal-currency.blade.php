<div class="comparison-container" class="values">
    <div class="comparison-buttons-container">
        <div class="comparison-title">
            Currency
        </div>
        <div class="comparison-buttons">
            <button type="button" class="button clean" data-currency="cad">CAD</button>
            <button type="button" class="button clean" data-currency="usd">USD</button>
            <button type="button" class="button clean" data-currency="eur">EUR</button>
        </div>
    </div>

    @foreach (['usd', 'cad', 'eur'] as $currency)
        <div class="comparison-group {{ $currency }}">
            @foreach (['gold', 'silver', 'platinum', 'palladium'] as $metal)
                <div class="comparison">
                    <div class="text-left">{{ ucfirst($metal) }}</div>
                    <div class="text-right {{ $metal }}-{{ $currency }}-price">
                        @php
                            echo '$' . addCommas($_metals[$metal]->value * $_currencies[$currency]->value);
                        @endphp
                    </div>
                    <div
                        class="text-right {{ $metal }}-{{ $currency }}-percentage {{ $_metals[$metal]->change_percent < 0 ? 'low' : 'high' }}">
                        @php
                            echo $_metals[$metal]->change_percent . '%';
                        @endphp
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
