@extends('header.index')

@section('extratitle')
    About Us
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/aboutus.css') }}">
@endpush

{{-- @push('scripts')
    <script type="text/javascript" src="{{ URL::to('/') }}/js/faq.js?ver=1.3.0"></script>
@endpush --}}


@section('content')
    <div class="main-div">

        <section class="hero text-white py-5 position-relative overlay d-flex align-items-center">
            <img src="/img/aboutus.png" alt="About Us" class="img-fluid w-100 h-100 position-absolute top-0 start-0">
            <div class="container position-relative d-flex align-items-center h-100">
                <div class="row w-100">
                    <div class="col-lg-6 text-left d-flex">
                        <div class="my-auto">
                            <h2 class="fw-bold">GOLD STOCK CANADA</h2>
                            <p>
                                At Gold Stock Canada, we bring decades of expertise
                                and a global perspective to the Canadian precious
                                metals market. Whether you're a seasoned investor,
                                a jeweller, or just beginning your journey with gold,
                                we provide access to premium bullion products,
                                expert refining services, and innovative solutions
                                for wealth building.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <section class="who-we-are">
            <div class="container">
                <div class="row col-md-12 align-items-center">
                    <div class="col-lg-4 d-flex mb-md-0 mb-5">
                        <img src="/img/who-we-are.png" alt="About Us" class="img-fluid">
                    </div>
                    <div class="col-lg-8 ps-lg-5">
                        <h3 class="h3-title mb-4">Who We Are:</h3>

                        <p>
                            Gold Stock Canada is a leading bullion dealer
                            and gold refinery based in Toronto. Since 2009,
                            we’ve been dedicated to serving Canadians with
                            exceptional service, unmatched expertise, and a
                            commitment to trust and transparency.
                        </p>
                        <p class="mt-4">
                            With a strong focus on making precious metal
                            investments accessible, we’ve grown into a
                            trusted name in bullion trading and refining,
                            serving jewellers, businesses, and individuals
                            across Canada.
                        </p>
                    </div>
                </div>
        </section>

        <section class="services">
            <div class="container">
                <h3 class="h3-title text-left">What We Do:</h3>
                <p>
                    At Gold Stock Canada, we offer a comprehensive range of services to meet the diverse needs of our
                    customers:
                </p>
                <div class="row px-lg-5">
                    <div class="col-md-6 d-flex align-items-stretch">
                        <div class="service-box w-100">
                            <img src="/img/service-1.png" alt="Bullion Sales">
                            <h5>Bulllion Sales</h5>
                            <p>Premium gold and silver bars, coins, and more.</p>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-stretch">
                        <div class="service-box w-100">
                            <img src="/img/service-2.png" alt="Refining Services">
                            <h5>Refining Services</h5>
                            <p>Trusted gold and precious metal refining for jewellers, investors, and businesses.</p>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-stretch">
                        <div class="service-box w-100">
                            <img src="/img/service-3.png" alt="Accumulation Plans">
                            <h5>Accumulation Plans</h5>
                            <p>A unique approach to help clients accumulate gold in small, manageable amounts.</p>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-stretch">
                        <div class="service-box w-100">
                            <img src="/img/service-4.png" alt="Market Insights">
                            <h5>Market Insights</h5>
                            <p>Stay updated with live gold prices and expert analysis through our website.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="why-choose">
            <div class="container">
                <h3 class="h3-title">Why Choose <br> Gold Stock Canada?</h3>
                <p>We understand the importance of trust and reliability in the precious metals industry. Here’s why
                    thousands of Canadians choose us as their preferred bullion dealer and refiner:</p>
                <ul class="list-unstyled ps-lg-5">
                    <li>Over a decade of expertise in bullion trading and refining.</li>
                    <li>Competitive pricing and exceptional quality on all products.</li>
                    <li>Trusted by jewellers, businesses, and investors nationwide.</li>
                    <li>Transparent live price updates directly on our website.</li>
                    <li>Centrally located in Toronto, with services available nationwide.</li>
                </ul>
            </div>
        </section>

        <section class="testimonials">
            <div class="container">
                <h3 class="h3-title">Customer Testimonials</h3>
                <div class="row mt-5">
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="testimonial-box w-100">
                            <img src="/img/testimonial-1.png" alt="Sarah L." class="testimonial-img">
                            <div class="stars">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fa fa-star"></i>
                                @endfor
                            </div>
                            <p>Gold Stock Canada made my gold investment seamless and stress-free. Their transparency and
                                professionalism are unmatched."</p>
                            <strong>Sarah L., Toronto</strong>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="testimonial-box w-100">
                            <img src="/img/testimonial-2.png" alt="Ahmed H." class="testimonial-img">
                            <div class="stars">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fa fa-star"></i>
                                @endfor
                            </div>
                            <p>As a jeweller, I rely on Gold Stock Canada’s refining services. Their quality and consistency
                                make them my go-to partner."</p>
                            <strong>Ahmed H., Vancouver</strong>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="testimonial-box w-100">
                            <img src="/img/testimonial-3.png" alt="Sarah L." class="testimonial-img">
                            <div class="stars">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fa fa-star"></i>
                                @endfor
                            </div>
                            <p>Gold Stock Canada made my gold investment seamless and stress-free. Their transparency and
                                professionalism are unmatched."</p>
                            <strong>Sarah L., Toronto</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
@endsection
