<header id="header" class="header-new">
    <input type="hidden" id="gluid" value="{{ $userId }}">
    <div class="container- ">
        <div class="new-logo-container">
            {{-- Logo --}}
            <a class="header-logo-container" href="/">
                <img class="logo" src="{{ asset('img/main-logo.png') }}" alt="goldstock">
                {{-- <img class="link" src="{{ asset('img/link.png') }}" alt="goldstock"> --}}
                <br class="d-md-none">
                <div class="title bold d-none d-lg-inline-block">
                    {{-- <h1>BULLION DEALER & REFINER</h1> --}}
                </div>
            </a>
            <nav>
                <ul id="menu-desktop-public">
                    {{-- Links --}}
                    <li id="menu-item-exchange" class="menu-item">
                        <a href="/exchange">Exchange</a>
                    </li>
                    <li id="menu-item-shop" class="menu-item">
                        <a href="/shop">Shop</a>
                    </li>
                    {{-- <li id="menu-item-news" class="menu-item">
                        <a href="/news/">News</a>
                    </li>
                    <li id="menu-item-blog" class="menu-item">
                        <a href="/blog/">Blog</a>
                    </li> --}}
                    <li id="menu-item-liveprices" class="menu-item">
                        <a href="/live-prices">Live Prices</a>
                    </li>
                    <li id="menu-item-support" class="menu-item">
                        <a href="/contact">Support</a>
                    </li>
                    <li id="menu-item-refining" class="menu-item">
                        <a href="/refining">Refining</a>
                    </li>
                    <li id="menu-item-faq" class="menu-item">
                        <a href="/faq">FAQ</a>
                    </li>
                </ul>
            </nav>

            <div class="right d-flex">

                {{-- search --}}
                <div class="search-container d-lg-flex d-none my-auto">
                    <div class="input-div-lg" style="display: none">
                        <input type="text" class="search-lg-input" id="search" placeholder="Search">

                        {{-- search results --}}
                        <div class="search-results-lg">
                        </div>
                    </div>
                    <a href="#" class="search-lg">
                        <i class="fa fa-search"></i>
                    </a>
                </div>

                @auth
                    <div class="nav-item dropdown d-none d-md-flex nots me-4">
                        <a class="nav-link dropdown-toggle d-flex p-0 my-auto" href="#" id="notificationsDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell fs-3 text-dark my-auto"></i>
                            @php
                                $unreadNotifications = Auth::user()->unreadNotifications->count();
                            @endphp
                            @if ($unreadNotifications > 0)
                                <span
                                    class="badge bg-danger rounded-pill position-absolute top-0 translate-middle start-100"
                                    id="notif-count">{{ Auth::user()->unreadNotifications->count() }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end not-list" aria-labelledby="notificationsDropdown">
                            @foreach (Auth::user()->unreadNotifications as $notification)
                                <div class="not-item d-flex justify-content-between">
                                    <div class="px-2">
                                        <div class="dropdown-item-">
                                            {{ $notification->data['message'] }}
                                        </div>
                                        {{-- time ago --}}
                                        <div class="dropdown-item- text-muted">
                                            <small>{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <form action="{{ route('alert.markAsRead') }}" class="my-auto" method="POST">
                                        @csrf
                                        <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                                        <button type="submit" class="btn btn-link">
                                            @if ($notification->read_at == null)
                                                <i class="fa fa-envelope"></i>
                                            @else
                                                <i class="fa fa-envelope-open"></i>
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                            @if (Auth::user()->unreadNotifications->count() == 0)
                                <div><a class="dropdown-item text-center">No new notifications</a></div>
                            @endif
                        </div>
                    </div>
                @endauth

                {{-- Cart --}}
                <div class="custom-shopping-cart d-none d-md-flex">
                    <a class="th text-bold cart" href="/cart">
                        <div class="cart-quantity">
                            0
                        </div>
                        <img src="/img/icons/shopping-cart.png" alt="Shopping cart">
                    </a>
                </div>

                {{-- User --}}
                <div id="user-account-links" class="my-auto">

                    <!-- not show this if checkout -->
                    @guest
                        {{-- @if (Route::has('login'))
                            <a class="my-account-login-btn d-none d-md-inline" href="/login" title="Login">Login</a>
                        @endif --}}

                        {{-- data-bs-toggle="modal" data-bs-target="#loginModal" --}}
                        <a class="my-account-login-btn d-none d-md-inline" href="javascript:void(0)" title="Login"
                            data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>

                        @if (Route::has('register'))
                            <a class="d-none d-md-inline register" href="/register" title="Register">Sign Up</a>
                        @endif
                    @else
                        <a class="my-account-login-btn history-hover-trigger d-none d-md-inline"
                            href="{{ route('account') }}" title="My Account">
                            <img class="account-icon" src="/img/icons/account.png" alt="Account">
                        </a>
                        <div class="history-hover" style="display: none;">
                            <a class="th" href="{{ route('account') }}">
                                <img class="account-icon" src="/img/icons/account.png" alt="Account">
                                My Account
                            </a>
                            <a class="th" href="/transaction-history">
                                <img src="/img/icons/transactions.png" alt="Transactions">
                                Transactions
                            </a>
                            <a class="oh" href="{{ route('orderHistory') }}">
                                <img src="/img/icons/orders.png" alt="Orders">
                                Orders
                            </a>
                            <a class="oh" href="/funds">
                                <img src="/img/icons/funds.png" alt="Funds">
                                Funds
                            </a>
                            <a class="oh" title="Logout" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <img src="/img/logout.png" alt="Funds" width="24px" style="padding: 2px">
                                {{ __('Logout') }}
                            </a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>

            {{-- Mobile Button --}}
            <div class="d-flex d-md-none">
                <div class="mobile-menu-buttons">
                    @auth
                        <div class="nav-item dropdown nots me-4">
                            <a class="nav-link- dropdown-toggle p-0 d-flex" href="#" id="notificationsDropdownMobile"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell fs-3 text-dark my-auto"></i>
                                @php
                                    $unreadNotifications = Auth::user()->unreadNotifications->count();
                                @endphp
                                @if ($unreadNotifications > 0)
                                    <span
                                        class="badge bg-danger rounded-pill position-absolute top-0 translate-middle start-100"
                                        id="notif-count">{{ Auth::user()->unreadNotifications->count() }}</span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end not-list" aria-labelledby="notificationsDropdownMobile">
                                @foreach (Auth::user()->unreadNotifications as $notification)
                                    <div class="not-item d-flex justify-content-between">
                                        <div class="px-2">
                                            <div class="dropdown-item-">
                                                {{ $notification->data['message'] }}
                                            </div>
                                            {{-- time ago --}}
                                            <div class="dropdown-item- text-muted">
                                                <small>{{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <form action="{{ route('alert.markAsRead') }}" method="POST" class="my-auto">
                                            @csrf
                                            <input type="hidden" name="notification_id"
                                                value="{{ $notification->id }}">
                                            <button type="submit" class="btn btn-link">
                                                @if ($notification->read_at == null)
                                                    <i class="fa fa-envelope"></i>
                                                @else
                                                    <i class="fa fa-envelope-open"></i>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                                @if (Auth::user()->unreadNotifications->count() == 0)
                                    <div><a class="dropdown-item text-center">No new notifications</a></div>
                                @endif
                            </div>
                        </div>
                    @endauth
                    {{-- <div class="search-container">
                        <a href="#" class="search-md">
                            <i class="fa fa-search"></i>
                        </a>
                    </div> --}}
                    <a class="th text-bold cart" href="/cart">
                        <div class="cart-quantity d-none">
                            {{-- totalQuantity --}}
                        </div>
                        <img src="/img/icons/shopping-cart.png" alt="Shopping cart">
                    </a>
                    <span id="mobile-sidebar-button" class="navbar-toggler pe-0">
                        <img src="/img/hamburger-menu.png" class="navbar-toggler-icon-img" alt="menu icon">
                    </span>
                </div>
            </div>
        </div>
    </div>

</header>
