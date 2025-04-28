<style>
    @import url('https://fonts.googleapis.com/css2?family=Tienne:wght@400;700;900&display=swap');

    .modal-content {
        border-radius: 0px !important
    }

    .modal-title {
        text-align: center;
        font-weight: 700;
        font-family: times;
        font-size: x-large;
    }

    .modal-sub-title,
    .timer-text {
        text-align: center;
        font-weight: 400;
        font-family: times;
        margin-top: 20px;
        font-size: larger;
    }

    .timer {
        text-align: center;
        font-weight: 700;
        font-family: times;
        font-size: 30px;
        margin-top: 20px;
        color: #FF0000;
    }

    .btn-group {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .btn-base {
        background-color: #FFD700;
        color: #000;
        border-radius: 5px;
        margin: 0 10px;
    }

    .btn-base:hover {
        background-color: transparent;
        border: 1px solid #FFD700;
    }

    .modal-body {
        display: grid;
        place-items: center;
    }

    .background {
        position: absolute;
        top: 0;
        left: 0;
        height: 300px;
        width: 100%;
        background-color: #333;
        clip-path: ellipse(75% 100% at 50% 0%);
        z-index: 0;
    }

    .modal-title-image,
    .modal-title,
    .modal-sub-title,
    .btn-group {
        position: relative;
        z-index: 1;
        text-align: center;
        /* optional, for centered content */
    }

    .modal-body {
        position: relative;
        overflow: hidden;
        padding: 100px 55px 100px;
        /* space to see curve */
    }

    .feedback-form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .feedback-form textarea {
        width: 100%;
        height: 100px;
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 20px;
        font-family: "Tienne", serif;
    }

    .feedback-form input {
        width: 100%;
        height: auto;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-top: 20px;
        font-family: "Tienne", serif;
        padding: 10px;
    }

    .fa-star {
        color: #E1E1E1;
    }

    .horizontal-modal {
        top: 130px;
        width: 800px;
        margin: 0 25%;
    }

    .horizontal-modal .modal-content {
        width: 160%;
        height: 350px;
        border-radius: 10px;
        padding: 0px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .main-body {
        display: flex;
        height: 100%;
        width: 100%;
    }

    .modal-left {
        width: 40%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-left img {
        max-width: 100%;
        height: auto;
    }

    .modal-right {
        width: 60%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 0 50px;
        text-align: center;
    }

    .progress {
        height: 7px;
        border-radius: 10px;
        background-color: #E6E6E6;
        width: 100%;
    }

    .progress-bar {
        width: 70%;
        background-color: #28a745;
        border-radius: 10px;
    }

    .product-section {
        padding: 0px 100px;
        text-align: center;
        margin-bottom: 30px
    }
</style>


<!-- Black Friday Modal -->
<div class="modal fade" id="BlackFriday" tabindex="-1" aria-labelledby="BlackFridayLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="padding: 100px 0px 0px;">
                <p class="modal-title">🔥 Black Friday Mega Sale! 🔥</p>
                <p class="modal-sub-title">Up to 50% OFF – Limited-time only!</p>
                <p class="timer-text">
                    Hurry, sale ends in:
                </p>
                <p class="timer">02:59</p>
                <div class="btn-group">
                    <button type="button" class="btn btn-base">Shop Now</button>
                    <button type="button" class="btn btn-base close" data-dismiss="modal">Remind Me Later</button>
                </div>
                <hr>
                <img src="{{ asset('img/popus/seasonal.png') }}" alt="seasonal sale image" class="img-fluid"
                    style="width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>

<!-- First Time Visitor Modal -->
<div class="modal fade" id="NewVisitor" tabindex="-1" aria-labelledby="NewVisitorLabel" aria-hidden="true">
    <div class="modal-dialog horizontal-modal">
        <div class="modal-content">
            <div class="main-body">
                <div class="col-md-4 modal-left"
                    style="background: url('img/popus/newuser.png') no-repeat center center; background-size: cover;background-position: center;">

                </div>
                <div class="col-md-4 modal-right">
                    <p class="modal-title">Welcome! Here’s 10% Off Just for You</p>
                    <p class="modal-sub-title">Use code: WELCOME10 at checkout and enjoy your discount.</p>

                    <div class="btn-group">
                        <button type="button" class="btn btn-base">Claim My Discount</button>
                        <button type="button" class="btn btn-base">No, Thanks</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Referral Modal -->
<div class="modal fade" id="Referral" tabindex="-1" aria-labelledby="ReferralLabel" aria-hidden="true">
    <div class="modal-dialog horizontal-modal">
        <div class="modal-content">
            <div class="main-body">
                <div class="col-md-4 modal-left">
                    <p class="modal-title-image"><img src="{{ asset('img/popus/gift.png') }}" alt="modal title image"
                            width="200px"></p>
                </div>
                <div class="col-md-4 modal-right">
                    <p class="modal-title">🎉 Give $10, Get $10!</p>
                    <p class="modal-sub-title">Invite your friends & both of you get a **$10 discount**!</p>
                    <form action="" class="feedback-form">
                        <input type="text" placeholder="Enter your email" value="https://www.site.com/ref?user=123"
                            disabled>
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Copy Referral Link</button>
                            <button type="button" class="btn btn-base">No, Thanks I'll Miss Out</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Recommendation Modal -->
<div class="modal fade" id="ProductSuggestion" tabindex="-1" aria-labelledby="ProductSuggestionLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p class="modal-title">🛍️ You Might Like This!</p>
                <p class="modal-sub-title">Based on your browsing, we think you’ll love this:</p>
                <div class="product-section">
                    <p class="modal-title-image"><img src="{{ asset('img/popus/product.png') }}" alt="modal title image"
                            width="100px"></p>
                    <span>2024 1oz Gold Maple Leaf
                        Coin (King Charles)</span>
                    <p class="modal-title">
                        <strong>
                            ⭐ 4.8 | $49.99
                        </strong>
                    </p>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-base">Add to cart</button>
                    <button type="button" class="btn btn-base">View Deal</button>
                    <button type="button" class="btn btn-base">Not Intrested</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter Modal -->
<div class="modal fade" id="Newsletter" tabindex="-1" aria-labelledby="NewsletterLabel" aria-hidden="true">
    <div class="modal-dialog horizontal-modal">
        <div class="modal-content">
            <div class="main-body">
                <div class="col-md-4 modal-right">
                    <p class="modal-title">Join Our Newsletter</p>
                    <p class="modal-sub-title">Subscribe and get exclusive updates & offers straight to your inbox!</p>
                    <form action="" class="feedback-form">
                        <input type="text" placeholder="Enter your email">
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Subscribe Now</button>
                            <button type="button" class="btn btn-base">No, Thanks</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 modal-left"
                    style="background: url('img/popus/newsletter.png') no-repeat center center; background-size: auto;background-position: right;">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Survey Items Modal -->
<div class="modal fade" id="SurveyItems" tabindex="-1" aria-labelledby="SurveyItemsLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 700px">
        <div class="modal-content" style="max-width: 700px;">
            <div class="modal-body">
                <p class="modal-title">
                    🎯 Find Your Perfect Product!
                </p>
                <p class="modal-sub-title">Answer a few quick questions to get a personalized recommendation.
                </p>
                <p class="modal-sub-title">What are you looking for?
                </p>
                <div class="products d-flex">
                    <div class="product-section py-4 mx-2"
                        style="padding: 0px 30px; box-shadow: 4px 5px 14px rgb(0 0 0 / 21%);">
                        <p class="modal-title-image"><img src="{{ asset('img/popus/product.png') }}"
                                alt="modal title image" width="100px"></p>
                        <span>2024 1oz Gold Maple Leaf
                            Coin (King Charles)</span>
                        <p class="modal-title">
                            <strong>
                                ⭐ 4.8 | $49.99
                            </strong>
                        </p>
                        <button type="button" class="btn btn-base w-100">View</button>
                    </div>
                    <div class="product-section py-4 mx-2"
                        style="padding: 0px 30px; box-shadow: 4px 5px 14px rgb(0 0 0 / 21%);">
                        <p class="modal-title-image"><img src="{{ asset('img/popus/product.png') }}"
                                alt="modal title image" width="100px"></p>
                        <span>2024 1oz Gold Maple Leaf
                            Coin (King Charles)</span>
                        <p class="modal-title">
                            <strong>
                                ⭐ 4.8 | $49.99
                            </strong>
                        </p>
                        <button type="button" class="btn btn-base w-100">View</button>
                    </div>

                    <div class="product-section py-4 mx-2"
                        style="padding: 0px 30px; box-shadow: 4px 5px 14px rgb(0 0 0 / 21%);">
                        <p class="modal-title-image"><img src="{{ asset('img/popus/product.png') }}"
                                alt="modal title image" width="100px"></p>
                        <span>2024 1oz Gold Maple Leaf
                            Coin (King Charles)</span>
                        <p class="modal-title">
                            <strong>
                                ⭐ 4.8 | $49.99
                            </strong>
                        </p>
                        <button type="button" class="btn btn-base w-100">View</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Cart Abandonment Modal -->
<div class="modal fade" id="CartAbanoment" tabindex="-1" aria-labelledby="CartAbanomentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p class="modal-title-image"><img src="{{ asset('img/popus/cart-abandonment.png') }}"
                        alt="modal title image" width="200px"></p>
                <p class="modal-title">Wait! Your Cart is Almost Gone!</p>
                <p class="modal-sub-title">Complete your purchase now and get 10% OFF! Use code:
                    <strong>SAVE10</strong>
                </p>
                <div class="btn-group">
                    <button type="button" class="btn btn-base">Complete My Purchase</button>
                    <button type="button" class="btn btn-base">No, i’ll Risk Losing My items</button>
                </div>
                {{-- <hr> --}}
                {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}

            </div>
        </div>
    </div>
</div>

<!-- Exit Intent Modal -->
<div class="modal fade" id="ExitIntent" tabindex="-1" aria-labelledby="ExitIntentLabel" aria-hidden="true">
    <div class="modal-dialog horizontal-modal">
        <div class="modal-content">
            <div class="main-body">
                <div class="col-md-4 modal-left">
                    <p class="modal-title-image"><img src="{{ asset('img/popus/exit.png') }}" alt="modal title image"
                            width="200px"></p>
                </div>
                <div class="col-md-4 modal-right">
                    <p class="modal-title">Wait! Don't Leave Yet</p>
                    <p class="modal-sub-title">Get an exclusive 10% OFF your order now. Use code: SAVE10</p>
                    <div class="btn-group">
                        <button type="button" class="btn btn-base">Claim My Discount</button>
                        <button type="button" class="btn btn-base">No, Thanks</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Timer countdown - 2 hours from now
    var countdownDate = new Date().getTime() + 2 * 60 * 60 * 1000;

    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countdownDate - now;

        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.querySelector('.timer').innerHTML = hours + ":" + minutes + ":" + seconds;

        if (distance < 0) {
            clearInterval(x);
            document.querySelector('.timer').innerHTML = "EXPIRED";
        }
    }, 1000);

    // Show Black Friday modal after 8 seconds
    $(document).ready(function() {
        setTimeout(function() {
            // $('#BlackFriday').modal('show');
        }, 8000);
    });

    // Exit Intent Modal (homepage or blog only)
    document.addEventListener("DOMContentLoaded", function() {
        let shown = false;
        if (window.location.pathname === '/' || window.location.pathname.includes('/blog')) {
            document.addEventListener("mouseout", function(e) {
                if (!shown && e.clientY < 10) {
                    shown = true;
                    $('#ExitIntent').modal('show');
                }
            });
        }
    });

    // New Visitor Modal (homepage or product pages)
    $(document).ready(function() {
        const modalShownKey = 'modal_shown_once';
        const currentPath = window.location.pathname;

        console.log('[NewVisitor] Current path:', currentPath);
        console.log('[NewVisitor] Modal already shown?', !!localStorage.getItem(modalShownKey));

        if ((currentPath === '/' || currentPath.startsWith('/product')) && !localStorage.getItem(
                modalShownKey)) {
            function showModal(source) {
                if (!localStorage.getItem(modalShownKey)) {
                    console.log(`[NewVisitor] Showing modal via ${source}`);
                    $('#NewVisitor').modal('show');
                    localStorage.setItem(modalShownKey, 'true');
                }
            }

            setTimeout(() => {
                console.log('[NewVisitor] 10s timeout reached');
                showModal('timer');
            }, 10000);

            $(window).on('scroll', function onScroll() {
                const scrollPercent = (window.scrollY + window.innerHeight) / document.body
                    .scrollHeight;
                console.log('[NewVisitor] Scroll percent:', scrollPercent.toFixed(2));

                if (scrollPercent >= 0.4) {
                    showModal('scroll');
                    $(window).off('scroll', onScroll);
                }
            });
        }
    });

    // ProductSuggestion Modal (inactivity + multi-view logic with logs)
    $(document).ready(function() {
        const modalKey = 'product_suggestion_shown';
        const viewCountKey = 'product_page_views';
        const currentPath = window.location.pathname;
        const isProductPage = currentPath.startsWith('/product');

        console.log('[ProductSuggestion] Path:', currentPath);
        console.log('[ProductSuggestion] Is product page?', isProductPage);
        console.log('[ProductSuggestion] Modal already shown?', !!sessionStorage.getItem(modalKey));

        if (!isProductPage || sessionStorage.getItem(modalKey)) {
            console.log('[ProductSuggestion] Not eligible – exiting.');
            return;
        }

        // Track product page views
        let views = parseInt(sessionStorage.getItem(viewCountKey) || '0');
        views += 1;
        sessionStorage.setItem(viewCountKey, views);
        console.log('[ProductSuggestion] Product page views:', views);

        function showSuggestionModal(source) {
            if (!sessionStorage.getItem(modalKey)) {
                console.log(`[ProductSuggestion] Triggered by ${source}`);
                $('#ProductSuggestion').modal('show');
                sessionStorage.setItem(modalKey, 'true');
            }
        }

        // Trigger if 2+ product views
        if (views >= 2) {
            console.log('[ProductSuggestion] 2+ product views detected – triggering modal');
            showSuggestionModal('multiple_views');
            return;
        }

        // Inactivity logic
        let inactivityTimer;

        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(() => {
                console.log('[ProductSuggestion] 15s of inactivity detected');
                showSuggestionModal('inactivity');
            }, 15000);
        }

        // Reset timer on user activity
        ['mousemove', 'scroll', 'keydown', 'click'].forEach(event =>
            document.addEventListener(event, resetInactivityTimer)
        );

        // Start initial timer
        resetInactivityTimer();
    });

    // Newsletter Modal (any page except homepage/shop, 10–15s or 50% scroll)
    $(document).ready(function() {
        const modalKey = 'newsletter_modal_shown';
        const currentPath = window.location.pathname;
        const isContentPage = currentPath !== '/' && !currentPath.startsWith('/shop') && !currentPath
            .startsWith('/product');

        console.log('[Newsletter] Path:', currentPath);
        console.log('[Newsletter] Is content page?', isContentPage);
        console.log('[Newsletter] Already shown?', !!localStorage.getItem(modalKey));

        if (!isContentPage || localStorage.getItem(modalKey)) {
            console.log('[Newsletter] Not eligible – exiting.');
            return;
        }

        function showNewsletterModal(source) {
            if (!localStorage.getItem(modalKey)) {
                console.log(`[Newsletter] Triggered by ${source}`);
                $('#Newsletter').modal('show');
                localStorage.setItem(modalKey, 'true');
            }
        }

        // Random delay between 10–15s
        const delay = Math.floor(10000 + Math.random() * 5000);
        console.log('[Newsletter] Timer set for', delay, 'ms');
        setTimeout(() => showNewsletterModal('timer'), delay);

        // Trigger on scroll 50%
        $(window).on('scroll', function onScroll() {
            const scrollPercent = (window.scrollY + window.innerHeight) / document.body.scrollHeight;
            console.log('[Newsletter] Scroll percent:', scrollPercent.toFixed(2));
            if (scrollPercent >= 0.5) {
                showNewsletterModal('scroll');
                $(window).off('scroll', onScroll);
            }
        });
    });

    // --- Product Page Survey Modal ---
    $(document).ready(function() {
        const modalKey = 'survey_shown';
        const viewCountKey = 'survey_product_views';
        const currentPath = window.location.pathname;
        const isProductPage = currentPath.startsWith('/product');

        console.log('[Survey] Path:', currentPath);
        console.log('[Survey] Is product page?', isProductPage);
        console.log('[Survey] Modal already shown?', !!sessionStorage.getItem(modalKey));

        if (!isProductPage || sessionStorage.getItem(modalKey)) {
            console.log('[Survey] Not eligible – exiting.');
            return;
        }

        // Track product page views
        let views = parseInt(sessionStorage.getItem(viewCountKey) || '0') + 1;
        sessionStorage.setItem(viewCountKey, views);
        console.log('[Survey] Product page views:', views);

        function showSurveyModal(source) {
            if (!sessionStorage.getItem(modalKey)) {
                console.log(`[Survey] Triggered by ${source}`);
                $('#SurveyItems').modal('show');
                sessionStorage.setItem(modalKey, 'true');
            }
        }

        // IMMEDIATE trigger if 2+ views
        if (views >= 2) {
            console.log('[Survey] 2+ product views detected – showing modal now');
            showSurveyModal('multiple_views');
            return; // No need to set inactivity
        }

        // Inactivity detection
        let inactivityTimer;

        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(() => {
                console.log('[Survey] 15s inactivity detected – showing modal');
                showSurveyModal('inactivity');
            }, 15000);
        }

        ['mousemove', 'scroll', 'keydown', 'click'].forEach(event =>
            window.addEventListener(event, resetInactivityTimer)
        );

        resetInactivityTimer(); // Start timer
    });
</script>
