@extends('header.index')

@section('extratitle')
    FAQ
@endsection

@push('styles')
    <link href="{{ URL::to('/') }}/css/faq.css?ver=1.3.0" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ URL::to('/') }}/js/faq.js?ver=1.3.0"></script>
@endpush


@section('content')
<div class="main-div">
    <div class="container py-5 px-lg-5">
        <div class="px-lg-5">
            <h2 class="text-center mb-4">Frequently Asked Questions</h2>
            
            <!-- Account Functions -->
            <div class="mb-4">
                <h4 class="mb-3">General Gold Bullion FAQs:</h4>
                <div class="accordion" id="goldBullionFaqsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                1. What is gold bullion?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#goldBullionFaqsAccordion">
                            <div class="accordion-body">
                                Gold bullion refers to physical gold in the form of bars, coins, or ingots, valued primarily by its weight and purity.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                2. What forms of gold bullion do you sell (e.g., coins, bars)?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#goldBullionFaqsAccordion">
                            <div class="accordion-body">
                                We sell gold bullion in the form of bars, coins, and rounds.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                3. How is the value of gold bullion determined?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#goldBullionFaqsAccordion">
                            <div class="accordion-body">
                                The value of gold bullion is determined by its weight, purity, and the current market price of gold.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                4. What is the difference between gold coins and gold bars?
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#goldBullionFaqsAccordion">
                            <div class="accordion-body">
                                Gold coins are minted by governments and may carry a premium due to collectibility, while bars are simpler and often have lower premiums.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                5. Is gold bullion a good investment?
                            </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#goldBullionFaqsAccordion">
                            <div class="accordion-body">
                                Gold bullion is considered a stable investment to preserve wealth, especially during economic uncertainty.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                6. What is the purity of your gold products?
                            </button>
                        </h2>
                        <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#goldBullionFaqsAccordion">
                            <div class="accordion-body">
                                Our gold products range from 99.9% to 99.99% purity.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                7. Are your gold products certified?
                            </button>
                        </h2>
                        <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#goldBullionFaqsAccordion">
                            <div class="accordion-body">
                                Yes, all our gold products are certified by recognized mints and refineries.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                8. How do I verify the authenticity of gold bullion?
                            </button>
                        </h2>
                        <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#goldBullionFaqsAccordion">
                            <div class="accordion-body">
                                You can verify authenticity through hallmarks, assays, and certifications provided with the product.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading9">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                9. What is the minimum amount of gold I can purchase?
                            </button>
                        </h2>
                        <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#goldBullionFaqsAccordion">
                            <div class="accordion-body">
                                You can purchase as little as 1 gram of gold from our store.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading10">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                                10. Can I visit your store to view products before purchasing?
                            </button>
                        </h2>
                        <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#goldBullionFaqsAccordion">
                            <div class="accordion-body">
                                Yes, you are welcome to visit our store and view products before making a purchase.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="mb-4">
                <h4 class="mb-3">Buying Gold:</h4>
                <div class="accordion" id="buyingGoldFaqsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="true" aria-controls="collapse11">
                                1. How do I place an order for gold bullion?
                            </button>
                        </h2>
                        <div id="collapse11" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#buyingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Orders can be placed online, over the phone, or in person at our store.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                2. Do you sell fractional gold bars or coins?
                            </button>
                        </h2>
                        <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#buyingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we offer fractional gold products such as 1 gram and 5 gram bars or coins.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse13" aria-expanded="false" aria-controls="collapse13">
                                3. What is the current gold price, and how often does it change?
                            </button>
                        </h2>
                        <div id="collapse13" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#buyingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Gold prices are updated in real-time to reflect market fluctuations.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse14" aria-expanded="false" aria-controls="collapse14">
                                4. Are there any discounts for bulk gold purchases?
                            </button>
                        </h2>
                        <div id="collapse14" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#buyingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, bulk purchases may qualify for discounted premiums. Contact us for details.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse15" aria-expanded="false" aria-controls="collapse15">
                                5. Do you sell rare or collectible gold coins?
                            </button>
                        </h2>
                        <div id="collapse15" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#buyingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we sell collectible coins, including those with historical or numismatic value.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse16" aria-expanded="false" aria-controls="collapse16">
                                6. Can I lock in a gold price before making a payment?
                            </button>
                        </h2>
                        <div id="collapse16" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#buyingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, you can lock in a price when placing an order. Contact us for terms and conditions.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse17" aria-expanded="false" aria-controls="collapse17">
                                7. Do you accept custom orders for specific gold products?
                            </button>
                        </h2>
                        <div id="collapse17" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#buyingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we accept custom orders. Reach out to discuss your specific needs.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse18" aria-expanded="false" aria-controls="collapse18">
                                8. Do you provide a certificate of authenticity with purchases?
                            </button>
                        </h2>
                        <div id="collapse18" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#buyingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, all gold purchases come with a certificate of authenticity.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading9">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse19" aria-expanded="false" aria-controls="collapse19">
                                9. What happens if the gold price changes after I order?
                            </button>
                        </h2>
                        <div id="collapse19" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#buyingGoldFaqsAccordion">
                            <div class="accordion-body">
                                If the gold price changes after your order, the price at the time of confirmation is honored.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading10">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse20" aria-expanded="false" aria-controls="collapse20">
                                10. How secure is your website for online purchases?
                            </button>
                        </h2>
                        <div id="collapse20" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#buyingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Our website uses secure SSL encryption and follows industry best practices for secure transactions.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="mb-4">
                <h4 class="mb-3">Selling Gold:</h4>
                <div class="accordion" id="sellingGoldFaqsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse21" aria-expanded="true" aria-controls="collapse21">
                                1. How do I sell my gold bullion to you?
                            </button>
                        </h2>
                        <div id="collapse21" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#sellingGoldFaqsAccordion">
                            <div class="accordion-body">
                                You can sell gold by bringing it to our store for evaluation or contacting us to arrange a sale.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse22" aria-expanded="false" aria-controls="collapse22">
                                2. What types of gold will you buy?
                            </button>
                        </h2>
                        <div id="collapse22" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#sellingGoldFaqsAccordion">
                            <div class="accordion-body">
                                We buy gold bars, coins, rounds, scrap gold, and jewelry.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse23" aria-expanded="false" aria-controls="collapse23">
                                3. Do you buy scrap gold or jewelry?
                            </button>
                        </h2>
                        <div id="collapse23" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#sellingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we buy scrap gold and gold jewelry. Prices are based on weight and purity.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse24" aria-expanded="false" aria-controls="collapse24">
                                4. How is the value of my gold determined?
                            </button>
                        </h2>
                        <div id="collapse24" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#sellingGoldFaqsAccordion">
                            <div class="accordion-body">
                                The value of your gold is based on its weight, purity, and the current market price of gold.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse25" aria-expanded="false" aria-controls="collapse25">
                                5. Do you pay immediately for gold sold to you?
                            </button>
                        </h2>
                        <div id="collapse25" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#sellingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, payment is made immediately once the gold is evaluated and accepted.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse26" aria-expanded="false" aria-controls="collapse26">
                                6. Can I get an appraisal before selling my gold?
                            </button>
                        </h2>
                        <div id="collapse26" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#sellingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we offer appraisals to help you understand the value of your gold before selling.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse27" aria-expanded="false" aria-controls="collapse27">
                                7. Do I need an appointment to sell gold in person?
                            </button>
                        </h2>
                        <div id="collapse27" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#sellingGoldFaqsAccordion">
                            <div class="accordion-body">
                                No, appointments are not necessary but are recommended for large amounts.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse28" aria-expanded="false" aria-controls="collapse28">
                                8. Do you buy damaged or non-certified gold?
                            </button>
                        </h2>
                        <div id="collapse28" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#sellingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we buy damaged or non-certified gold at a fair market price.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading9">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse29" aria-expanded="false" aria-controls="collapse29">
                                9. Can I sell gold purchased from another dealer?
                            </button>
                        </h2>
                        <div id="collapse29" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#sellingGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we accept gold from other dealers, provided it meets our standards.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading10">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse30" aria-expanded="false" aria-controls="collapse30">
                                10. Are there any fees for selling gold?
                            </button>
                        </h2>
                        <div id="collapse30" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#sellingGoldFaqsAccordion">
                            <div class="accordion-body">
                                No, we do not charge any fees for selling your gold.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="mb-3">Refining Gold:</h4>
                <div class="accordion" id="refiningGoldFaqsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse31" aria-expanded="true" aria-controls="collapse31">
                                1. What is gold refining?
                            </button>
                        </h2>
                        <div id="collapse31" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#refiningGoldFaqsAccordion">
                            <div class="accordion-body">
                                Gold refining is the process of purifying gold to remove impurities and produce pure gold.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse32" aria-expanded="false" aria-controls="collapse32">
                                2. Do you offer refining services for individuals and businesses?
                            </button>
                        </h2>
                        <div id="collapse32" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#refiningGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we offer refining services for individuals, jewelers, and businesses.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse33" aria-expanded="false" aria-controls="collapse33">
                                3. What types of gold can be refined (e.g., scrap, jewelry)?
                            </button>
                        </h2>
                        <div id="collapse33" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#refiningGoldFaqsAccordion">
                            <div class="accordion-body">
                                We refine scrap gold, jewelry, and other gold-containing materials.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse34" aria-expanded="false" aria-controls="collapse34">
                                4. How much does it cost to refine gold?
                            </button>
                        </h2>
                        <div id="collapse34" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#refiningGoldFaqsAccordion">
                            <div class="accordion-body">
                                Refining costs vary based on quantity and type of material. Contact us for a quote.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse35" aria-expanded="false" aria-controls="collapse35">
                                5. How long does the refining process take?
                            </button>
                        </h2>
                        <div id="collapse35" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#refiningGoldFaqsAccordion">
                            <div class="accordion-body">
                                Refining typically takes 5–10 business days, depending on the volume.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse36" aria-expanded="false" aria-controls="collapse36">
                                6. What percentage of gold is typically recovered during refining?
                            </button>
                        </h2>
                        <div id="collapse36" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#refiningGoldFaqsAccordion">
                            <div class="accordion-body">
                                Typically, 98%–99.9% of gold is recovered, depending on its initial purity.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse37" aria-expanded="false" aria-controls="collapse37">
                                7. Do you refine other precious metals, such as silver or platinum?
                            </button>
                        </h2>
                        <div id="collapse37" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#refiningGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we refine silver, platinum, and other precious metals.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse38" aria-expanded="false" aria-controls="collapse38">
                                8. Can I get my refined gold as bars or coins?
                            </button>
                        </h2>
                        <div id="collapse38" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#refiningGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, refined gold can be returned as bars or coins upon request.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading9">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse39" aria-expanded="false" aria-controls="collapse39">
                                9. Is there a minimum amount of gold required for refining?
                            </button>
                        </h2>
                        <div id="collapse39" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#refiningGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, there is a minimum quantity for refining. Contact us for details.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading10">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse40" aria-expanded="false" aria-controls="collapse40">
                                10. Do you refine gold for jewelers or manufacturers?
                            </button>
                        </h2>
                        <div id="collapse40" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#refiningGoldFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we offer refining services for jewelers and manufacturers.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="mb-4">
                <h4 class="mb-3">Taxes:</h4>
                <div class="accordion" id="taxesFaqsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse41" aria-expanded="true" aria-controls="collapse41">
                                1. Is gold bullion taxable?
                            </button>
                        </h2>
                        <div id="collapse41" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#taxesFaqsAccordion">
                            <div class="accordion-body">
                                Gold bullion is often tax-exempt, but check local laws for specifics.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse42" aria-expanded="false" aria-controls="collapse42">
                                2. Are there any tax exemptions for gold purchases?
                            </button>
                        </h2>
                        <div id="collapse42" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#taxesFaqsAccordion">
                            <div class="accordion-body">
                                Yes, certain gold products qualify for tax exemptions based on purity and form. Contact us for details.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse43" aria-expanded="false" aria-controls="collapse43">
                                3. Do I need to pay taxes when selling gold?
                            </button>
                        </h2>
                        <div id="collapse43" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#taxesFaqsAccordion">
                            <div class="accordion-body">
                                Yes, taxes may apply when selling gold in some jurisdictions. Check with a tax advisor.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse44" aria-expanded="false" aria-controls="collapse44">
                                4. How are capital gains taxes calculated on gold investments?
                            </button>
                        </h2>
                        <div id="collapse44" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#taxesFaqsAccordion">
                            <div class="accordion-body">
                                Capital gains taxes are calculated based on the difference between your purchase and selling price.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse45" aria-expanded="false" aria-controls="collapse45">
                                5. Does your store report gold transactions to the government?
                            </button>
                        </h2>
                        <div id="collapse45" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#taxesFaqsAccordion">
                            <div class="accordion-body">
                                No, we do not report transactions unless required by law. Check local regulations.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse46" aria-expanded="false" aria-controls="collapse46">
                                6. Are there specific tax laws for gold in Canada?
                            </button>
                        </h2>
                        <div id="collapse46" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#taxesFaqsAccordion">
                            <div class="accordion-body">
                                Yes, Canada has specific tax rules for precious metals. Contact us for guidance.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse47" aria-expanded="false" aria-controls="collapse47">
                                7. Do I need to pay HST or GST when buying gold bullion?
                            </button>
                        </h2>
                        <div id="collapse47" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#taxesFaqsAccordion">
                            <div class="accordion-body">
                                Gold bullion with a purity of 99.5% or higher is typically GST/HST exempt in Canada.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse48" aria-expanded="false" aria-controls="collapse48">
                                8. How can I reduce taxes on gold purchases?
                            </button>
                        </h2>
                        <div id="collapse48" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#taxesFaqsAccordion">
                            <div class="accordion-body">
                                Tax obligations can be reduced through proper record-keeping and consulting with a tax expert.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading9">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse49" aria-expanded="false" aria-controls="collapse49">
                                9. Do I need to provide ID for tax purposes when buying or selling?
                            </button>
                        </h2>
                        <div id="collapse49" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#taxesFaqsAccordion">
                            <div class="accordion-body">
                                Yes, ID may be required for compliance with anti-money laundering regulations.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading10">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse50" aria-expanded="false" aria-controls="collapse50">
                                10. Are there international tax implications when buying or selling gold?
                            </button>
                        </h2>
                        <div id="collapse50" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#taxesFaqsAccordion">
                            <div class="accordion-body">
                                Yes, international gold transactions may involve different tax regulations. Consult a tax advisor.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="mb-4">
                <h4 class="mb-3">Shipping and Insurance:</h4>
                <div class="accordion" id="shippingInsuranceFaqsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse51" aria-expanded="true" aria-controls="collapse51">
                                1. Do you offer shipping for gold bullion purchases?
                            </button>
                        </h2>
                        <div id="collapse51" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#shippingInsuranceFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we offer secure shipping options for all purchases.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse52" aria-expanded="false" aria-controls="collapse52">
                                2. Is shipping free or charged separately?
                            </button>
                        </h2>
                        <div id="collapse52" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#shippingInsuranceFaqsAccordion">
                            <div class="accordion-body">
                                Shipping costs vary depending on the order size and destination.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse53" aria-expanded="false" aria-controls="collapse53">
                                3. How is gold bullion packaged for shipping?
                            </button>
                        </h2>
                        <div id="collapse53" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#shippingInsuranceFaqsAccordion">
                            <div class="accordion-body">
                                Gold is securely packaged in tamper-proof and discreet packaging.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse54" aria-expanded="false" aria-controls="collapse54">
                                4. Do you provide tracking information for shipments?
                            </button>
                        </h2>
                        <div id="collapse54" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#shippingInsuranceFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we provide tracking for all shipped orders.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse55" aria-expanded="false" aria-controls="collapse55">
                                5. What happens if my gold shipment is lost or stolen?
                            </button>
                        </h2>
                        <div id="collapse55" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#shippingInsuranceFaqsAccordion">
                            <div class="accordion-body">
                                If a shipment is lost or stolen, we assist with insurance claims to recover the value.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse56" aria-expanded="false" aria-controls="collapse56">
                                6. Is shipping insured, and who pays for insurance?
                            </button>
                        </h2>
                        <div id="collapse56" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#shippingInsuranceFaqsAccordion">
                            <div class="accordion-body">
                                Yes, all shipments are fully insured. Insurance fees are included in the shipping cost.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse57" aria-expanded="false" aria-controls="collapse57">
                                7. Can I request expedited shipping?
                            </button>
                        </h2>
                        <div id="collapse57" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#shippingInsuranceFaqsAccordion">
                            <div class="accordion-body">
                                Yes, expedited shipping is available for an additional charge.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse58" aria-expanded="false" aria-controls="collapse58">
                                8. Do you ship internationally?
                            </button>
                        </h2>
                        <div id="collapse58" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#shippingInsuranceFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we ship to select international destinations. Contact us for details.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading9">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse59" aria-expanded="false" aria-controls="collapse59">
                                9. Are there any shipping restrictions for gold bullion?
                            </button>
                        </h2>
                        <div id="collapse59" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#shippingInsuranceFaqsAccordion">
                            <div class="accordion-body">
                                Some countries have restrictions on gold imports. Verify regulations before ordering.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading10">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse60" aria-expanded="false" aria-controls="collapse60">
                                10. Can I pick up my order in person instead of shipping?
                            </button>
                        </h2>
                        <div id="collapse60" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#shippingInsuranceFaqsAccordion">
                            <div class="accordion-body">
                                Yes, in-store pickup is available. Choose this option during checkout.
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="mb-4">
                <h4 class="mb-3">Storage and Security:</h4>
                <div class="accordion" id="storageSecurityFaqsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse61" aria-expanded="true" aria-controls="collapse61">
                                1. Do you offer gold storage services?
                            </button>
                        </h2>
                        <div id="collapse61" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#storageSecurityFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we offer insured vault storage services for your gold.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse62" aria-expanded="false" aria-controls="collapse62">
                                2. Is storing gold at home safe?
                            </button>
                        </h2>
                        <div id="collapse62" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#storageSecurityFaqsAccordion">
                            <div class="accordion-body">
                                While storing gold at home is possible, professional vaults offer better security.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse63" aria-expanded="false" aria-controls="collapse63">
                                3. What are the best options for storing gold securely?
                            </button>
                        </h2>
                        <div id="collapse63" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#storageSecurityFaqsAccordion">
                            <div class="accordion-body">
                                The best options include insured vaults, safety deposit boxes, or certified storage facilities.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse64" aria-expanded="false" aria-controls="collapse64">
                                4. Can you recommend insured vault services?
                            </button>
                        </h2>
                        <div id="collapse64" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#storageSecurityFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we partner with secure storage providers for insured vault services.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse65" aria-expanded="false" aria-controls="collapse65">
                                5. How do I protect my gold investment against theft?
                            </button>
                        </h2>
                        <div id="collapse65" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#storageSecurityFaqsAccordion">
                            <div class="accordion-body">
                                Invest in a safe, store it discreetly, and consider insurance for home-stored gold.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse66" aria-expanded="false" aria-controls="collapse66">
                                6. Are there additional costs for storing gold in a vault?
                            </button>
                        </h2>
                        <div id="collapse66" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#storageSecurityFaqsAccordion">
                            <div class="accordion-body">
                                Vault storage fees depend on the amount and duration. Contact us for pricing.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse67" aria-expanded="false" aria-controls="collapse67">
                                7. Should I insure my stored gold?
                            </button>
                        </h2>
                        <div id="collapse67" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#storageSecurityFaqsAccordion">
                            <div class="accordion-body">
                                Yes, insuring stored gold is highly recommended.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse68" aria-expanded="false" aria-controls="collapse68">
                                8. Can I store gold in a safety deposit box?
                            </button>
                        </h2>
                        <div id="collapse68" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#storageSecurityFaqsAccordion">
                            <div class="accordion-body">
                                Yes, safety deposit boxes in banks are a common storage option.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading9">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse69" aria-expanded="false" aria-controls="collapse69">
                                9. Is it better to store gold in Canada or overseas?
                            </button>
                        </h2>
                        <div id="collapse69" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#storageSecurityFaqsAccordion">
                            <div class="accordion-body">
                                This depends on your needs; both options have benefits. Consult a professional for advice.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading10">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse70" aria-expanded="false" aria-controls="collapse70">
                                10. Do you provide a buyback guarantee for stored gold?
                            </button>
                        </h2>
                        <div id="collapse70" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#storageSecurityFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we offer a buyback guarantee for gold stored with us.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="mb-4">
                <h4 class="mb-3">Payment Methods:</h4>
                <div class="accordion" id="paymentMethodsFaqsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse71" aria-expanded="true" aria-controls="collapse71">
                                1. What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="collapse71" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#paymentMethodsFaqsAccordion">
                            <div class="accordion-body">
                                We accept cash, credit cards, bank transfers, and wire payments.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse72" aria-expanded="false" aria-controls="collapse72">
                                2. Can I pay for gold bullion using a credit card?
                            </button>
                        </h2>
                        <div id="collapse72" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#paymentMethodsFaqsAccordion">
                            <div class="accordion-body">
                                Yes, credit cards are accepted with applicable processing fees.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse73" aria-expanded="false" aria-controls="collapse73">
                                3. Do you accept bank transfers or wire payments?
                            </button>
                        </h2>
                        <div id="collapse73" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#paymentMethodsFaqsAccordion">
                            <div class="accordion-body">
                                Yes, wire payments and bank transfers are accepted for larger purchases.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse74" aria-expanded="false" aria-controls="collapse74">
                                4. Can I pay for gold bullion in cash?
                            </button>
                        </h2>
                        <div id="collapse74" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#paymentMethodsFaqsAccordion">
                            <div class="accordion-body">
                                Yes, cash payments are accepted in-store.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse75" aria-expanded="false" aria-controls="collapse75">
                                5. Do you offer financing options for gold purchases?
                            </button>
                        </h2>
                        <div id="collapse75" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#paymentMethodsFaqsAccordion">
                            <div class="accordion-body">
                                Yes, financing options may be available. Contact us for details.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse76" aria-expanded="false" aria-controls="collapse76">
                                6. Are there any discounts for paying with certain methods?
                            </button>
                        </h2>
                        <div id="collapse76" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#paymentMethodsFaqsAccordion">
                            <div class="accordion-body">
                                Discounts may be available for bulk orders or specific payment methods. Contact us for details.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse77" aria-expanded="false" aria-controls="collapse77">
                                7. Do you charge extra fees for specific payment methods?
                            </button>
                        </h2>
                        <div id="collapse77" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#paymentMethodsFaqsAccordion">
                            <div class="accordion-body">
                                No, we do not charge extra fees for payment methods unless specified during checkout.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse78" aria-expanded="false" aria-controls="collapse78">
                                8. How secure is your payment process?
                            </button>
                        </h2>
                        <div id="collapse78" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#paymentMethodsFaqsAccordion">
                            <div class="accordion-body">
                                Our payment process uses SSL encryption and adheres to strict security protocols.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading9">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse79" aria-expanded="false" aria-controls="collapse79">
                                9. Can I make a partial payment and lock in the price?
                            </button>
                        </h2>
                        <div id="collapse79" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#paymentMethodsFaqsAccordion">
                            <div class="accordion-body">
                                Yes, partial payments are accepted to lock in prices. Contact us for terms.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

            <div class="mb-4">
                <h4 class="mb-3">Returns and Refunds:</h4>
                <div class="accordion" id="returnsAndRefundsFaqsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse81" aria-expanded="true" aria-controls="collapse81">
                                1. What is your return policy for gold bullion?
                            </button>
                        </h2>
                        <div id="collapse81" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#returnsAndRefundsFaqsAccordion">
                            <div class="accordion-body">
                                Returns are accepted under certain conditions. Refer to our return policy for details.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse82" aria-expanded="false" aria-controls="collapse82">
                                2. Can I cancel my order after it has been placed?
                            </button>
                        </h2>
                        <div id="collapse82" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#returnsAndRefundsFaqsAccordion">
                            <div class="accordion-body">
                                Orders can be canceled within a specified time frame. Fees may apply.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse83" aria-expanded="false" aria-controls="collapse83">
                                3. Do you offer refunds for returned gold?
                            </button>
                        </h2>
                        <div id="collapse83" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#returnsAndRefundsFaqsAccordion">
                            <div class="accordion-body">
                                Refunds are issued for eligible returns after product inspection.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse84" aria-expanded="false" aria-controls="collapse84">
                                4. What happens if the gold I receive is damaged or incorrect?
                            </button>
                        </h2>
                        <div id="collapse84" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#returnsAndRefundsFaqsAccordion">
                            <div class="accordion-body">
                                Contact us immediately if your product is damaged or incorrect for resolution.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse85" aria-expanded="false" aria-controls="collapse85">
                                5. Are custom or special orders refundable?
                            </button>
                        </h2>
                        <div id="collapse85" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#returnsAndRefundsFaqsAccordion">
                            <div class="accordion-body">
                                Custom orders are typically non-refundable. Contact us for details.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse86" aria-expanded="false" aria-controls="collapse86">
                                6. How do I initiate a return?
                            </button>
                        </h2>
                        <div id="collapse86" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#returnsAndRefundsFaqsAccordion">
                            <div class="accordion-body">
                                Initiate a return by contacting our customer support team.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse87" aria-expanded="false" aria-controls="collapse87">
                                7. Is there a restocking fee for returns?
                            </button>
                        </h2>
                        <div id="collapse87" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#returnsAndRefundsFaqsAccordion">
                            <div class="accordion-body">
                                Yes, a restocking fee may apply depending on the item and reason for return.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse88" aria-expanded="false" aria-controls="collapse88">
                                8. Can I exchange gold products for different ones?
                            </button>
                        </h2>
                        <div id="collapse88" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#returnsAndRefundsFaqsAccordion">
                            <div class="accordion-body">
                                Exchanges are allowed for eligible products. Contact us to learn more.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading9">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse89" aria-expanded="false" aria-controls="collapse89">
                                9. Do I need proof of purchase to return gold?
                            </button>
                        </h2>
                        <div id="collapse89" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#returnsAndRefundsFaqsAccordion">
                            <div class="accordion-body">
                                Proof of purchase is required for returns and exchanges.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading10">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse90" aria-expanded="false" aria-controls="collapse90">
                                10. How long does it take to process a refund?
                            </button>
                        </h2>
                        <div id="collapse90" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#returnsAndRefundsFaqsAccordion">
                            <div class="accordion-body">
                                Refunds are processed within 5–7 business days after approval.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

            <div class="mb-4">
                <h4 class="mb-3">Miscellaneous:</h4>
                <div class="accordion" id="miscellaneousFaqsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse91" aria-expanded="true" aria-controls="collapse91">
                                1. Why should I buy gold from your store?
                            </button>
                        </h2>
                        <div id="collapse91" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#miscellaneousFaqsAccordion">
                            <div class="accordion-body">
                                We provide competitive pricing, certified products, and excellent customer service.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse92" aria-expanded="false" aria-controls="collapse92">
                                2. Do you offer advice on investing in gold?
                            </button>
                        </h2>
                        <div id="collapse92" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#miscellaneousFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we offer basic guidance on gold investments. Contact us for more information.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse93" aria-expanded="false" aria-controls="collapse93">
                                3. Can I set up an account for recurring gold purchases?
                            </button>
                        </h2>
                        <div id="collapse93" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#miscellaneousFaqsAccordion">
                            <div class="accordion-body">
                                Recurring purchase plans can be set up. Contact us for options.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse94" aria-expanded="false" aria-controls="collapse94">
                                4. Do you offer loyalty programs or rewards for customers?
                            </button>
                        </h2>
                        <div id="collapse94" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#miscellaneousFaqsAccordion">
                            <div class="accordion-body">
                                We reward loyal customers through periodic discounts and special offers.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse95" aria-expanded="false" aria-controls="collapse95">
                                5. What are the risks of investing in gold?
                            </button>
                        </h2>
                        <div id="collapse95" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#miscellaneousFaqsAccordion">
                            <div class="accordion-body">
                                Gold is considered low-risk but is subject to market price fluctuations.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse96" aria-expanded="false" aria-controls="collapse96">
                                6. How do I verify the weight and purity of gold at home?
                            </button>
                        </h2>
                        <div id="collapse96" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#miscellaneousFaqsAccordion">
                            <div class="accordion-body">
                                You can use a gold testing kit or consult a professional to verify purity and weight.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse97" aria-expanded="false" aria-controls="collapse97">
                                7. Do you provide educational resources about gold and precious metals?
                            </button>
                        </h2>
                        <div id="collapse97" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#miscellaneousFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we offer guides and educational materials on precious metals.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse98" aria-expanded="false" aria-controls="collapse98">
                                8. What are your store hours and contact details?
                            </button>
                        </h2>
                        <div id="collapse98" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#miscellaneousFaqsAccordion">
                            <div class="accordion-body">
                                Our store hours and contact details are listed on our website. Reach out anytime!
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading9">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse99" aria-expanded="false" aria-controls="collapse99">
                                9. Do you offer corporate services for businesses buying or selling gold?
                            </button>
                        </h2>
                        <div id="collapse99" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#miscellaneousFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we work with businesses to provide tailored services for bulk buying or selling.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading10">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse100" aria-expanded="false" aria-controls="collapse100">
                                10. Can I trade my gold bullion for other precious metals?
                            </button>
                        </h2>
                        <div id="collapse100" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#miscellaneousFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we offer trade-in services for gold and other precious metals.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading11">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse101" aria-expanded="false" aria-controls="collapse101">
                                11. Do you refine gold for jewelers or manufacturers?
                            </button>
                        </h2>
                        <div id="collapse101" class="accordion-collapse collapse" aria-labelledby="heading11" data-bs-parent="#miscellaneousFaqsAccordion">
                            <div class="accordion-body">
                                Yes, we offer refining services for jewelers and manufacturers.
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            
        
            <!-- Add other sections in the same way -->
        </div>
    </div>
</div>

@endsection
