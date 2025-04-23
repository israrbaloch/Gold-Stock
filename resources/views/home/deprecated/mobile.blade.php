<div class="d-block d-md-none">
    <div class="ic-metal-table py-2 mb-2">
        <div class="row g-0">
            @php
                $i = 1;
                $metalNames = ['silver' => 'silver', 'gold' => 'gold', 'plat' => 'platinum', 'pall' => 'palladium'];
            @endphp
            @foreach ($metalprices as $k => $v)
                <div class="col-3 text-center">
                    <a href="{{ URL::to('/') }}/exchange/{{ $metalNames[$k] }}" class="no-decoration text-black">
                        <div class="metal-column" data-product-name="{{ $k }}"
                            data-product-id="{{ $i }}" data-product-code="{{ $k }}"
                            data-href="/exchange">
                            <div class="metal-content{{ $i < 4 ? ' separator' : '' }}">
                                <p class="name ng-binding">{{ ucfirst($k) }}/{{ $currency }}</p>
                                <p class="price ng-binding">{{ number_format($v['ask'], 2) }}</p>
                                <p
                                    class="zhangdie ng-binding percentage-value{{ $v['change_percent'] > 0 ? ' cogreen' : ' cored' }}">
                                    {{ $v['change_percent'] }}%</p>
                            </div>
                        </div>
                    </a>
                </div>
                @php $i++; @endphp
            @endforeach
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"><span
                class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button"
                aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet" tabindex="0"
                role="button" aria-label="Go to slide 2"></span></div>
        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
    </div>
    <div class="metal-news-container admin-notes">
        @php
            $i = 0;
            $top = 0;
        @endphp
        @foreach ($alerts as $item)
            <div class="news" data-id="{{ $i }}" style="top: {{ $top }}px;">
                <i class="material-icons">notifications_none</i>
                <div class="message">{{ $item->content }}</div>
            </div>
            @php
                $i++;
                $top += 40;
            @endphp
        @endforeach
    </div>

    <div class="home-action-buttons-containers">
        <ul class="dh-bar">
            <li>
                <a href="tel:1-844-504-4653">
                    <i class="material-icons tubiao">phone_in_talk</i>
                    <h4 class="ng-binding">Call</h4>
                </a>

            </li>
            <li>
                <a target="_blank" jstcache="52" class="navigate-link"
                    href="https://maps.google.com/maps?ll=43.655934,-79.378695&amp;z=16&amp;t=m&amp;hl=en&amp;gl=CO&amp;mapclient=embed&amp;daddr=Gold%20Stock%20Canada%2055%20Dundas%20St%20E%203rd%20Floor%20Toronto%2C%20ON%20M5B%201C6%20Canada@43.6559343,-79.3786952">
                    <i class="material-icons tubiao">place</i>
                    <h4>Location</h4>
                </a>
            </li>
            <li>&nbsp;
                <a href="{{ URL::to('/') }}/shop">
                    <i class="material-icons tubiao">shopping_cart</i>
                    <h4 class="ng-binding">&nbsp;&nbsp;Shop</h4>
                </a>
            </li>
            <li>&nbsp;
                <a href="{{ URL::to('/') }}/exchange">
                    <i class="material-icons tubiao">attach_money</i>
                    <h4 class="ng-binding">Trade</h4>
                </a>
            </li>
        </ul>
    </div>

    <!--Mobile Slider-->
    <div class="d-lg-none d-xl-none">
        <div id="carouselControls" class="carousel slide mt-2" data-bs-ride="carousel">
            <div class="carousel-inner">
                @php
                    $i = 0;
                @endphp
                @foreach ($products as $product)
                    <?php
                    $imgs = explode(',', $product->images);
                    $class = $i == 0 ? ' active' : '';
                    ?>
                    <div class="carousel-item{{ $class }}">
                        <div id="slider-product-{{ $product->id }}"
                            class="mobile-product-box-slider-container product-box-slider-container normal-product product"
                            data-product-id="{{ $product->id }}" data-id="{{ $product->id }}"
                            data-category-slug="{{ $metals[$product->metal_id] }}">
                            <a class="no-decoration"
                                href="{{ URL::to('/') }}/product/{{ $product->id }}/{{ $product->url_name }}">
                                <div class="product-box-slider">
                                    <div class="col-12 text-center product-image"><img src="{{ $imgs[0] }}"
                                            alt="{{ $product->name }}"></div>
                                    <div class="col-12 text-center product-name"><b>{{ $product->name }}</b></div>
                                    <!-- <div class="col-12 text-center product-description"></div> -->
                                    <div class="col-12 text-center product-price">
                                        <div class="money-sign">{{ $currency }}
                                            $
                                        </div>
                                        <span id="mobile-slider-product-price-{{ $product->id }}">
                                            {{ number_format($product->real_price, 2) }}
                                        </span>
                                    </div>
                                    <div class="col-12 text-center add-to-cart fake"></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 text-center add-to-cart">
                            <form action="{{ route('cart.add') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="user_id" value="{{ $userId }}">
                                <input type="hidden" name="current_price" value="{{ $product->real_price }}">
                                <input type="hidden" name="currency" value="{{ $currency }}">
                                <input type="hidden" name="weight" value="{{ $product->weight_oz }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" name="btn"
                                    class="button button-buy-mobile add-to-cart add-to-cart_button-dark-green"
                                    data-id="{{ $product->id }}" data-category-slug="">Buy Now</button>
                            </form>
                        </div>
                    </div>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselControls"
                data-bs-slide="prev" style="filter: invert(80%); ">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselControls"
                data-bs-slide="next" style="filter: invert(80%); ">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <div class="text-right mt-2"><a href="{{ URL::to('/') }}/shop"><b>View all Products
                        &gt;&gt;</b></a></div>
        </div>
    </div>
</div>

<div class="d-block d-md-none px-2">
    <div class="row">
        <div class="col-12">
            {{-- <div class="underline-title color-dark-green text-bold">
                <a class="color-dark-gray" href="{{ URL::to('/') }}/live-prices">Live Quotes</a>
            </div> --}}
            <div class="row home-sm-table mobile">
                <div class="col-6 color-white text-bold color-table-gold help-margin">
                    Gold Price (CAD)
                </div>
                <div class="col-6 color-white text-bold color-table-silver help-margin">
                    Silver Price (CAD)
                </div>
                <div class="col-6 color-table-1">
                    Selling Gold Ounce
                </div>
                <div class="col-6 color-table-1">
                    Selling Silver Ounce
                </div>
                <div class="col-6">
                    <span class="color-gold live-value">$
                        <?= number_format($metalinfo['gold']['sellingounce'], 2) ?></span>
                </div>
                <div class="col-6">
                    <span class="color-gold live-value">$
                        <?= number_format($metalinfo['silver']['sellingounce'], 2) ?></span>
                </div>
                <div class="col-6 color-table-1">
                    Selling Gold kilo
                </div>
                <div class="col-6 color-table-1">
                    Selling Silver kilo
                </div>
                <div class="col-6">
                    <span class="color-gold live-value">$
                        <?= number_format($metalinfo['gold']['sellingkilo'], 2) ?></span>
                </div>
                <div class="col-6">
                    <span class="color-gold live-value">$
                        <?= number_format($metalinfo['silver']['sellingkilo'], 2) ?></span>
                </div>
            </div>
            <br>
            <div class="home-sm-title">
                <div class="col-12">
                    <div id="mobile-duration-container" class="d-sm-none d-md-block row g-0 chart-intervals-home">
                        <button type="button" class="btn btn-light chart-interval interval-btn"
                            data-interval="15">15M</button>
                        <button type="button" class="btn chart-interval interval-btn" data-interval="60">1H</button>
                        <button type="button" class="btn chart-interval interval-btn" data-interval="360">6H</button>
                        <button type="button" class="btn chart-interval interval-btn" data-interval="1440">1D</button>
                        <button type="button" class="btn chart-interval interval-btn"
                            data-interval="10080">1W</button>
                        <button type="button" class="btn chart-interval interval-btn"
                            data-interval="43200">1M</button>
                    </div>
                    <div>
                        <img style="display: none;" class="loader-img" src="{{ URL::to('/') }}/img/loader.gif"
                            alt="loader gif" />
                    </div>
                    <div id="mobile_chart_div" style="height: 180px;">

                    </div>
                </div>
            </div>
        </div>
        <div id="mobile-news-container-home" class="col-12 no-gutters">
            <div class="col-12">
                <br><br>
                <a class="underline-title color-dark-green text-bold new-news-title"
                    href="{{ URL::to('/') }}/news"> Market News</a>
            </div>
            {{-- @include('home.single-new') --}}
        </div>
    </div>

    <div class="row link-box-mobile">
        <div class="col-12">
            <a href="{{ URL::to('/') }}/shop">
                <img src="{{ URL::to('/') }}/img/homenew/shop-latest.jpg" alt="shop">
            </a>
        </div>
    </div>
    <div class="row link-box-mobile">
        <div class="col-12">
            <a href="{{ URL::to('/') }}/exchange">
                <img src="{{ URL::to('/') }}/img/homenew/trade-latest.jpg" alt="exchange">
            </a>
        </div>
    </div>
    <div class="row link-box-mobile">
        <div class="col-12">
            <a href="{{ URL::to('/') }}/refining">
                <img src="{{ URL::to('/') }}/img/homenew/refine-latest.jpg" alt="refining">
            </a>
        </div>
    </div>
</div>