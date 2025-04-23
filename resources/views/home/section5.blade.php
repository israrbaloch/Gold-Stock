<div class="section5">
    <div class="page-container container home-container">
        <div class="col-lg-12 row align-items-center">
            <div class="col-lg-6">
                <h2>Looking to buy or sell precious metals?</h2>
                {{-- <p>View real time market data and interactive charts, set price alerts & more</p> --}}
                <a href="{{route('getliveprices')}}">
                    Get Quote
                    <i class="fas fa-chevron-right right-chevron"></i>
                </a>
            </div>
            <div class="col-lg-6 d-flex mt-lg-0 mt-5">
                <div class="card">
                    <table class="col-12 table">
                        <thead>
                            <tr>
                                <th class="col-5 th">NAME</th>
                                <th class="col-4 th">PRICE</th>
                                <th class="col-3 th">24h change</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="col-5 d-flex mb-3">
                                    <img src="{{ asset('img/section-5-1.png') }}" alt="Gold">
                                    <span class="name">
                                        Gold/<span id="currency_gold">{{ $currency }}</span>
                                    </span>
                                </td>
                                <td class="col-4">
                                    <span class="price">
                                        <span id="currency_price_gold">$ {{number_format($prices['goldprice']->ask, 2)}}</span>
                                    </span>
                                </td>
                                <td class="col-3">
                                    <span class="price">
                                        <span id="currency_price_gold" class="{{ $prices['goldprice']->change_percent > 0 ? 'increase' : 'decrease' }}">
                                            {{$prices['goldprice']->change_percent}} %
                                        </span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-5 d-flex mb-3">
                                    <img src="{{ asset('img/section-5-2.png') }}" alt="Silver">
                                    <span class="name">
                                        Silver/<span id="currency_silver">{{ $currency }}</span>
                                    </span>
                                </td>
                                <td class="col-4">
                                    <span class="price">
                                        <span id="currency_price_silver">$ {{number_format($prices['silverprice']->ask, 2)}}</span>
                                    </span>
                                </td>
                                <td class="col-3">
                                    <span class="price">
                                        <span id="currency_price_silver" class="{{ $prices['silverprice']->change_percent > 0 ? 'increase' : 'decrease' }}">
                                            {{$prices['silverprice']->change_percent}} %
                                        </span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-5 d-flex mb-3">
                                    <img src="{{ asset('img/section-5-3.png') }}" alt="Platinum">
                                    <span class="name">
                                        Platinum/<span id="currency_plat">{{ $currency }}</span>
                                    </span>
                                </td>
                                <td class="col-4">
                                    <span class="price">
                                        <span id="currency_price_plat">$ {{number_format($prices['platprice']->ask, 2)}}</span>
                                    </span>
                                </td>
                                <td class="col-3">
                                    <span class="price">
                                        <span id="currency_price_plat" class="{{ $prices['platprice']->change_percent > 0 ? 'increase' : 'decrease' }}">
                                            {{$prices['platprice']->change_percent}} %
                                        </span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-5 d-flex mb-1">
                                    <img src="{{ asset('img/section-5-4.png') }}" alt="Palladium">
                                    <span class="name">
                                        Palladium/<span id="currency_plad">{{ $currency }}</span>
                                    </span>
                                </td>
                                <td class="col-4">
                                    <span class="price">
                                        <span id="currency_price_plad">$ {{number_format($prices['pallprice']->ask, 2)}}</span>
                                    </span>
                                </td>
                                <td class="col-3">
                                    <span class="price">
                                        <span id="currency_price_plad" class="{{ $prices['pallprice']->change_percent > 0 ? 'increase' : 'decrease' }}">
                                            {{$prices['pallprice']->change_percent}} %
                                        </span>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>