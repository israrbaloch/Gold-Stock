<nav id="sidebar" class="d-none">
    <div class="menu-item menu-header d-flex justify-content-between">
        <img class="logo" src="{{ asset('img/main-logo.png') }}" alt="goldstock">
        @if (!Cart::isEmpty())
            <div class="m-auto">
                <a href="/cart" class="text-white d-flex p-0 cart">
                    <div class="">
                        <span class="">${{ Cart::getTotal() }}</span>
                        <i class="far fa-shopping-cart"></i>
                    </div>
                </a>
            </div>
        @endif
        <div id="menu-item-close">
            <button type="button" class="close" aria-label="x">
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <div class="overflow-nav">
        <div class="menu-mobile-public-container">
            <div class="px-4 mt-4 row">
                <div class="search-container me-0 flex-direction-column position-relative">
                    <input type="text" class="search-md-input w-100 me-0" id="search" placeholder="Search">
                    <div class="search-results-md">
                    </div>
                </div>

                {{-- login signup --}}
                @guest
                    <div class="d-flex justify-content-between mt-2 row col-12 mx-auto gap-3">
                        <a class="sidebar-btn btn-dark col-6" href="javascript:void(0)" title="Login"
                            data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                        <a class="sidebar-btn btn-yellow col-6" href="/register">Register</a>
                    </div>
                @endguest
            </div>



            <ul id="menu-mobile-user" class="menu mt-3">
                <li id="menu-item-home" class="menu-item">
                    <a href="/">
                        <i class="far fa-home"></i>
                        Home
                    </a>
                </li>
                <li id="menu-item-exchange" class="menu-item">
                    <a href="/exchange">
                        <i class="far fa-sync-alt"></i>
                        Exchange
                    </a>
                </li>
                {{-- <li id="menu-item-shop" class="menu-item">
                    <a href="/shop/">
                        <i class="far fa-shopping-cart"></i>
                        Shop
                    </a>
                </li> --}}
                <li id="menu-item-shop" class="menu-item">
                    <a href="/shop/">
                        <i class="far fa-shopping-cart"></i>
                        Shop
                    </a>
                    <ul class="sub-menu ps-5">
                        <li class="menu-item">
                            <a href="/shop?metal=1183&type=bar">
                                Gold Bars
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="/shop?type=coin&metal=1183">Gold Coins</a>
                        </li>
                        <li class="menu-item">
                            <a href="/shop?type=bar&metal=1677">Silver Bars</a>
                        </li>
                        <li class="menu-item">
                            <a href="/shop?metal=1677&type=coin">Silver Coins</a>
                        </li>
                        <li class="menu-item">
                            <a href="/shop">Accessories</a>
                        </li>
                    </ul>
                </li>
                
                <!-- not show this if checkout -->
                @guest
                    {{-- <li id="menu-item-news" class="menu-item">
                        <a href="/news/">News</a>
                    </li> --}}
                    <li id="menu-item-liveprices" class="menu-item">
                        <a href="/live-prices/">
                            <i class="far fa-chart-line"></i>
                            Live Prices
                        </a>
                    </li>
                @else
                    <li class="menu-item menu-item-order-history">
                        <a class="oh" href="{{ route('orderHistory') }}">
                            <i class="far fa-history"></i>
                            Orders History
                        </a>
                    </li>
                    {{-- <li class="menu-item menu-item-funds">
                        <a class="oh" href="/funds">
                            <i class="far fa-money-bill-alt"></i>
                            Funds
                        </a>
                    </li>
                    <ul class="sub-menu">
                        <li class="menu-item menu-item-deposit sub-menu-item">
                            <a class="oh" href="/deposit">
                                <i class="far fa-money-bill-alt"></i>
                                Deposit
                            </a>
                        </li>
                        <li class="menu-item menu-item-withdraw sub-menu-item">
                            <a class="oh" href="/whitdraw">
                                <i class="far fa-money-bill-alt"></i>
                                Withdraw
                            </a>
                        </li>
                        <li class="menu-item menu-item-convert sub-menu-item">
                            <a class="oh" href="/convert">
                                <i class="far fa-money-bill-alt"></i>
                                Convert
                            </a>
                        </li>
                    </ul> --}}
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link ps-2 dropdown-toggle" href="#" id="fundsDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="far fa-wallet"></i> Funds
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="fundsDropdown">
                            <li>
                                <a class="dropdown-item" href="/deposit">
                                    <i class="fas fa-arrow-down"></i> Deposit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/whitdraw">
                                    <i class="fas fa-arrow-up"></i> Withdraw
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/convert">
                                    <i class="fas fa-exchange-alt"></i> Convert
                                </a>
                            </li>
                        </ul>
                    </li> --}}

                    <li class="menu-item menu-item-order-history">
                        <a class="oh" href="/funds">
                            <i class="far fa-wallet"></i>
                            Funds
                        </a>
                    </li>

                    <li class="menu-item menu-item-transaction-history">
                        <a class="th" href="/transaction-history">
                            <i class="far fa-history"></i>
                            Transactions
                        </a>
                    </li>
                    <li class="menu-item menu-item-my-account">
                        <a class="th" href="{{ route('account') }}" title="My Account">
                            <i class="far fa-user"></i>
                            Account
                        </a>
                    </li>
                    {{-- <li id="menu-item-news" class="menu-item">
                        <a href="/news">
                            <i class="far fa-newspaper"></i>
                            News
                        </a>
                    </li> --}}
                    <li id="menu-item-liveprices" class="menu-item">
                        <a href="/live-prices">
                            <i class="far fa-chart-line"></i>
                            Live Prices
                        </a>
                    </li>
                    {{-- <li>
                        <a class="d-none d-md-inline" title="Logout" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="far fa-sign-out-alt"></i>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li> --}}
                @endguest

                <li class="menu-item">
                    <a href="/refining/">
                        <i class="far fa-fire"></i>
                        Refining
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/faq/">
                        <i class="far fa-question-circle"></i>
                        FAQ
                    </a>
                </li>
            </ul>
        </div>
        <div class="gray-line"></div>
        <br>
        <ul id="own-menu" class="menu">
            <li class="menu-item">
                <a href="/cart">
                    <i class="far fa-shopping-cart"></i>
                    Cart
                </a>
            </li>
            @auth
                <li class="menu-item">
                    <a title="Logout" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        <i class="far fa-sign-out-alt"></i>
                        {{ __('Logout') }}
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endauth
        </ul>

        {{-- contact us --}}
        <div class="px-4 justify-content-center mt-3 row contact mt-auto">
            <div class="mx-2 row">
                <a class="sidebar-btn btn-yellow col-12 w-100 d-block search-container" href="/contact">Contact us</a>

                <a href="tel:1-844-504-4653" class="px-0 mt-3">
                    <i class="fas fa-phone-alt"></i>
                    1-844-504-4653
                </a>

                <a href="mailto:support@goldstock.com" class="text-transform-none px-0">
                    <i class="far fa-envelope"></i>
                    support@goldstock.com
                </a>
            </div>
        </div>
    </div>



</nav>
