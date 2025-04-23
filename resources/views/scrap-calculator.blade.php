@extends('header.index')

@section('extratitle')
    News
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/scrap_calculator.css') }}">
@endpush

@push('scripts')
    <script src="{{ mix('js/scrap_calculator.js') }}" defer></script>
@endpush

@php
    $currency = Cookie::get('currency');
    $routename = Request::route()->uri;

    if ($currency == null) {
        Cookie::queue('currency', 'CAD');
        $currency = 'CAD';
    }

@endphp

@section('content')
    @include('header.utils')
    <div class="main-div">

        <!-- 📌 Calculator Section -->
        <div class="container">
            <section class="calculator-section">
                <h1>Scrap Precious Metals Calculator</h1>
                <p>
                    Utilize our scrap calculator to swiftly estimate the value of your gold, silver, platinum, or palladium
                    items. By inputting the metal type, weight, and purity, you can determine the potential worth based on
                    current market prices.
                </p>
    
                <div class="calculator-container">
                    <h2>Accurately Calculate the Value of Your Scrap Precious Metals</h2>
    
                    {{-- hidden current values in ounces --}}
                    <input type="hidden" id="goldValue" value="{{ $_metals['gold']->value }}">
                    <input type="hidden" id="silverValue" value="{{ $_metals['silver']->value }}">
                    <input type="hidden" id="platinumValue" value="{{ $_metals['platinum']->value }}">
                    <input type="hidden" id="palladiumValue" value="{{ $_metals['palladium']->value }}">
                    <input type="hidden" id="currencyValue" value="{{ $_currencies[$_currency]->value }}">
                    <input type="hidden" id="currency" value="{{ $currency }}">

                    {{-- admin commission for all metals --}}
                    <input type="hidden" id="CommissionGold" value="{{ $commission['gold'] }}">
                    <input type="hidden" id="CommissionSilver" value="{{ $commission['silver'] }}">
                    <input type="hidden" id="CommissionPlatinum" value="{{ $commission['platinum'] }}">
                    <input type="hidden" id="CommissionPalladium" value="{{ $commission['palladium'] }}">
    
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="metal">Metal</label>
                            <select id="metal" class="form-select">
                                <option value="Gold">Gold</option>
                                <option value="Silver">Silver</option>
                                <option value="Platinum">Platinum</option>
                                <option value="Palladium">Palladium</option>
                            </select>
                        </div>
    
                        <div class="col-md-3">
                            <label for="weight">Weight</label>
                            <input type="number" id="weight" class="form-control" min="0.1" step="0.1"
                                value="1">
                        </div>
    
                        <div class="col-md-3">
                            <label for="purity">Purity</label>
                            <select id="purity" class="form-select">
                            </select>
                        </div>
    
                        <div class="col-md-3">
                            <label for="unit">Unit of Measurement</label>
                            <select id="unit" class="form-select">
                                <option value="Grams">Grams</option>
                                <option value="Ounces">Ounces</option>
                            </select>
                        </div>
                    </div>
    
                    <hr>
    
                    <div class="col-md-12 row">
                        <div class="col-md-6 text-center">
                            <button id="calculateBtn" class="btn btn-primary mt-3">Calculate</button>
                        </div>
    
                        <div class="col-md-6">
                            <div class="result mt-3 text-center">
                                <h4>Estimated Value: <span id="estimatedValue">0.00 CAD</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- 📌 How to Use Section -->
        <section class="info-section">
            <div class="container">
                <div class="col-md-12 row align-items-center">
                    <div class="col-md-6">
                        <h3>How to Use the Calculator?</h3>
                        <p><strong>Select Metal Type:</strong> Choose from gold, silver, platinum, or palladium.</p>
                        <p><strong>Enter Weight:</strong> Input the item's weight in grams.</p>
                        <p><strong>Specify Purity:</strong> Enter the metal's purity percentage (e.g., 24K gold is 99.9%
                            pure).</p>
                        <p><strong>Calculate Value:</strong> The calculator will display the estimated value based on live
                            market rates.</p>
                    </div>
                    <div class="col-md-6">
                        <div class="scrap-prices">
                            <p class="scrap-title"><em>Today's scrap Prices..</em></p>
                            <p class="scrap-date"><em>{{ date('l, jS, F Y') }}</em></p>

                            <div class="price-table">
                                <div class="price-row gold">
                                    <span class="metal">GOLD</span>
                                    <span class="price">
                                        @php
                                            echo '$' . addCommas($_metals['gold']->value * $_currencies[$_currency]->value);
                                        @endphp
                                        {{ $currency }}
                                        per ounce
                                    </span>
                                </div>

                                <div class="price-row silver">
                                    <span class="metal">SILVER</span>
                                    <span class="price">
                                        @php
                                            echo '$' . addCommas($_metals['silver']->value * $_currencies[$_currency]->value);
                                        @endphp
                                        {{ $currency }}
                                        PER OUNCE
                                    </span>
                                </div>

                                <div class="price-row platinum">
                                    <span class="metal">PLATINUM</span>
                                    <span class="price">
                                        @php
                                            echo '$' . addCommas($_metals['platinum']->value * $_currencies[$_currency]->value);
                                        @endphp
                                        {{ $currency }}
                                        PER OUNCE
                                    </span>
                                </div>

                                <div class="price-row palladium">
                                    <span class="metal">PALLADIUM</span>
                                    <span class="price">
                                        @php
                                            echo '$' . addCommas($_metals['palladium']->value * $_currencies[$_currency]->value);
                                        @endphp
                                        {{ $currency }}
                                        PER OUNCE
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="purity-section">
            <div class="container">
                <div class="col-md-12 row align-items-center">
                    <div class="col-md-6">
                        <h3>Understanding Purity Levels:</h3>
                        <p><strong>Gold:</strong> Measured in karats; common purities include 24K (99.9%), 18K (75%), and
                            14K (58.5%).</p>
                        <p><strong>Silver:</strong> Sterling silver is typically 92.5% pure.</p>
                        <p><strong>Platinum & Palladium:</strong> Often 95% pure.</p>
                        <p><strong>Tip:</strong> Look for hallmarks or stamps on jewelry indicating purity.</p>
                    </div>
                    <div class="col-md-6 px-lg-5 text-center">
                        <img src="/img/tips.png" alt="Purity Levels" class="img-fluid">
                    </div>

                </div>
            </div>
        </section>

        {{-- additional-services --}}
        <section class="additional-services">
            <div class="container">
                <h3 class="text-center fw-bold">Additional Services</h3>
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="service-box">
                            <img src="/img/additional-1.jpeg" alt="Highlight related offerings" class="service-img">
                            <div class="service-overlay">
                                <h4>Highlight related offerings</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="service-box">
                            <img src="/img/additional-2.png" alt="Free Appraisal" class="service-img">
                            <div class="service-overlay">
                                <h4>Free Appraisal</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="service-box">
                            <img src="/img/additional-3.png" alt="Refining Services" class="service-img">
                            <div class="service-overlay">
                                <h4>Refining Services</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="faq-section container">
            <h2 class="text-center fw-bold">FAQ’s</h2>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq1">
                            How accurate is the calculator?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            The calculator provides estimates based on live metal prices but does not account for refining
                            fees.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq2">
                            Do you accept mixed metal items?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes, we accept mixed metals, but we evaluate based on the primary metal content.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq3">
                            What factors affect my item's value?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Metal type, weight, purity, and market prices influence the item's value.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="purity-info-section">
            <div class="container">
                <h3 class="text-center">Metal Purity Information</h3>
                {{-- <p class="text-center">Explore the purity levels of different metals, their fineness, and common uses.</p> --}}

                <ul class="nav nav-tabs justify-content-center" id="purityTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="gold-tab" data-bs-toggle="tab" data-bs-target="#gold"
                            type="button" role="tab">Gold</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="silver-tab" data-bs-toggle="tab" data-bs-target="#silver"
                            type="button" role="tab">Silver</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="platinum-tab" data-bs-toggle="tab" data-bs-target="#platinum"
                            type="button" role="tab">Platinum</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="palladium-tab" data-bs-toggle="tab" data-bs-target="#palladium"
                            type="button" role="tab">Palladium</button>
                    </li>
                </ul>

                <div class="tab-content mt-4" id="purityTabsContent">
                    <!-- Gold Purity Table -->
                    <div class="tab-pane fade show active" id="gold" role="tabpanel">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Karat (K)</th>
                                    <th>Gold Purity (%)</th>
                                    <th>Fineness (Parts per 1,000)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>24K</td>
                                    <td>99.9%</td>
                                    <td>999</td>
                                </tr>
                                <tr>
                                    <td>22K</td>
                                    <td>91.6%</td>
                                    <td>916</td>
                                </tr>
                                <tr>
                                    <td>21K</td>
                                    <td>87.5%</td>
                                    <td>875</td>
                                </tr>
                                <tr>
                                    <td>18K</td>
                                    <td>75%</td>
                                    <td>750</td>
                                </tr>
                                <tr>
                                    <td>14K</td>
                                    <td>58.3%</td>
                                    <td>583</td>
                                </tr>
                                <tr>
                                    <td>12K</td>
                                    <td>50%</td>
                                    <td>500</td>
                                </tr>
                                <tr>
                                    <td>10K</td>
                                    <td>41.7%</td>
                                    <td>417</td>
                                </tr>
                                <tr>
                                    <td>9K</td>
                                    <td>37.5%</td>
                                    <td>375</td>
                                </tr>
                                <tr>
                                    <td>8K</td>
                                    <td>33.3%</td>
                                    <td>333</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Silver Purity Table -->
                    <div class="tab-pane fade" id="silver" role="tabpanel">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Purity Grade</th>
                                    <th>Purity (%)</th>
                                    <th>Fineness (Parts per 1,000)</th>
                                    <th>Common Uses</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Fine Silver</td>
                                    <td>99.9%</td>
                                    <td>999</td>
                                    <td>Investment bars, bullion, coins</td>
                                </tr>
                                <tr>
                                    <td>Britannia Silver</td>
                                    <td>95.8%</td>
                                    <td>958</td>
                                    <td>British coins, fine jewelry</td>
                                </tr>
                                <tr>
                                    <td>Sterling Silver</td>
                                    <td>92.5%</td>
                                    <td>925</td>
                                    <td>Jewelry, silverware, collectibles</td>
                                </tr>
                                <tr>
                                    <td>Coin Silver</td>
                                    <td>90%</td>
                                    <td>900</td>
                                    <td>Older U.S. coins, antique silverware</td>
                                </tr>
                                <tr>
                                    <td>European Silver</td>
                                    <td>83.5%</td>
                                    <td>835</td>
                                    <td>Vintage jewelry, European silverware</td>
                                </tr>
                                <tr>
                                    <td>German Silver (Nickel)</td>
                                    <td>0%</td>
                                    <td>None</td>
                                    <td>Decorative items, cutlery (not real silver)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Platinum Purity Table -->
                    <div class="tab-pane fade" id="platinum" role="tabpanel">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Purity Grade</th>
                                    <th>Purity (%)</th>
                                    <th>Fineness (Parts per 1,000)</th>
                                    <th>Common Uses</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Pure Platinum</td>
                                    <td>99.95%</td>
                                    <td>999</td>
                                    <td>Investment bars, high-end jewelry</td>
                                </tr>
                                <tr>
                                    <td>Platinum 950</td>
                                    <td>95%</td>
                                    <td>950</td>
                                    <td>High-quality rings, watches</td>
                                </tr>
                                <tr>
                                    <td>Platinum 900</td>
                                    <td>90%</td>
                                    <td>900</td>
                                    <td>Fine jewelry, some vintage pieces</td>
                                </tr>
                                <tr>
                                    <td>Platinum 850</td>
                                    <td>85%</td>
                                    <td>850</td>
                                    <td>Lower-end platinum jewelry</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Palladium Purity Table -->
                    <div class="tab-pane fade" id="palladium" role="tabpanel">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Purity Grade</th>
                                    <th>Purity (%)</th>
                                    <th>Fineness (Parts per 1,000)</th>
                                    <th>Common Uses</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Pure Palladium</td>
                                    <td>99.9%</td>
                                    <td>999</td>
                                    <td>Investment bars, industrial use</td>
                                </tr>
                                <tr>
                                    <td>Palladium 950</td>
                                    <td>95%</td>
                                    <td>950</td>
                                    <td>High-end jewelry, luxury watches</td>
                                </tr>
                                <tr>
                                    <td>Palladium 900</td>
                                    <td>90%</td>
                                    <td>900</td>
                                    <td>Jewelry, industrial applications</td>
                                </tr>
                                <tr>
                                    <td>Palladium 500</td>
                                    <td>50%</td>
                                    <td>500</td>
                                    <td>Some jewelry alloys</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>



        <!-- 📌 Contact Section -->
        {{-- <section class="contact-section text-center p-4 mt-5">
            <h2>Contact Us</h2>
            <p>📞 1-844-504-4653</p>
            <p>📍 3rd Floor - 55 Dundas St East, Toronto</p>
            <p>🕒 Monday - Friday, 9 am - 6 pm</p>
        </section> --}}

    </div>
@endsection
