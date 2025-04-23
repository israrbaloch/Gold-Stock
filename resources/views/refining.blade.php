@extends('header.index')

@section('extratitle')
    Refining
@endsection

@push('links')
    <link href="{{ URL::to('/') }}/css/refining.css?ver=1.3.0" rel="stylesheet">
@endpush

@section('content')
    <div class="header-slider-like d-none d-md-flex">
        <img class="header-img-slider-like" src="{{ URL::to('/') }}/img/refining/main-banner.jpg" alt="">
    </div>

    <div class="page-container container main">

        <div class="row d-md-none">
            <div class="mobile-title col-12 text-center color-dark-green">
                <b>REFINING</b>
            </div>
        </div>

        <div class="row g-0">
            <div class="col-12 col-md-6 min-h d-md-none">
                <div class="full-img">
                    <img class="ref-img d-none d-md-inline" src="{{ URL::to('/') }}/img/refining/what-we-refine.jpg"
                        alt="what we refine">
                    <img class="ref-img d-md-none" src="{{ URL::to('/') }}/img/refining/mobile/what-we-refine.jpg"
                        alt="what we refine">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="text-box left">
                    <div class="row g-0">
                        <div class="col-12">
                            <div class="text">
                                <div class="list-item">
                                    <img src="{{ URL::to('/') }}/img/refining/icon-circle.png" alt="icon circle">
                                    Gold / Silver / Platinum Jewelry
                                </div>
                                <div class="list-item">
                                    <img src="{{ URL::to('/') }}/img/refining/icon-circle.png" alt="icon circle">
                                    Mine
                                </div>
                                <div class="list-item">
                                    <img src="{{ URL::to('/') }}/img/refining/icon-circle.png" alt="icon circle">
                                    Gold Nuggets
                                </div>
                                <div class="list-item">
                                    <img src="{{ URL::to('/') }}/img/refining/icon-circle.png" alt="icon circle">
                                    Dental / Fillings
                                </div>
                                <div class="list-item">
                                    <img src="{{ URL::to('/') }}/img/refining/icon-circle.png" alt="icon circle">
                                    Silver antique cutlery
                                </div>
                                <div class="list-item">
                                    <img src="{{ URL::to('/') }}/img/refining/icon-circle.png" alt="icon circle">
                                    Indian Jewelry
                                </div>
                                <div class="list-item">
                                    <img src="{{ URL::to('/') }}/img/refining/icon-circle.png" alt="icon circle">
                                    Silver 1 Dollar Coins ( before 1967)
                                </div>
                                <div class="list-item">
                                    <img src="{{ URL::to('/') }}/img/refining/icon-circle.png" alt="icon circle">
                                    Bench sweeps
                                </div>
                                <div class="list-item">
                                    <img src="{{ URL::to('/') }}/img/refining/icon-circle.png" alt="icon circle">
                                    Floor sweeps
                                </div>
                                <div class="list-item">
                                    <img src="{{ URL::to('/') }}/img/refining/icon-circle.png" alt="icon circle">
                                    Polishing dust
                                </div>
                                <div class="list-item">
                                    <img src="{{ URL::to('/') }}/img/refining/icon-circle.png" alt="icon circle">
                                    Casting scrap
                                </div>
                                <div class="list-item">
                                    <img src="{{ URL::to('/') }}/img/refining/icon-circle.png" alt="icon circle">
                                    Grindings
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <br class="d-md-none"><br class="d-md-none">
                            <br>
                            <div class="title">What we don't refine:</div>
                            <div class="text">
                                <div class="list-item">
                                    <img src="{{ URL::to('/') }}/img/refining/icon-circle.png" alt="icon circle">
                                    Steel or other non precious metals
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 min-h d-none d-md-flex">
                <div class="full-img">
                    <img class="ref-img d-none d-md-inline" src="{{ URL::to('/') }}/img/refining/what-we-refine.jpg"
                        alt="what we refine">
                    <img class="ref-img d-md-none" src="{{ URL::to('/') }}/img/refining/mobile/what-we-refine.jpg"
                        alt="what we refine">
                </div>
            </div>
        </div>



        <div class="row g-0 bg-b">
            <div class="col-12">
                <div class="text-box help-text">
                    <div class="text white">
                        <b>Refining</b>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 min-h">
                <div class="text-box left">
                    <div class="text white">
                        While technology plays an important role in evaluation and refining proficiency, fair and rapid
                        scrap reclamation is critical to every customer's bottom line. At Gold Stock, we understand and
                        respect this reality, and are committed to providing the necessary manpower, technology and
                        expertise to ensure you receive timely settlements and maximum recovery.
                        <br><br>
                        With Gold Stock refining services, you are assured of the utmost security, accurate results and the
                        most critical element personal care and attention.
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 min-h">
                <div class="text-box right">
                    <div class="text white">
                        Gold Stock has the ability to treat all types of bullion, sweep and by-products of gold, silver,
                        platinum and palladium. In addition to our bullion and sweeps services, we offer other special
                        services to the dental and industrial sectors.
                        <br><br>
                        In addition to our refining services, we offer assay services for all precious metal elements. We
                        can provide assays for gold & silver metallic within minutes, to help you maintain the quality
                        assurance and inventory control programs that are essential for your business.
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="refining-white-line"></div>
            </div>
            <div class="col-12">
                <div class="text-box">
                    <div class="text white text-center">
                        <b>Gold Stock Refining Service and Payout</b>
                        <br>
                        For your Gold Refining
                        <br>
                        we offer highest return from your
                        <br>
                        Scrap Gold, Silver, Platinum and Palladium.
                        <br><br><br>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-0">
            <div class="col-12 col-md-6 min-h">
                <div class="full-img">
                    <img class="ref-img d-none d-md-inline" src="{{ URL::to('/') }}/img/refining/refinery-services-2.jpg"
                        alt="refinery services">
                    <img class="ref- d-md-none" src="{{ URL::to('/') }}/img/refining/mobile/refinery-services-2.jpg"
                        alt="refinery services">
                </div>
            </div>
            <div class="col-12 col-md-6 min-h">
                <div class="text-box right">
                    <div class="title">
                        An innovative method to give you the best Value for your Gold scraps and Precious Metals.
                    </div>
                    <div class="text">
                        The Fire Assay Method is centuries old, but it is still one of the most reliable methods for
                        performing assays (to determine the metal content of a ore) of ores that contain precious (noble)
                        metals - Gold, Silver and Platinum. Ore from the mine, or exploration sampling program is
                        scientifically sampled using a statistically accurate method fitting the desired accuracy, it is
                        then prepared by crushing, splitting and pulverizing. This is a process referred to as sample
                        preparation.
                        <br><br>
                        Take advantage of our Latest Technology and modern machinery in assaying & refining.
                        We will provide the most accurate assaying results. We have the latest and advanced Gold XRF
                        analyzer system in the market. At Gold stock you can get an accurate assay for any of your precious
                        metals within 90 seconds. Gold Stock ensures excellent customer service.
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-0 bg-1">
            <div class="col-12 col-md-6 min-h">
                <div class="full-img">
                    <img class="ref-img d-none d-md-inline" src="{{ URL::to('/') }}/img/refining/refinery-services.jpg"
                        alt="refinery services">
                    <img class="ref-img d-md-none" src="{{ URL::to('/') }}/img/refining/mobile/refinery-services.jpg"
                        alt="refinery services">
                </div>
            </div>
            <div class="col-12 col-md-6 min-h">
                <div class="text-box right">
                    <div class="text">
                        We have highly liquid pool accounts. Our trading partners include Canadian and global bullion banks,
                        major bullion traders, mutual and hedge funds and other investment houses. We receive deposits from
                        various sources in North America including mines, jewellery manufacturers, scrap dealers
                        and pawn shops, and high-grade industrial scrap dealers.
                        <br><br>
                        Over our next 100 years of history-making, we will continue to build on our achievements and
                        entrench our position as a truly global industry leader. Going forward, we will strive harder and
                        further – expanding our expertise exponentially, adding value beyond measure, exploring new and
                        untapped markets and establishing key global partnerships and alliances.
                        <br><br>
                        We refine all Precious Metals and offer you the highest returns for your Gold
                        <br><br>
                        Silver, Platinum and Palladium
                        <br>
                        scrap/jewelry/dental/mine/gold nuggets/dust/ and more
                    </div>
                </div>
            </div>
        </div>
        <br class="d-md-none">
        <br class="d-md-none">
    </div>
@endsection
