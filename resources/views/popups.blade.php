<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Popups Mockups</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tienne:wght@400;700;900&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Tienne:wght@400;700;900&display=swap');

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

    .cookie-setting {
        background: #f5f5f5;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .cookie-label {
        font-weight: 600;
    }

    .cookie-subtext {
        color: gray;
        font-size: 0.85rem;
        font-weight: normal;
    }

    .toggle-switch {
        position: relative;
        width: 40px;
        height: 22px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        background-color: #ccc;
        border-radius: 34px;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        transition: 0.4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #333;
    }

    input:checked+.slider:before {
        transform: translateX(18px);
    }
</style>

<body>
    <main>
        <div class="container mt-5 text-center">
            <h1>Popups Mockups</h1>
            <p>This page is designed to showcase various popups that can be used in a web application.</p>
            <div class="row">
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal1">
                        Seasonal Sale Announcement
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal2">
                        Limited Time Offer
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal3">
                        Email Verification
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal4">
                        Product Review
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal5">
                        Loyalty Program
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal6">
                        Cart Abandonment
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal7">
                        Login/Signup
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal8">
                        Re-Engagement
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal9">
                        Birthday Rewarad
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal10">
                        VIP Access
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal11">
                        Exit Intent
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal12">
                        Give 10, Get 10
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal13">
                        Free Shipping
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal14">
                        Order Status Update
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal15">
                        Get Gold Rewards
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal16">
                        First Time User
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal17">
                        Might Like This
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal18">
                        Newsletter
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal19">
                        Cookies Preferences
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal20">
                        Recently Viewed
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ExampleModal21">
                        Perfect Product
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="ExampleModal1" tabindex="-1" aria-labelledby="ExampleModal1Label"
            aria-hidden="true">
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
                            <button type="button" class="btn btn-base">Remind Me Later</button>
                        </div>
                        <hr>
                        <img src="{{ asset('img/popus/seasonal.png') }}" alt="seasonal sale image" class="img-fluid"
                            style="width: 100%; height: auto;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="ExampleModal2" tabindex="-1" aria-labelledby="ExampleModal2Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="modal-title-image"><img src="{{ asset('img/popus/rocket.png') }}"
                                alt="modal title image" width="200px"></p>
                        <p class="modal-title">🔥 Limited-Time Offer! 🔥</p>
                        <p class="modal-sub-title">Get 20% OFF your order! Hurry, offer expires in:</p>
                        <p class="timer">02:59</p>
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Shop Now</button>
                            <button type="button" class="btn btn-base">No, Thanks</button>
                        </div>
                        {{-- <hr> --}}
                        {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="ExampleModal3" tabindex="-1" aria-labelledby="ExampleModal3Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body" style="padding: 180px 70px 70px">
                        <div class="background">

                        </div>
                        <p class="modal-title-image"><img src="{{ asset('img/popus/email.png') }}"
                                alt="modal title image" width="200px"></p>
                        <p class="modal-title">Verify Your Email Address</p>
                        <p class="modal-sub-title">We've sent a verification link to user@example.com. </p>
                        <p class="modal-sub-title">Please check your inbox and click the link to activate your account.
                        </p>
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Resend Email</button>
                            <button type="button" class="btn btn-base">Chnage Email</button>
                            <button type="button" class="btn btn-base">OK</button>
                        </div>
                        {{-- <hr> --}}
                        {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal4" tabindex="-1" aria-labelledby="ExampleModal4Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="modal-title-image"><img src="{{ asset('img/popus/review.png') }}"
                                alt="modal title image" width="200px"></p>
                        <p class="modal-title">⭐ How was your experience?</p>
                        <p class="modal-sub-title">We’d love to hear your thoughts on <strong>[Product Name]</strong>!
                        </p>
                        <div class="product-ratings">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <form action="" class=" feedback-form">
                            <textarea name="" id="" cols="30" rows="4" placeholder="Write your review here...."></textarea>
                            <div class="btn-group">
                                <button type="button" class="btn btn-base">Submit review</button>
                                <button type="button" class="btn btn-base">Not Now</button>
                            </div>
                        </form>
                        {{-- <hr> --}}
                        {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal5" tabindex="-1" aria-labelledby="ExampleModal5Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="modal-title-image"><img src="{{ asset('img/popus/loyalty.png') }}"
                                alt="modal title image" width="200px"></p>
                        <p class="modal-title">🎁 Join Our Loyalty Program!</p>
                        <p class="modal-sub-title">Sign up & get 100 bonus points instantly!</p>
                        <p class="modal-sub-title">Earn points on every purchase & redeem exciting rewards.</p>
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Join Now, It's Free</button>
                            <button type="button" class="btn btn-base">No, I'll Miss Out</button>
                        </div>
                        {{-- <hr> --}}
                        {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal6" tabindex="-1" aria-labelledby="ExampleModal6Label"
            aria-hidden="true">
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
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal7" tabindex="-1" aria-labelledby="ExampleModal7Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="modal-title-image"><img src="{{ asset('img/popus/login.png') }}"
                                alt="modal title image" width="200px"></p>
                        <p class="modal-title">Unlock Your Best Experience!</p>
                        <p class="modal-sub-title">Sign in to save your progress, get personalized recommendations,
                            and enjoy exclusive features.</p>
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Login</button>
                            <button type="button" class="btn btn-base">Sign Up </button>
                            <button type="button" class="btn btn-base">Maybe Later</button>
                        </div>
                        {{-- <hr> --}}
                        {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal8" tabindex="-1" aria-labelledby="ExampleModal8Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="modal-title-image"><img src="{{ asset('img/popus/reengagement.png') }}"
                                alt="modal title image" width="200px"></p>
                        <p class="modal-title">👋 We Miss You!</p>
                        <p class="modal-sub-title">Come back & enjoy 20% OFF on your next order!</p>
                        <p class="modal-sub-title">Offer expires in: <span
                                class="timer"><strong>22:59</strong></span></p>
                        <button class="btn btn-lg btn-secondary">Use Code: WELCOME20</button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Claim My Discount</button>
                            <button type="button" class="btn btn-base">No Thanks, Maybe later </button>
                        </div>
                        {{-- <hr> --}}
                        {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal9" tabindex="-1" aria-labelledby="ExampleModal9Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="modal-title-image"><img src="{{ asset('img/popus/birthday.png') }}"
                                alt="modal title image" width="200px"></p>
                        <p class="modal-title">🎉 Happy Birthday, [Name]!</p>
                        <p class="modal-sub-title">We have a special gift just for you!</p>
                        <button class="btn btn-lg btn-secondary">Click to Reveal Your Gift!</button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Not Now</button>
                        </div>
                        {{-- <hr> --}}
                        {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal10" tabindex="-1" aria-labelledby="ExampleModal10Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="modal-title-image"><img src="{{ asset('img/popus/vip.png') }}"
                                alt="modal title image" width="200px"></p>
                        <p class="modal-title">🎟️ VIP Early Access!</p>
                        <p class="modal-sub-title">Sign up now & get **exclusive early access** to our biggest sale!
                        </p>
                        <button class="btn btn-lg btn-secondary">Click to Reveal Your Gift!</button>
                        <form action="" class=" feedback-form">
                            <input type="text" placeholder="Enter your email">
                            <div class="btn-group">
                                <button type="button" class="btn btn-base">Unlock Early Access</button>
                                <button type="button" class="btn btn-base">No Thanks, I’ll wait</button>
                            </div>
                        </form>
                        {{-- <hr> --}}
                        {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal11" tabindex="-1" aria-labelledby="ExampleModal11Label"
            aria-hidden="true">
            <div class="modal-dialog horizontal-modal">
                <div class="modal-content">
                    <div class="main-body">
                        <div class="col-md-4 modal-left">
                            <p class="modal-title-image"><img src="{{ asset('img/popus/exit.png') }}"
                                    alt="modal title image" width="200px"></p>
                        </div>
                        <div class="col-md-4 modal-right">
                            <p class="modal-title">Wait! Don't Leave Yet</p>
                            <p class="modal-sub-title">Get an exclusive 10% OFF your order now. Use code: SAVE10</p>
                            <div class="btn-group">
                                <button type="button" class="btn btn-base">Unlock Early Access</button>
                                <button type="button" class="btn btn-base">No Thanks, I’ll wait</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal12" tabindex="-1" aria-labelledby="ExampleModal12Label"
            aria-hidden="true">
            <div class="modal-dialog horizontal-modal">
                <div class="modal-content">
                    <div class="main-body">
                        <div class="col-md-4 modal-left">
                            <p class="modal-title-image"><img src="{{ asset('img/popus/gift.png') }}"
                                    alt="modal title image" width="200px"></p>
                        </div>
                        <div class="col-md-4 modal-right">
                            <p class="modal-title">🎉 Give $10, Get $10!</p>
                            <p class="modal-sub-title">Invite your friends & both of you get a **$10 discount**!</p>
                            <form action="" class="feedback-form">
                                <input type="text" placeholder="Enter your email"
                                    value="https://www.site.com/ref?user=123" disabled>
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
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal13" tabindex="-1" aria-labelledby="ExampleModal13Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="modal-title-image"><img src="{{ asset('img/popus/shipping.png') }}"
                                alt="modal title image" width="200px"></p>
                        <p class="modal-title">🚚 You're Almost There!</p>
                        <p class="modal-sub-title">Add $10.00 more to your cart for **FREE SHIPPING!**</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Continue Shopping</button>
                            <button type="button" class="btn btn-base">No, i’ll Pay for shipping</button>
                        </div>
                        {{-- <hr> --}}
                        {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal14" tabindex="-1" aria-labelledby="ExampleModal14Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="modal-title-image"><img src="{{ asset('img/popus/shipping.png') }}"
                                alt="modal title image" width="200px"></p>
                        <p class="modal-title">📦 Order Status Update</p>
                        <p class="modal-sub-title"><strong>Order #123456</strong>  has been shipped! 🚚</p>
                        <p class="modal-sub-title">Order Progress:<strong> Shipped</strong>  </p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                aria-valuemax="100" style="width: 55%; background-color: #1570F0;">
                            </div>
                            <p class="modal-sub-title">Expected Delivery: <strong>2 Days</strong>  </p>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Track Order</button>
                            <button type="button" class="btn btn-base">Close</button>
                        </div>
                        {{-- <hr> --}}
                        {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal15" tabindex="-1" aria-labelledby="ExampleModal15Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="modal-title-image"><img src="{{ asset('img/popus/earn.png') }}"
                                alt="modal title image" width="200px"></p>
                        <p class="modal-title">🏆 Earn Gold with Every Purchase!</p>
                        <p class="modal-sub-title">Buy gold and get bonus rewards!
                            The more you invest, the more you earn</p>
                        <p class="modal-sub-title"><strong>For every $100 spent → Earn 0.5g Gold</strong>  </p>
                        <p class="modal-sub-title"><strong>Spend $500 → Get 3g Gold!</strong>  </p>
                        <p class="modal-sub-title">You're close to earning your next reward! 🌟</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                aria-valuemax="100" style="width: 55%; background-color: #1570F0;">
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Track Order</button>
                            <button type="button" class="btn btn-base">Close</button>
                        </div>
                        {{-- <hr> --}}
                        {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal16" tabindex="-1" aria-labelledby="ExampleModal16Label"
            aria-hidden="true">
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
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal17" tabindex="-1" aria-labelledby="ExampleModal17Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="modal-title">🛍️ You Might Like This!</p>
                        <p class="modal-sub-title">Based on your browsing, we think you’ll love this:</p>
                        <div class="product-section">
                            <p class="modal-title-image"><img src="{{ asset('img/popus/product.png') }}"
                                    alt="modal title image" width="100px"></p>
                            <span>2024 1oz Gold Maple Leaf
                                Coin (King Charles)</span>
                            <p class="modal-title">
                                <strong>
                                    ⭐ 4.8 | $49.99
                                </strong>
                            </p>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Login</button>
                            <button type="button" class="btn btn-base">Sign Up </button>
                            <button type="button" class="btn btn-base">Maybe Later</button>
                        </div>
                        {{-- <hr> --}}
                        {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal18" tabindex="-1" aria-labelledby="ExampleModal18Label"
            aria-hidden="true">
            <div class="modal-dialog horizontal-modal">
                <div class="modal-content">
                    <div class="main-body">
                        <div class="col-md-4 modal-right">
                            <p class="modal-title">Join Our Newsletter</p>
                            <p class="modal-sub-title">Subscribe and get exclusive updates & offers straight to your
                                inbox!</p>
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
        <!-- Modal -->
        <div class="modal fade" id="ExampleModal19" tabindex="-1" aria-labelledby="ExampleModal19Label"
            aria-hidden="true">
            <div class="modal-dialog" style="max-width: 700px">
                <div class="modal-content" style="max-width: 700px;">
                    <div class="modal-body cookies-preferences" style="place-items: baseline;">
                        <p class="modal-title" style="text-align: left; font-family: 'Inter', sans-serif;">
                            <strong>About Your Privacy</strong>
                        </p>
                        <p class="modal-sub-title" style="text-align: left; font-family: 'Inter', sans-serif;">We and
                            our partners are using technologies like cookies and process
                            We process your data to deliver content or advertisements and measure the
                            delivery of such content or advertisements to extract insights about our website.
                            We share this information with our partners on the basis of consent and legitimate
                            interest. You may exercise your right to consent or object to a legitimate interest,
                            based on a specific purpose below or at a partner level in the link under each
                            purpose. These choices will be signaled to our vendors.
                        </p>

                        <button type="button" class="btn btn-base" style="margin: 0px;">Allow All</button>
                        <br>
                        <p class="modal-title" style="text-align: left; font-family: 'Inter', sans-serif;">
                            <strong>Manage Consent Preferences</strong>
                        </p>
                        <br>
                        <div class="cookie-setting">
                            <div class="cookie-label">Strictly Necessary Cookies</div>
                            <div class="cookie-subtext">Always Active</div>
                        </div>

                        <div class="cookie-setting">
                            <div class="cookie-label">Functional Cookies</div>
                            <label class="toggle-switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="cookie-setting">
                            <div class="cookie-label">Performance Cookies</div>
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="cookie-setting">
                            <div class="cookie-label">
                                Personalised ads and content<br>
                                measurement, audience insights and product development.
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Reject All</button>
                            <button type="button" class="btn btn-base">Submit My choice</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="ExampleModal20" tabindex="-1" aria-labelledby="ExampleModal20Label"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="modal-title">🔄 Recently Viewed Items</p>
                        <p class="modal-sub-title">Don't forget about these items you recently checked out!</p>
                        <div class="product-section">
                            <p class="modal-title-image"><img src="{{ asset('img/popus/product.png') }}"
                                    alt="modal title image" width="100px"></p>
                            <span>2024 1oz Gold Maple Leaf
                                Coin (King Charles)</span>
                            <p class="modal-title">
                                <strong>
                                    ⭐ 4.8 | $49.99
                                </strong>
                            </p>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-base">Add to Cart</button>
                            <button type="button" class="btn btn-base">View Detail </button>
                            <button type="button" class="btn btn-base">Not Now</button>
                        </div>
                        {{-- <hr> --}}
                        {{-- <img src="{{asset('img/popus/seasonal.png')}}" alt="seasonal sale image" class="img-fluid" style="width: 100%; height: auto;"> --}}

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="ExampleModal21" tabindex="-1" aria-labelledby="ExampleModal21Label"
            aria-hidden="true">
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
                            <div class="product-section py-4 mx-2" style="padding: 0px 30px; box-shadow: 4px 5px 14px rgb(0 0 0 / 21%);">
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
                            <div class="product-section py-4 mx-2" style="padding: 0px 30px; box-shadow: 4px 5px 14px rgb(0 0 0 / 21%);">
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

                            <div class="product-section py-4 mx-2" style="padding: 0px 30px; box-shadow: 4px 5px 14px rgb(0 0 0 / 21%);">
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
    </main>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

</html>
