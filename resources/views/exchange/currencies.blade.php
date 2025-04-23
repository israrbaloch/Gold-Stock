<div class="currencies-container" class="values">

    <div class="currencies-group">
        <div class="currencies">
            <div class="text-left">USD/CAD</div>
            <div class="text-right">
                @php
                    echo '$' . addCommas($_currencies['cad']->value);
                @endphp
            </div>
            <div class="text-right {{ $_currencies['cad']->change_percent < 0 ? 'low' : 'high' }}">
                @php
                    echo $_currencies['cad']->change_percent . '%';
                @endphp
            </div>
        </div>
        <div class="currencies">
            <div class="text-left">USD/EUR</div>
            <div class="text-right">
                @php
                    echo '$' . addCommas($_currencies['eur']->value);
                @endphp
            </div>
            <div class="text-right {{ $_currencies['eur']->change_percent < 0 ? 'low' : 'high' }}">
                @php
                    echo $_currencies['eur']->change_percent . '%';
                @endphp
            </div>
        </div>
        <div class="currencies">
            <div class="text-left">CAD/EUR</div>
            @php
                $cad_eur_value = $_currencies['eur']->value / $_currencies['cad']->value;
                $cad_eur_change_percent = $_currencies['eur']->change_percent - $_currencies['cad']->change_percent;
            @endphp
            <div class="text-right">
                @php
                    echo '$' . addCommas($cad_eur_value);
                @endphp
            </div>
            <div class="text-right {{ $cad_eur_change_percent < 0 ? 'low' : 'high' }}">
                @php
                    echo $cad_eur_change_percent . '%';
                @endphp
            </div>
        </div>

    </div>
</div>
