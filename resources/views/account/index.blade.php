@extends('header.index')

@push('styles')
    <link href="/css/my-account.css?ver=1.1.0" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="/js/my-account.js?ver=1.3.0"></script>
@endpush

@section('content')
    <div class="page-container container my-account-container">

        <div class="only-mobile" style="margin-top: 20px;">
            <div class="title-page-1 text-center">PROFILE</div>
            <div id="user-info-section" class="row">
                <div id="user-img-container" class="col-2">
                    <i class="material-icons">
                        account_circle
                    </i>
                </div>
                <div class="col-10">
                    <div><strong>{{ $user->email }}</strong></div>
                    <div>Last login Time: {{ $myaccount->last_login_time }}</div>
                    <div>IP: {{ $myaccount->last_ip_address }}</div>
                </div>
            </div>
            <div id="warning-msg" class="row bottom-border">
                <div class="col-10 offset-1 text-center">
                    Please do not disclose Email and Google Authentication codes to anyone.
                </div>
            </div>
            <div class="row g-0 padding-help-1">
                <div id="my-account-show-trigger" class="col-12 pointer text-center bottom-border-light">
                    USER PROFILE
                </div>
                <div id="my-account-show-content" class="col-12 bottom-border-light" style="display: none;">
                    <div class="profile-value color-light-blue">
                        Account number: {{ $myaccount->number }} </div>
                    <div class="profile-value">
                        Email: {{ $user->email }} </div>
                    <div class="profile-value text-bold">
                        {{ $myaccount->fname }} {{ $myaccount->lname }} </div>
                    <div class="profile-value">
                        {{ $myaccount->address_line1 }} </div>
                    <div class="profile-value">
                        {{ $myaccount->city }}, {{ $myaccount->abbrev }} </div>
                    <div class="profile-value">
                        Phone number: {{ $myaccount->phone }} </div>
                </div>
            </div>
            <div id="user-options">

                <div class="row bottom-border height-padding no-gutters">
                    <div class="col-2 coin-img padding-help-2"><img style="padding-top: 5px;" src="/img/id-auth.png"></div>
                    <div href="#" class="col-10 user-option padding-help-3 identify-show-trigger">
                        Identity Authentication
                        @if ($myaccount->verification_status == false)
                            <div href="#" class="float-right gold-color">
                                Unverified
                            </div>
                        @else
                            <div class="float-right gold-color">
                                Verified
                            </div>
                        @endif
                    </div>
                </div>
                <div class="identify-show-content col-12 my-account-modal-mobile modal fade">
                    <button type="button" style="display: none;" class="btn-close" data-bs-dismiss="modal"
                        data-dismiss="modal" aria-label="x"></button>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="row">
                                <div class="col-12 text-center gold-color">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                                        aria-label="x"></button>
                                    <b>Your Current Identification:</b>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <b>No identification uploaded yet.</b>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <b>Upload a picture of your Driver License or passport</b>
                                    <br>
                                    (If you upload a new img, the current would be replaced, even if already verified)
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <form class="fileUpload" enctype="multipart/form-data">
                                        <input type="file" id="indetify-img" name="indetify-img"
                                            accept="image/png, image/jpeg">
                                    </form>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <div id="submit-identify" href="#" class="identify-btn btn makeup-btn-dark-green">
                                        Submit
                                        Image</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row bottom-border height-padding no-gutters">
                    <div class="col-2 coin-img padding-help-2"><img style="padding-top: 5px;" src="/img/google-auth.png">
                    </div>
                    <div class="col-10 user-option padding-help-3">
                        <form class="form-horizontal" method="POST" action="{{ route('generate2faSecret') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <button id="mobile-google2fa" class="btn btn-primary">
                                    Generate Secret Key to Enable 2FA
                                </button>
                            </div>
                        </form>
                        Google Authenticator
                        <div class="float-end form-check form-switch">
                            <input id="mobile-two-steps-input" class="float-end form-check-input" type="checkbox"
                                role="switch" data-user-id="{{ $user->id }}"
                                data-has-google="{{ $myaccount->has_google }}"
                                data-has-email="{{ $myaccount->has_email }}">
                        </div>
                        <br><br>
                        <span class="float-right" style="margin-right: 10px">
                            <span id="mobile-renovate-qr" style="display: none" href="#"
                                class="btn makeup-btn-dark-green pointer">
                                <b>
                                    RENOVATE
                                </b>
                            </span>
                        </span>
                    </div>
                </div>
                <div id="mobile-auth-container"
                    class="row bottom-border height-padding no-gutters my-account-modal-mobile modal fade">
                    <button type="button" style="display: none;" class="btn-close" data-bs-dismiss="modal"
                        data-dismiss="modal" aria-label="x"></button>
                    <div class="modal-dialog">
                        <div class="modal-content row g-0">
                            <div class="col-12">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                                    aria-label="x"></button>
                                <form id="mobile-second-step-google-enable" class="form-login-mobile login-form"
                                    method="post">

                                    <div class="row text-center frm-title">
                                        <div class="col-12"><br>
                                            <h5>Please use your Google Authenticator App to scan the RQ code and enter
                                                google authentication code, in order to configure your second step login.
                                            </h5><br>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <img class="qr-img"
                                            src="https://api.qrserver.com/v1/create-qr-code/?data=otpauth%3A%2F%2Ftotp%2FGold_Stock_Login%3Fsecret%3DLZQ6XVJKLMUSA6HT&amp;size=200x200&amp;ecc=M"
                                            alt="">
                                    </div>
                                    <div class="row">
                                        <div class="col-3 text-left">
                                            <br>
                                            Code:
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="email-input" name="google-code"
                                                id="mobile-google-code">
                                            <input type="hidden" id="mobile-not-secret" name="not-secret"
                                                value="LZQ6XVJKLMUSA6HT">
                                            <input type="hidden" id="mobile-user-id" name="user-id" value="415">
                                            <div class="error username-error" style="display: none;">This field is
                                                required.
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-12 text-left">
                                            <button type="submit" class="button button-2"
                                                name="continue">VALIDATE</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="mobile-auth-container-disable"
                    class="row bottom-border no-gutters my-account-modal-mobile modal fade">
                    <button type="button" style="display: none;" class="btn-close" data-bs-dismiss="modal"
                        data-dismiss="modal" aria-label="x"></button>
                    <div class="modal-dialog">
                        <div class="modal-content row g-0">
                            <div class="col-12">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                                    aria-label="x"></button>
                                <form id="mobile-second-step-google-disable" class="form-login-mobile login-form"
                                    method="post">
                                    <div class="row text-center frm-title">
                                        <div class="col-12"><br>
                                            <h5>Please enter your google authentication code in order to disable it</h5><br>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-3 text-left">
                                            <br>
                                            Code
                                        </div>
                                        <div class="col-9">
                                            <input type="hidden" id="mobile-user-id-disable" name="user-id"
                                                value="415">
                                            <input type="text" class="email-input" name="mobile-google-code-disable"
                                                id="mobile-google-code-disable">
                                            <div class="error username-error" style="display: none;">This field is
                                                required.
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-12 text-left">
                                            <button type="submit" class="button button-2"
                                                name="continue">VALIDATE</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row bottom-border height-padding no-gutters">
                    <div class="col-2 coin-img padding-help-2">
                        <img style="padding-top: 5px;" src="/img/two-step-email.png">
                    </div>
                    <div class="col-10 user-option padding-help-3">
                        Email authenticator
                        <div class="float-end form-check form-switch">
                            <input id="mobile-two-steps-input-email" class="float-end form-check-input" type="checkbox"
                                role="switch" data-user-id="{{ $user->id }}"
                                data-has-google="{{ $myaccount->has_google }}"
                                data-has-email="{{ $myaccount->has_email }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="mobile-auth-container-email" class="row login-box my-account-modal-mobile modal fade">
                        <button type="button" style="display: none;" class="btn-close" data-bs-dismiss="modal"
                            data-dismiss="modal" aria-label="x"></button>
                        <div class="modal-dialog">
                            <div class="modal-content row g-0">
                                <div class="col-12">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        data-dismiss="modal" aria-label="x"></button>
                                    <form id="mobile-second-step-email-enable" class="form-login-mobile login-form"
                                        method="post">
                                        <div class="row text-center frm-title">
                                            <div class="col-12"><br>
                                                <h5>Please enter the code that was sent to your email, to activate the
                                                    authentication.</h5><br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 text-left">
                                                <br>
                                                Code
                                            </div>
                                            <div class="col-9">
                                                <input type="hidden" id="mobile-user-id-email" name="user-id"
                                                    value="415">
                                                <input type="text" class="email-input" name="email-code"
                                                    id="mobile-email-code">
                                                <div class="error username-error" style="display: none;">This field is
                                                    required.</div>
                                            </div>
                                        </div>
                                        <br>
                                        <br><br>
                                        <div class="row">
                                            <div class="col-6 text-left">
                                                <button type="submit" class="button button-2"
                                                    name="continue">VALIDATE</button>
                                            </div>
                                            <div class="col-6 text-left">
                                                <button type="button" class="resend-email-code button button-1"
                                                    name="re-send cdoe">re-send code</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="mobile-auth-container-email-disable"
                        class="row login-box my-account-modal-mobile modal fade">
                        <button type="button" style="display: none;" class="btn-close" data-bs-dismiss="modal"
                            data-dismiss="modal" aria-label="x"></button>
                        <div class="modal-dialog">
                            <div class="modal-content row g-0">
                                <div class="col-12">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        data-dismiss="modal" aria-label="x"></button>
                                    <form id="mobile-second-step-email-disable" class="form-login-mobile login-form"
                                        method="post">
                                        <div class="row text-center frm-title">
                                            <div class="col-12"><br>
                                                <h5>Please enter the code that was sent to your email, to disable the
                                                    authentication.</h5><br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 text-left">
                                                <br>
                                                Code
                                            </div>
                                            <div class="col-9">
                                                <input type="hidden" id="mobile-user-id-email-disable" name="user-id"
                                                    value="415">
                                                <input type="text" class="email-input" name="email-code-disable"
                                                    id="mobile-email-code-disable">
                                                <div class="error username-error" style="display: none;">This field is
                                                    required.</div>
                                            </div>
                                        </div>
                                        <br>
                                        <br><br>
                                        <div class="row">
                                            <div class="col-6 text-left">
                                                <button type="submit" class="button button-2"
                                                    name="continue">VALIDATE</button>
                                            </div>
                                            <div class="col-6 text-left">
                                                <button type="button" class="resend-email-code button button-1"
                                                    name="re-send cdoe">re-send code</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row bottom-border height-padding no-gutters">
                    <div class="col-2 coin-img padding-help-2"><img style="padding-top: 5px;"
                            src="img/change-password.png">
                    </div>
                    <a class="col-10 user-option padding-help-3" href="{{ route('password.request') }}">
                        Change Password
                        <div class="float-end"><i class="material-icons"> arrow_forward_ios </i></div>
                    </a>
                </div>

                <div class="logout-container">
                    <a href="https://goldstockcanada.com/wp-login.php?action=logout&amp;redirect_to=https%3A%2F%2Fgoldstockcanada.com&amp;_wpnonce=190a6a8542"
                        class="lg-btn btn makeup-btn-dark-green">Logout</a>
                </div>
            </div>
        </div>

        <div class="d-none d-sm-block only-desktop">
            {{-- <div class="row g-0">
            <div class="col-12">
                <img style="width: 100%;"
                     src="/img/dashboard.jpg">
            </div>
        </div> --}}

            <h1>
                My Account
            </h1>

            <div class="row new-profile-title">
                <div class="title title-page-1 col-12 text-center">PROFILE</div>
            </div>

            @include('account.avatar')

            @include('account.profile.index')
        </div>
    </div>

    <div class="row">
        <div id="auth-container" class="row login-box my-account-modal modal fade">
            <button type="button" style="display: none;" class="btn-close" data-bs-dismiss="modal"
                data-dismiss="modal" aria-label="x"></button>
            <div class="modal-dialog">
                <div class="modal-content row g-0">
                    <div class="col-12">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                            aria-label="x"></button>
                        <form id="second-step-google-enable" class="login-form" method="post">

                            <div class="row text-center frm-title">
                                <div class="col-12"><br>
                                    <h5>Please use your Google Authenticator App to scan the QR code and
                                        enter google authentication code, in order to configure your second
                                        step login.</h5><br>
                                </div>
                            </div>
                            <div class="row text-center">
                                <img id="qr-img" class="qr-img" src="">
                            </div>
                            <div class="row">
                                <div class="col-3 text-left">
                                    Code:
                                </div>
                                <div class="col-9">
                                    <input type="password" class="email-input" name="google-code" id="google-code">
                                    <div class="error username-error" style="display: none;">This field is required.</div>
                                </div>
                            </div>
                            <br>
                            <br><br>
                            <div class="row">
                                <div class="col-12 text-left">
                                    <button id="enable_fa" class="button button-2">VALIDATE</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="auth-container-disable" class="row login-box my-account-modal modal fade">
            <button type="button" style="display: none;" class="btn-close" data-bs-dismiss="modal"
                data-dismiss="modal" aria-label="x"></button>
            <div class="modal-dialog">
                <div class="modal-content row g-0">
                    <div class="col-12">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                            aria-label="x"></button>
                        <form id="second-step-google-disable" class="form-login-mobile login-form" method="post">

                            <div class="row text-center frm-title">
                                <div class="col-12"><br>
                                    <h5>Please enter your google authentication code in order to disable it
                                    </h5><br>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-3 text-left">
                                    <br>
                                    Code
                                </div>
                                <div class="col-9">
                                    <input type="password" class="email-input" name="google-code-disable"
                                        id="google-code-disable">
                                    <div class="error username-error" style="display: none;">This field is
                                        required.</div>
                                </div>
                            </div>
                            <br>
                            <br><br>
                            <div class="row">
                                <div class="col-12 text-left">
                                    <button id="disable_fa" class="button button-2">VALIDATE</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="auth-container-email" class="row login-box my-account-modal modal fade">
            <button type="button" style="display: none;" class="btn-close" data-bs-dismiss="modal"
                data-dismiss="modal" aria-label="x"></button>
            <div class="modal-dialog">
                <div class="modal-content row g-0">
                    <div class="col-12">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                            aria-label="x"></button>
                        <form id="second-step-email-enable" class="form-login-mobile login-form" method="post">
                            <div class="row text-center frm-title">
                                <div class="col-12"><br>
                                    <h5>Please enter the code that was sent to your email, to activate the
                                        authentication.</h5><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 text-left">
                                    Code
                                </div>
                                <div class="col-9">
                                    <input type="text" class="email-input" name="email-code" id="email-code">
                                    <div class="error username-error" style="display: none;">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br><br>
                            <div class="row">
                                <div class="col-6 text-left">
                                    <button id="enable-email-btn" type="submit" class="button button-2"
                                        name="continue">VALIDATE</button>
                                </div>
                                <div class="col-6 text-left">
                                    <button type="button" class="resend-email-code button button-1"
                                        name="re-send cdoe">re-send code</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="auth-container-email-disable" class="row login-box my-account-modal modal fade">
            <button type="button" style="display: none;" class="btn-close" data-bs-dismiss="modal"
                data-dismiss="modal" aria-label="x"></button>
            <div class="modal-dialog">
                <div class="modal-content row g-0">
                    <div class="col-12">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                            aria-label="x"></button>
                        <form id="second-step-email-disable" class="form-login-mobile login-form" method="post">
                            <div class="row text-center frm-title">
                                <div class="col-12"><br>
                                    <h5>Please enter the code that was sent to your email, to disable the
                                        authentication.</h5><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 text-left">
                                    Code
                                </div>
                                <div class="col-9">
                                    <input type="text" class="email-input" name="email-code" id="email-code">
                                    <div class="error username-error" style="display: none;">This field is
                                        required.</div>
                                </div>
                            </div>
                            <br>
                            <br><br>
                            <div class="row">
                                <div class="col-6 text-left">
                                    <button id="disable-email-btn" class="button button-2"
                                        name="continue">VALIDATE</button>
                                </div>
                                <div class="col-6 text-left">
                                    <button type="button" class="resend-email-code button button-1"
                                        name="re-send cdoe">re-send code</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
