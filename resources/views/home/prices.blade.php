@php
    $currency = Cookie::get('currency');
    $routename = Request::route()->uri;

    if ($currency == null) {
        Cookie::queue('currency', 'CAD');
        $currency = 'CAD';
    }
@endphp
<div class="page-container container home-container section1">

    <div class="prices-container">
        <a data-coin-code="gold" href="{{ URL::to('/') }}/exchange/gold">
            <div class="price">
                <div class="name">
                    GOLD/{{ $currency }}
                </div>
                <div class="details value gold-price">
                    {{-- Price --}}
                </div>
                <div class="gold-percentage">
                    {{-- Percentage --}}
                </div>
            </div>
        </a>
        <a data-coin-code="silver" href="{{ URL::to('/') }}/exchange/silver">
            <div class="price">
                <div class="name">
                    SILVER/{{ $currency }}
                </div>
                <div class="details value silver-price">
                    {{-- Price --}}
                </div>
                <div class="silver-percentage">
                    {{-- Percentage --}}
                </div>
            </div>
        </a>
        <a data-coin-code="platinum" href="{{ URL::to('/') }}/exchange/platinum">
            <div class="price">
                <div class="name">
                    PLATINUM/{{ $currency }}
                </div>
                <div class="details value platinum-price">
                    {{-- Price --}}
                </div>
                <div class="platinum-percentage">
                    {{-- Percentage --}}
                </div>
            </div>
        </a>
        <a data-coin-code="palladium" href="{{ URL::to('/') }}/exchange/palladium">
            <div class="price">
                <div class="name">
                    PALLADIUM/{{ $currency }}
                </div>
                <div class="details value palladium-price">
                    {{-- Price --}}
                </div>
                <div class="palladium-percentage">
                    {{-- Percentage --}}
                </div>
            </div>
        </a>
    </div>


    <div class="options-container mb-0">
        <a href="tel:1-844-504-4653">
            <div class="icon">
                <i class="material-icons">phone_in_talk</i>
            </div>
            <div class="name">
                Call
            </div>
        </a>
        <a target="_blank" jstcache="52" class="navigate-link"
            href="https://maps.google.com/maps?ll=43.655934,-79.378695&amp;z=16&amp;t=m&amp;hl=en&amp;gl=CO&amp;mapclient=embed&amp;daddr=Gold%20Stock%20Canada%2055%20Dundas%20St%20E%203rd%20Floor%20Toronto%2C%20ON%20M5B%201C6%20Canada@43.6559343,-79.3786952">
            <div class="icon">
                <i class="material-icons">place</i>
            </div>
            <div class="name">
                Location
            </div>
        </a>
        </a>
        <a href="/shop">
            <div class="icon">
                <i class="material-icons">shopping_cart</i>
            </div>
            <div class="name">
                Shop
            </div>
        </a>
        <a href="/exchange">
            <div class="icon">
                <i class="material-icons">attach_money</i>
            </div>
            <div class="name">
                Trade
            </div>
        </a>
    </div>

</div>
