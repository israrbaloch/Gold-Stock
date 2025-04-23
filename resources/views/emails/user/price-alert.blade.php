@component('components.base')
    @component('components.banner')
    @endcomponent

    <div class="content">
        <h1 style="font-size: 24px;">Your Price Alert Has Been Triggered</h1>

        <p>Hi,</p>
        <p><strong>{{ $alert->user->name }}!</strong></p>

        <p>
            Your configured price alert with Gold Stock Canada has been triggered. Here are the details:
        </p>

        <br>

        <h3>Price Alert Details:</h3>

        @if ($alert->type == 2)
            <p>Metal: {{ $alert->metal->name }}</p>
            <p>Current Price: ${{ $alert->metal->CurrencyPrice($alert->currency) }} {{ $alert->metal->currency }}</p>
        @endif
        @if ($alert->type == 1)
            <p>Product: {{ $alert->product->name }}</p>
            <p>Current Price: ${{ $alert->product->CurrencyPrice($alert->currency) }} {{ $alert->currency }}</p>
        @endif
        @if ($alert->alert_type == 'price_reaches')
            <p>Alert Type: Price Reaches ${{ $alert->value }}</p>
        @endif
        @if ($alert->alert_type == 'price_rises_above')
            <p>Alert Type: Price Rises Above ${{ $alert->value }} {{ $alert->currency }}</p>
        @endif
        @if ($alert->alert_type == 'price_drops_to')
            <p>Alert Type: Price Drops To ${{ $alert->value }} {{ $alert->currency }}</p>
        @endif
        @if ($alert->alert_type == 'change_is_over')
            <p>Alert Type: Change Is Over {{ $alert->value }}%</p>
        @endif
        @if ($alert->alert_type == 'change_is_under')
            <p>Alert Type: Change Is Under {{ $alert->value }}%</p>
        @endif
        @if ($alert->alert_type == '24h_change_is_over')
            <p>Alert Type: 24h Change Is Over {{ $alert->value }}%</p>
        @endif

        {{-- current change show --}}
        @if ($alert->type == 2)
            <p>Current Change: {{ $alert->metal->currentChange() }}%</p>
        @endif

        <div style="text-align: center; margin: 20px 0;">
            @component('components.button', ['url' => 'https://goldstockcanada.com/live-prices'])
                View Live Prices
            @endcomponent
        </div>

        <h3>Explore More:</h3>
        <p>&#10003; <a href="https://goldstockcanada.com/exchange/gold">Explore Interactive Charts</a></p>
        <p>&#10003; <a href="https://goldstockcanada.com/shop">Lock in Prices Today </a>and pick up your order in
            the future while paying no physical premium until you take delivery.</p>
        <p>&#10003; <a href="https://goldstockcanada.com/exchange/gold">Learn More About GoldX: </a>Build your gold savings with
            every transaction and enjoy exclusive benefits.</p>
        <p>&#10003; <a href="https://goldstockcanada.com/shop">Browse Precious Metals</a></p>
        <p>&#10003; <a href="https://goldstockcanada.com/news">Read Market Insights</a></p>

        <br>
        <p><b>Thank you for using Gold Stock Canada's price alert system. </b></p>

        <p>If you have any questions or need assistance with
            payment, feel free to contact us at support@goldstockcanada.com or call us at 1-844-504-4653.</p>

        @include('components.social')

        @include('components.footer')
    </div>
@endcomponent
