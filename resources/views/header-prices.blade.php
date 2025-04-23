@php
    $currency = Cookie::get('currency');
    $routename = Request::route()->uri;

    if ($currency == null) {
        Cookie::queue('currency', 'CAD');
        $currency = 'CAD';
    }

@endphp

@include('header.utils')

<div class="price-bar d-none d-md-flex">
    <div class="col-12 col-md-12">
        <div id="newsticker-disabled" class="TickerNews bordered-home-prices">
            <div class="ti_wrapper">
                <div class="ti_slide">
                    <div class="top_title">
                        BULLION DEALER & REFINER
                    </div>
                    {{-- Prices --}}
                    <div class="ti_content">
                        <div class="ti_news home-coin text-left" data-coin-code="gold">
                            <div class="price-element">
                                <div class="text-right">
                                    <span class="text-bold home-coin-name text-right">
                                        GOLD
                                    </span>
                                </div>
                                <div class="text-center">
                                    <span class="home-coin-price text-center text-bold gold-price">
                                        @php
                                            echo '$' .
                                                addCommas($_metals['gold']->value * $_currencies[$_currency]->value);
                                        @endphp
                                    </span>
                                    <span
                                        class="{{ $_metals['gold']->change_percent < 0 ? 'd-none' : 'd-inline' }} cogreen-solid gold">▲</span>
                                    <span
                                        class="{{ $_metals['gold']->change_percent < 0 ? 'd-inline' : 'd-none' }} cored-solid gold">▼</span>
                                </div>
                                <div class="text-left">
                                    <span
                                        class="gold-percentage {{ $_metals['gold']->change_percent < 0 ? 'low' : 'high' }}">
                                        @php
                                            echo addCommas($_metals['gold']->change_percent) . '%';
                                        @endphp
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="ti_news home-coin text-center" data-coin-code="silver">
                            <div class="price-element">
                                <div class="text-right">
                                    <span class="text-bold home-coin-name text-center">
                                        SILVER
                                    </span>
                                </div>
                                <div class="text-center">
                                    <span class="home-coin-price text-center text-bold silver-price">
                                        @php
                                            echo '$' .
                                                addCommas($_metals['silver']->value * $_currencies[$_currency]->value);
                                        @endphp
                                    </span>
                                    <span
                                        class="{{ $_metals['silver']->change_percent < 0 ? 'd-none' : 'd-inline' }} cogreen-solid silver">▲</span>
                                    <span
                                        class="{{ $_metals['silver']->change_percent < 0 ? 'd-inline' : 'd-none' }} cored-solid silver">▼</span>
                                </div>
                                <div class="text-left">
                                    <span
                                        class="silver-percentage {{ $_metals['silver']->change_percent < 0 ? 'low' : 'high' }}">
                                        @php
                                            echo addCommas($_metals['silver']->change_percent) . '%';
                                        @endphp
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="ti_news home-coin text-center" data-coin-code="platinum">
                            <div class="price-element">
                                <div class="text-right">
                                    <span class="text-bold home-coin-name text-center">
                                        PLATINUM
                                    </span>
                                </div>
                                <div class="text-center">
                                    <span class="home-coin-price text-center text-bold platinum-price">
                                        @php
                                            echo '$' .
                                                addCommas(
                                                    $_metals['platinum']->value * $_currencies[$_currency]->value,
                                                );
                                        @endphp
                                    </span>
                                    <span
                                        class="{{ $_metals['platinum']->change_percent < 0 ? 'd-none' : 'd-inline' }} cogreen-solid platinum">▲</span>
                                    <span
                                        class="{{ $_metals['platinum']->change_percent < 0 ? 'd-inline' : 'd-none' }} cored-solid platinum">▼</span>
                                </div>
                                <div class="text-left">
                                    <span
                                        class="platinum-percentage {{ $_metals['platinum']->change_percent < 0 ? 'low' : 'high' }}">
                                        @php
                                            echo addCommas($_metals['platinum']->change_percent) . '%';
                                        @endphp
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="ti_news home-coin text-center" data-coin-code="palladium">
                            <div class="price-element">
                                <div class="text-right">
                                    <span class="text-bold home-coin-name text-center">
                                        PALLADIUM
                                    </span>
                                </div>
                                <div class="text-center">
                                    <span class="home-coin-price text-center text-bold palladium-price">
                                        @php
                                            echo '$' .
                                                addCommas(
                                                    $_metals['palladium']->value * $_currencies[$_currency]->value,
                                                );
                                        @endphp
                                    </span>
                                    <span
                                        class="{{ $_metals['palladium']->change_percent < 0 ? 'd-none' : 'd-inline' }} cogreen-solid palladium">▲</span>
                                    <span
                                        class="{{ $_metals['palladium']->change_percent < 0 ? 'd-inline' : 'd-none' }} cored-solid palladium">▼</span>
                                </div>
                                <div class="text-left">
                                    <span
                                        class="palladium-percentage {{ $_metals['palladium']->change_percent < 0 ? 'low' : 'high' }}">
                                        @php
                                            echo addCommas($_metals['palladium']->change_percent) . '%';
                                        @endphp
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="d-none-">
                        <div id="google_translate_element"></div>
                    </div> --}}

                    {{-- <select id="language-selector">
                        <option value="en" {{ empty($language) || $language == 'en' ? 'selected' : '' }}>English</option>
                        <option value="fr" {{ $language == 'fr' ? 'selected' : '' }}>French</option>
                        <option value="es" {{ $language == 'es' ? 'selected' : '' }}>Spanish</option>
                        <option value="ar" {{ $language == 'ar' ? 'selected' : '' }}>Arabic</option>
                    </select>                     --}}
                    

                    {{-- Coin --}}
                    <div id="ic-currency-flags-desktop" class="ic-currency-flags dropdown show">
                        <input id="signup-token" name="_token" type="hidden" value="{{ csrf_token() }}">
                        <a class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true" data-currency="CAD">
                            <div class="language-container">
                                <img src="/img/Canada.png" alt="flag">
                            </div>
                            <span>CAD</span>
                        </a>
                        <div class="dropdown-menu show" aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 44px, 0px);">
                            <a class="dropdown-item ic-currency-usd currency-flag js-change-currency"
                                data-currency="USD">
                                <div class="language-container">
                                    <img src="/img/USA.png" alt="flag">
                                </div>
                                <span>USD</span>
                            </a>
                            <a class="dropdown-item ic-currency-eur currency-flag js-change-currency"
                                data-currency="EUR">
                                <div class="language-container">
                                    <img src="/img/EUR.png" alt="flag">
                                </div>
                                <span>EUR</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
