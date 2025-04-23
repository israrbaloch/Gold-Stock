@php
    $currentDate = now();
@endphp

<div class="carousel">
    <div class="banners">

        {{-- @if ($currentDate->month == 12 && $currentDate->day >= 10 && $currentDate->day <= 30)
            <div class="banner holidays">
                <img class="wave" src="{{ asset('img/banners/holidays/wave.svg') }}">

                <div class="content">

                    <div class="box">
                        <img class="bottom" src="{{ asset('img/banners/holidays/bottom-box.png') }}">
                        <img class="inside" src="{{ asset('img/banners/holidays/inside-box.png') }}">
                        <img class="gold" src="{{ asset('img/banners/holidays/gold.png') }}">
                        <img class="top" src="{{ asset('img/banners/holidays/top-box.png') }}">
                    </div>

                    <div class="title">
                        <h2>Happy Holidays</h2>
                        <p>Give the gift of saving this holiday season.</p>
                        <a class="shop" href="{{ route('shop') }}">Explore now</a>
                    </div>

                    <div class="confetti confetti-1">
                        <img src="{{ asset('img/banners/holidays/confetti-1.svg') }}">
                    </div>
                    <div class="confetti confetti-2">
                        <img src="{{ asset('img/banners/holidays/confetti-2.svg') }}">
                    </div>
                    <div class="confetti confetti-3">
                        <img src="{{ asset('img/banners/holidays/confetti-1.svg') }}">
                    </div>
                    <div class="confetti confetti-4">
                        <img src="{{ asset('img/banners/holidays/confetti-2.svg') }}">
                    </div>
                    <div class="confetti confetti-5">
                        <img src="{{ asset('img/banners/holidays/confetti-1.svg') }}">
                    </div>
                    <div class="confetti confetti-6">
                        <img src="{{ asset('img/banners/holidays/confetti-2.svg') }}">
                    </div>

                    <img class="flake flake-1" src="{{ asset('img/banners/holidays/flake.svg') }}">
                    <img class="flake flake-2" src="{{ asset('img/banners/holidays/flake.svg') }}">
                    <img class="flake flake-3" src="{{ asset('img/banners/holidays/flake.svg') }}">
                    <img class="flake flake-4" src="{{ asset('img/banners/holidays/flake.svg') }}">
                    <img class="flake flake-5" src="{{ asset('img/banners/holidays/flake.svg') }}">

                </div>
            </div>
        @endif
        @if ($currentDate->month == 1 && $currentDate->day >= 1 && $currentDate->day <= 20)
            <div class="banner newyear">
                <div class="firework left">
                    <img src="{{ asset('img/banners/newyear/fireworks.png') }}" alt="">
                </div>

                <div class="content">
                    <h2 class="subtitle">
                        Happy New Year
                    </h2>

                    <div class="coin left">
                        <img src="{{ asset('img/banners/newyear/coin1.png') }}" alt="">
                    </div>
                    <div class="title">
                        <img src="{{ asset('img/2024.png') }}" alt="">
                    </div>
                    <div class="coin right">
                        <img src="{{ asset('img/banners/newyear/coin2.png') }}" alt="">
                    </div>
                    <p>
                        Start off the new year with gold, a symbol of prosperity and good fortune
                    </p>
                </div>

                <div class="firework right">
                    <img src="{{ asset('img/banners/newyear/fireworks.png') }}" alt="">
                </div>
            </div>
        @endif --}}

        <div class="banner original">
            <div class="content col-lg-12">
                <div class="col-lg-5 d-flex">
                    <img class="mx-auto" src="/img/home-coin.png" alt="Gold Coin">
                </div>
                <div class="details col-lg-7">
                    <h1>Preserve your wealth</h1>
                    <p>Protect your portfolio from inflation and economic uncertainty</p>
                    <a href="{{ route('shop') }}" class="button">
                        Shop now
                    </a>
                </div>
            </div>
        </div>

        @foreach ($banners as $banner)
            @if ($banner->type == 'image')
                <div class="banner admin-banner">
                    <div class="content">
                        <img class="mx-auto img-fluid" width="100%" height="100%"
                            src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}">
                    </div>
                </div>
            @else
                <div class="banner admin-banner">
                    <!-- Desktop Image (Hidden on Mobile) -->
                    <img src="{{ asset('storage/' . $banner->image) }}" class="banner-img d-none d-md-block"
                        alt="{{ $banner->title }}">

                    <!-- Mobile Image (Hidden on Desktop) -->
                    <img src="{{ asset('storage/' . ($banner->mobile_image ?? $banner->image)) }}"
                        class="banner-img d-block d-md-none" alt="{{ $banner->title }}">

                    <div class="overlay">
                        @php
                            $alignmentClass = 'align-center';
                            if ($banner->alignment == 'left') {
                                $alignmentClass = 'align-left';
                            } elseif ($banner->alignment == 'right') {
                                $alignmentClass = 'align-right';
                            }
                        @endphp

                        <div class="content {{ $alignmentClass }}">
                            <h1>{{ $banner->title }}</h1>
                            <p>{{ $banner->description }}</p>
                            @if ($banner->button_text && $banner->button_link)
                                <a href="{{ $banner->button_link }}" class="banner-btn">
                                    {{ $banner->button_text }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        {{-- <div class="banner diwali">
            <div class="content">
                <img class="main" src="/img/banners/diwali/main2.png">
                <div class="left">
                    <img src="/img/banners/diwali/left.png">
                    <div class="details">
                        <h2>Celebrate Diwali</h2>
                        <p>with a omc gold bar</p>
                    </div>
                </div>

                <a class="shop" href="{{ route('shop') }}">Shop Now</a>

                <div class="products">
                    <img class="product1" src="/img/banners/diwali/product1.png">
                    <img class="product2" src="/img/banners/diwali/product2.png">
                </div>

                <div class="dot dot-1"></div>
                <div class="dot dot-2" style="left: 20%; top: 10%"></div>
                <div class="dot dot-3" style="right: 10%; top: 14%"></div>
                <div class="dot dot-4" style="left: 14%; bottom: 14%; scale: 0.75"></div>
                <div class="dot dot-5" style="right: 0%; bottom: 25%"></div>
                <div class="dot dot-6" style="right: 30%; bottom: 5%"></div>
                <div class="dot dot-7" style="left: 5%; bottom: 5%"></div>
            </div>
        </div> --}}

        <div class="banner-options-container">
            <div class="banner-options">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ URL::to('/') }}/js/banner.js"></script>
