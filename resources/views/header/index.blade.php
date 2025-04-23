<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta name="google-site-verification" content="yDaaamHK7wVxdqspAcf0OLmlypFDZpDbz9uwKJ1faJM" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ URL::asset('favicon.ico') }}" type="image/x-icon" />

    @if (isset($metaTitle) && $metaTitle != null)
        <title>{{ $metaTitle }} </title>
    @else
        @if (View::hasSection('extratitle'))
            <title>
                @yield('extratitle') | Gold Stock Canada
            </title>
        @else
            <title>
                Gold Stock Canada - Bullion Dealer & Refiner
            </title>
        @endif
    @endif

    @if (isset($metaDescription) && $metaDescription != null)
        <meta name="description" content="{{ $metaDescription }}">
        {{-- @else
        <meta name="description"
            content="Gold Stock Canada is a leading bullion dealer and refiner. We buy & sell,  gold bars, gold coins, silver bars, silver coins. Order today!"> --}}
    @endif

    @if (isset($metaKeywords) && $metaKeywords != null)
        <meta name="keywords" content="{{ $metaKeywords }}">
    @endif

    <link rel="canonical" href="{{ url()->current() }}" />

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&family=Qwigley&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap"
        rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    {{-- CSS --}}
    <link href="{{ URL::to('/') }}/css/global.css?ver=1.1.4" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.10/sweetalert2.min.css"
        integrity="sha512-Of+yU7HlIFqXQcG8Usdd67ejABz27o7CRB1tJCvzGYhTddCi4TZLVhh9tGaJCwlrBiodWCzAx+igo9oaNbUk5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.10/sweetalert2.min.js"
        integrity="sha512-M60HsJC4M4A8pgBOj7oC/lvJXuOc9CraWXdD4PF+KNmKl8/Mnz6AH9FANgi4SJM6D9rqPvgQt4KRFR1rPN+EUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    {{-- Google Analytics --}}

    {{-- Google Consent Mode --}}
    @if (env('APP_ENV') == 'production')
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-P7VSBBD9H0"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-P7VSBBD9H0');
        </script>

        {{-- <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="29f87a0c-3385-47a3-b013-4bb54807ee34"
            data-blockingmode="auto" type="text/javascript"></script> --}}

        <script src="https://apis.google.com/js/platform.js?onload=renderBadge" async defer></script>

        <script>
            window.renderBadge = function() {
                var ratingBadgeContainer = document.createElement("div");
                document.body.appendChild(ratingBadgeContainer);
                window.gapi.load('ratingbadge', function() {
                    window.gapi.ratingbadge.render(ratingBadgeContainer, {
                        "merchant_id": 5335797916
                    });
                });
            }
            window.___gcfg = {
                lang: 'en_US'
            };
        </script>
    @endif

    {{-- Google Merchant --}}


    {{-- <script src="https://js.sentry-cdn.com/b71ca6da88eedead750559359b29f786.min.js" crossorigin="anonymous"></script> --}}

    @php
        $env = app()->environment();
        $currency = Cookie::get('currency');
        $routename = Request::route()->uri;
        $wsPort = env('WEBSOCKETS_PORT', 6001);

        if ($currency == null) {
            Cookie::queue('currency', 'CAD');
            $currency = 'CAD';
        }

    @endphp
    {{-- Custom JS --}}
    <script type="text/javascript">
        window.app = window.app || {};
        // TODO: Remove this
        window.appenv = "{{ $env }}";
        window.app.env = "{{ $env }}";
        window.app.currency = "{{ $_currency }}";
        window.app.currencyRate = @json($_currencyRate);
        window.app.wsPort = "{{ $wsPort }}";

        // Currencies
        const currencies = [];
        @foreach ($_currencies as $k => $v)
            currencies['{{ $k }}'] = @json($v);
        @endforeach
        window.app.currencies = currencies;

        // User Balances
        const userBalances = [];
        @foreach ($_userBalances as $k => $v)
            userBalances['{{ $k }}'] = '{{ $v }}';
        @endforeach
        window.app.balances = userBalances;

        // Metals
        const metals = [];
        @foreach ($_metals as $k => $v)
            metals['{{ $k }}'] = @json($v);
        @endforeach
        window.app.metals = metals;
    </script>

    <script src="{{ asset('/js/global.js') }}"></script>
    {{-- <script src="{{ asset('/js/login.js') }}"></script> --}}
    <script src="{{ asset('/js/prices/index.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('/') }}/js/jquery-dateformat.min.js?ver=1.2.0"></script>

    {{-- <script>
        // on ready
        // $(document).ready(function() {
        //     $('#language-selector').on('change', function () {
        //     var selectedLang = $(this).val();
        //     // Reload the page with selected language
        //     window.location.href = "?lang=" + selectedLang;
        // });
        // });
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: "en",
                includedLanguages: "en,fr,es,ar", // Define supported languages
                autoDisplay: true
            }, 'google_translate_element');
        }

        // googleTranslateElementInit();
    </script>
    
    <!-- Google Translate API -->
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> --}}
    @stack('styles')
</head>

<body id="top" data-currency="{{ $currency }}" class="{{ $routename }}">
    @php
        $userId = auth()->user() ? auth()->user()->id : 0;
    @endphp

    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                @include('header-prices')
                @include('header.body')

                @if (\Session::has('cart-success'))
                    <script>
                        $(function() {
                            var msg = '{{ Session::get('cart-success') }}';
                            alert(msg);
                        });
                    </script>
                @endif
                @if (auth()->user() && !auth()->user()->has_email)
                    @php Session::put('user_2fa', auth()->user()->id); @endphp
                @endif
                @if (auth()->user() && !Session::has('user_2fa'))
                    @php auth()->logout(); @endphp
                    <script>
                        location.reload();
                    </script>
                @endif

                @include('header.sidebar')

                @yield('content')

                @include('header.login-modal')

                @php
                    $_footer = isset($footer) ? $footer : true;
                @endphp
                @if ($_footer == true)
                    @include('footer')
                @endif

                <script>
                    // $('.search').on('click', function() {
                    //     $('#searchModal').modal('show');
                    // });

                    // .search-lg toggle #search

                    $('.search-lg').on('click', function() {
                        $('.input-div-lg').toggle();

                    });

                    $('.search-md').on('click', function() {
                        $('.search-md-input').toggle();
                    });

                    // search-lg-input key up search ajax
                    $('.search-lg-input').on('keyup', function() {
                        var search = $(this).val();
                        if (search.length > 2) {
                            $.ajax({
                                url: '/search',
                                type: 'GET',
                                data: {
                                    search: search
                                },
                                success: function(data) {
                                    $('.search-results-lg').html(data.html);
                                }
                            });
                        } else {
                            $('.search-results-lg').html('');
                        }
                    });

                    // .search-md-input
                    $('.search-md-input').on('keyup', function() {
                        var search = $(this).val();
                        if (search.length > 2) {
                            $.ajax({
                                url: '/search',
                                type: 'GET',
                                data: {
                                    search: search
                                },
                                success: function(data) {
                                    $('.search-results-md').html(data.html);
                                }
                            });
                        } else {
                            $('.search-results-md').html('');
                        }
                    });

                    // on #loginModal show hide the #sidebar
                    $('#loginModal').on('show.bs.modal', function() {
                        $('#sidebar').hide();
                    });
                </script>

                <script>
                    $(document).ready(function() {
                        @if (session()->has('login-modal'))
                            $('#loginModal').modal('show');
                        @endif
                    });

                    @if (session('review_submit'))
                        Swal.fire({
                            icon: 'success',
                            title: 'Thank you!',
                            text: '{{ session('review_submit') }}',
                            confirmButtonColor: '#ffd805',
                            customClass: {
                                confirmButton: 'button px-5 py-2 border-0 box-shadow-0'
                            }
                        });
                    @endif
                </script>


                <script type="text/javascript"
                    src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
                <script type="text/javascript" src="{{ URL::to('/') }}/js/home.js?ver=1.2.0"></script>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"
                    integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A=="
                    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

                <script>
                    $(document).ready(function() {
                        $('.slider-product').slick({
                            dots: false,
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            arrows: true,
                            autoplay: true,
                            autoplaySpeed: 3000,
                            infinite: true,
                            // speed: 400,
                            fade: false, // Use "false" for multi-slide layouts
                            // cssEase: 'linear',
                            lazyLoad: 'ondemand',
                            prevArrow: '<button class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
                            nextArrow: '<button class="slick-next"><i class="fas fa-chevron-right"></i></button>',
                            responsive: [{
                                breakpoint: 600, // For screens 768px or smaller
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    arrows: true,
                                    dots: false
                                }
                            }]
                        });
                    });

                    // notificationsDropdownMobile, notificationsDropdown click ajax call
                    $('#notificationsDropdownMobile, #notificationsDropdown').on('click', function() {
                        $.ajax({
                            url: '/notifications/mark-all-read',
                            type: 'GET',
                            success: function(data) {
                                // none
                            }
                        });
                    });
                </script>
                @stack('scripts')
            </div>
        </div>
    </div>
</body>
