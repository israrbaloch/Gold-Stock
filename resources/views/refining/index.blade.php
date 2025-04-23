@extends('header.index')

@section('extratitle')
    Refining
@endsection

@push('styles')
    <link href="{{ URL::to('/') }}/css/refining.css?ver=1.2.0" rel="stylesheet">
@endpush

@section('content')
    <div class="d-flex banner-img-container">
        <img class="banner-img" src="{{ asset('img/refining-img.png') }}" alt="Gold and Precious Metal Refinery Services">
        <h3 class="banner-text">
            Gold and Precious Metal
            Refinery Services
        </h3>
    </div>


    <div class="section-1">
        <div class="container">
            <div class="mx-lg-5 px-lg-5">
                <div class="mx-lg-5 px-lg-5">
                    <h2 class="section-title mb-4">Refining:</h2>
                    <p class="section-text">
                        <b>At GoldStock, we maximize the value of your precious metals.</b> Our expert refinery services
                        combine cutting-edge technology with decades of experience to deliver exceptional results.

                        <br>
                        <br>

                        We understand that efficient scrap reclamation is crucial to your bottom line. Our dedicated team
                        leverages advanced technology and proven processes to recover maximum value from your precious
                        metal-bearing materials. From bullion and sweep to complex industrial by-products, we handle a wide
                        range of materials with precision and care.
                        <br>
                        <br>

                        Our commitment to excellence extends beyond refining. Our rapid assay services provide real-time
                        insights into your precious metal holdings, empowering you to make informed decisions.
                        <br>
                        <br>
                        <b>Choose GoldStock as your trusted refining partner.</b> Benefit from our unmatched security,
                        personalized attention, and dedication to achieving optimal returns on your precious metal assets.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- section-2 --}}
    <section class="section-2 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row align-items-center justify-content-center text-md-start gap-3-lg">
                <!-- Image Section -->
                <div class="col-md-5">
                    <img src="{{ asset('img/gold-image.png') }}" alt="Gold Refining Process" class="img-fluid">
                </div>
                <!-- Text Section -->
                <div class="col-md-7 ps-lg-5 pt-lg-0 pt-4">
                    <h2 class="section-title mb-4">Refining process:</h2>
                    <p class="section-text">
                        Our refining process begins with the collection of raw materials, including gold scrap, jewelry, and
                        bullion. Through a series of meticulous processes, including melting, assaying, and purification, we
                        extract and refine precious metals to achieve the highest levels of purity. Our refinery utilizes
                        advanced technologies and techniques to maximize efficiency, accuracy, and environmental
                        sustainability throughout the refining process.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="services-section">
        <div class="container">
            <h2 class="section-title mb-5">Services Offered:</h2>
            <div class="row gy-4">
                <!-- Service 1 -->
                <div class="col-md-6 col-lg-6">
                    <div class="service-box d-flex align-items-start">
                        <div class="icon me-3">
                            <img src="{{ asset('img/ser-1.png') }}" alt="Gold Refining" class="">
                        </div>
                        <div>
                            <h5 class="">Gold Refining</h5>
                            <p>Our gold refining services encompass the refining of various forms of gold, including scrap, jewelry, and bullion. Whether you are a jeweler, manufacturer, or individual, we can refine your gold to the highest purity standards.</p>
                        </div>
                    </div>
                </div>
                <!-- Service 2 -->
                <div class="col-md-6 col-lg-6">
                    <div class="service-box d-flex align-items-start">
                        <div class="icon me-3">
                            <img src="{{ asset('img/ser-2.png') }}" alt="Custom Refining Solutions"
                                class="">
                        </div>
                        <div>
                            <h5 class="">Custom Refining Solutions</h5>
                            <p>We understand that every client has unique refining needs. That's why we offer custom refining solutions tailored to meet your specific requirements, including volume considerations, material specifications, and turnaround times.</p>
                        </div>
                    </div>
                </div>
                <!-- Service 3 -->
                <div class="col-md-6 col-lg-6">
                    <div class="service-box d-flex align-items-start">
                        <div class="icon me-3">
                            <img src="{{ asset('img/ser-3.png') }}" alt="Precious Metal Refining"
                                class="">
                        </div>
                        <div>
                            <h5 class="">Precious Metal Refining</h5>
                            <p>In addition to gold, we specialize in refining other precious metals, such as silver, platinum, and palladium. Our expertise extends to a wide range of precious metal materials, ensuring superior quality and consistency.</p>
                        </div>
                    </div>
                </div>
                <!-- Service 4 -->
                <div class="col-md-6 col-lg-6">
                    <div class="service-box d-flex align-items-start">
                        <div class="icon me-3">
                            <img src="{{ asset('img/ser-4.png') }}" alt="Environmental Compliance"
                                class="">
                        </div>
                        <div>
                            <h5 class="">Environmental Compliance</h5>
                            <p>At GoldStock, we are committed to environmental responsibility and sustainability. Our refinery adheres to strict environmental regulations and implements initiatives to minimize our environmental footprint, including waste reduction, energy efficiency, and responsible sourcing practices.</p>
                        </div>
                    </div>
                </div>
                <!-- Service 5 -->
                <div class="col-md-6 col-lg-6">
                    <div class="service-box d-flex align-items-start">
                        <div class="icon me-3">
                            <img src="{{ asset('img/ser-5.png') }}" alt="Assaying and Testing"
                                class="">
                        </div>
                        <div>
                            <h5 class="">Assaying and Testing</h5>
                            <p>We offer comprehensive assaying and testing services to accurately determine the purity and quality of precious metals. Our state-of-the-art laboratory facilities and experienced technicians ensure precise and reliable results for our clients.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-2 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row align-items-center justify-content-center text-md-start gap-3-lg">
                <!-- Image Section -->
                <div class="col-md-5">
                    <img src="{{ asset('img/section8.png') }}" alt="The Fire Assay Method" class="img-fluid">
                </div>
                <!-- Text Section -->
                <div class="col-md-7 ps-lg-5 pt-lg-0 pt-4">
                    <h2 class="section-title mb-4">The Fire Assay Method:</h2>
                    <p class="section-text">
                        An innovative method to give you the best Value for your Gold scraps and Precious Metals. The Fire Assay Method is centuries old, but it is still one of the most reliable methods for performing assays (to determine the metal content of a ore) of ores that contain precious (noble) metals - Gold, Silver and Platinum. Ore from the mine, or exploration sampling program is scientifically sampled using a statistically accurate method fitting the desired accuracy, it is then prepared by crushing, splitting and pulverizing. This is a process referred to as sample preparation.
                        <br>
                        <br>
                        Take advantage of our Latest Technology and modern machinery in assaying & refining. We will provide the most accurate assaying results. We have the latest and advanced Gold XRF analyzer system in the market. At Gold stock you can get an accurate assay for any of your precious metals within 90 seconds. Gold Stock ensures excellent customer service.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="services-section what-refine">
        <div class="container">
            <h2 class="section-title mb-5">What We Refine</h2>
            <div class="row gy-4">
                <!-- Column 1 -->
                <div class="col-md-6 col-lg-4">
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check"></i> Gold / Silver / Platinum Jewelry</li>
                        <li><i class="fas fa-check"></i> Mine</li>
                        <li><i class="fas fa-check"></i> Gold Nuggets</li>
                        <li><i class="fas fa-check"></i> Dental / Fillings</li>
                    </ul>
                </div>
                <!-- Column 2 -->
                <div class="col-md-6 col-lg-4">
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check"></i> Silver Antique Cutlery</li>
                        <li><i class="fas fa-check"></i> Indian Jewelry</li>
                        <li><i class="fas fa-check"></i> Silver 1 Dollar Coins (before 1967)</li>
                        <li><i class="fas fa-check"></i> Bench Sweeps</li>
                    </ul>
                </div>
                <!-- Column 3 -->
                <div class="col-md-6 col-lg-4">
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check"></i> Floor Sweeps</li>
                        <li><i class="fas fa-check"></i> Polishing Dust</li>
                        <li><i class="fas fa-check"></i> Casting Scrap</li>
                        <li><i class="fas fa-check"></i> Grindings</li>
                    </ul>
                </div>
            </div>
            <p class="mt-4"><em>*We don’t refine steel or other non-precious metals</em></p>
        </div>
    </section>

    <section class="section-2 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row align-items-center justify-content-center text-md-start gap-3-lg">
                <!-- Text Section -->
                <div class="col-md-7 pe-lg-5 pb-lg-0 pb-4">
                    <h2 class="section-title mb-4">Your Trusted Precious Metals Partner:</h2>
                    <p class="section-text">
                        We have highly liquid pool accounts. Our trading partners include Canadian and global bullion banks, major bullion traders, mutual and hedge funds and other investment houses. We receive deposits from various sources in North America including mines, jewelery manufacturers, scrap dealers and pawn shops, and high-grade industrial scrap dealers.
                        <br>
                        <br>
                        Over our next 100 years of history-making, we will continue to build on our achievements and entrench our position as a truly global industry leader. Going forward, we will strive harder and further – expanding our expertise exponentially, adding value beyond measure, exploring new and untapped markets and establishing key global partnerships and alliances.
                        <br>
                        <br>
                        We refine all Precious Metals and offer you the highest returns for your Gold, Silver, Platinum and Palladium (Scrap, jewelry, dental, mine, gold nuggets, dust, and more).
                    </p>
                </div>
                <!-- Image Section -->
                <div class="col-md-5">
                    <img src="{{ asset('img/trusted-partner.png') }}" alt="Gold Refining Process" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <section class="why-choose-us-section">
        <div class="container">
            <h2 class="section-title mb-5">Why Choose Us</h2>
            <div class="row gy-5 gx-10">
                <!-- Expertise and Experience -->
                <div class="col-md-6 col-lg-6">
                    <div class="align-items-start">
                        <div class="mb-4">
                            <img src="{{asset('img/choose-1.png')}}" alt="expertise and experience">
                        </div>
                        <div>
                            <h5 class="mb-2">Expertise and Experience</h5>
                            <p>With decades of experience in the refining industry, our team brings unparalleled expertise and knowledge to every project.</p>
                        </div>
                    </div>
                </div>
                <!-- State-of-the-Art Facilities -->
                <div class="col-md-6 col-lg-6">
                    <div class="align-items-start">
                        <div class="mb-4">
                            <img src="{{asset('img/choose-2.png')}}" alt="state-of-the-art facilities">
                        </div>
                        <div>
                            <h5 class="mb-2">State-of-the-Art Facilities</h5>
                            <p>Our refinery is equipped with the latest equipment, technology, and infrastructure to ensure optimal performance and reliability.</p>
                        </div>
                    </div>
                </div>
                <!-- Reliability and Trustworthiness -->
                <div class="col-md-6 col-lg-6">
                    <div class="align-items-start">
                        <div class="mb-4">
                            <img src="{{asset('img/choose-3.png')}}" alt="reliability and trustworthiness">
                        </div>
                        <div>
                            <h5 class="mb-2">Reliability and Trustworthiness</h5>
                            <p>We have built a reputation for reliability, transparency, and integrity in all aspects of our operations. Clients trust us to deliver consistent results and exceptional service.</p>
                        </div>
                    </div>
                </div>
                <!-- Customer Service -->
                <div class="col-md-6 col-lg-6">
                    <div class="align-items-start">
                        <div class="mb-4">
                            <img src="{{asset('img/choose-4.png')}}" alt="customer service">
                        </div>
                        <div>
                            <h5 class="mb-2">Customer Service</h5>
                            <p>At GoldStock, we prioritize customer satisfaction above all else. Our dedicated team is committed to providing personalized support, clear communication, and prompt assistance to meet our clients' needs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-2 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row align-items-center justify-content-center text-md-start gap-3-lg">
                <!-- Text Section -->
                <div class="col-md-7 pe-lg-5 pb-lg-0 pb-4">
                    <h2 class="section-title mb-4">Get in Touch:</h2>
                    <p class="section-text">
                        For more information about our gold and precious metal refinery services, or to discuss your specific refining needs, please contact us today. Our team is ready to assist you and provide tailored solutions to meet your requirements.
                        <br>
                        <br>
                        Our refinery is strategically located at <b>55 Dundas Street East, 3rd Floor, Toronto, Ontario, M5B 1C6</b>. Equipped with advanced technology and machinery, we adhere to the strictest industry standards for quality, integrity, and environmental responsibility. Our facility undergoes regular audits and certifications to ensure compliance with all relevant regulations.
                    </p>
                </div>
                <!-- Image Section -->
                <div class="col-md-5">
                    @include('map', ['height' => '440px'])
                </div>
            </div>
        </div>
    </section>
    
    
@endsection
