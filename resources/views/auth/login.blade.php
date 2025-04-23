@extends('header.index')

@push('styles')
    <link href="/css/my-account-new.css?ver=1.2.0" rel="stylesheet">
    <link href="/css/my-account.css?ver=1.2.0" rel="stylesheet">
    <link href="/css/home.css?ver=1.2.0" rel="stylesheet">
    <link href="/css/login.css?ver=1.1.0" rel="stylesheet">
@endpush

@push('scripts')
    <script type="text/javascript" src="/js/login.js?ver=1.0"></script>
@endpush

@section('content')
    <div class="page-container container invisible">
        <h4 class="text-center mt-5 mb-4">Log In</h4>
        <div class="container-form">
            <br class="d-none d-md-block"><br class="d-none d-md-block">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="container">
                        <form id="login-form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ request()->query('redirect') }}">
                            <div class="row text-center frm-title">
                                <br><br>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-9 offset-md-1">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Email">
                                    <div class="error username-error" style="display: none;">This field is required.</div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12 col-md-9 offset-md-1">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="Password">
                                    <div class="error password-error" style="display: none;">This field is required.</div>
                                </div>

                            </div>
                            <br>
                            @if (session('success'))
                                <div class="col-12 col-md-9 offset-md-1 alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (Route::has('password.request'))
                                <div class="d-none d-md-block row text-center">
                                    <div class="col-12 col-md-9 offset-md-1 text-bold">
                                        Forgot your login details? <a class="color-dark-green"
                                            href="{{ route('password.request') }}"> Click here to reset your
                                            password.</a>
                                    </div>
                                </div>
                            @endif
                            <br>
                            <div class="row buttons-container" style="margin-left: 20px;">
                                <div class="d-none d-md-block col-md-5">
                                    <button id="btn-login" type="submit" class="btnl btn-green">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                                <div class="d-block d-md-none">
                                    <button type="submit" class="btnl btn-yellow">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                                <div class="d-none d-md-block col-md-5">
                                    <a class="d-none d-md-inline" href="/register" title="Register">
                                        <input type="button" class="btnl btn-yellow" value="Register">
                                    </a>
                                </div>
                                @if (Route::has('password.request'))
                                    <div class="d-block d-md-none text-center">
                                        <div class="row">
                                            <div class="col-6 text-bold">
                                                <a class="color-dark-green" href="{{ route('password.request') }}">Forgot
                                                    password?</a>
                                            </div>
                                            <div class="col-6 text-bold">
                                                <a class="color-dark-green" href="/register">Free registration</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </form>
                    </div>
                </div>
                <div class="d-none d-md-block col-md-4 txt-bg">
                    <h4 class="text-center color-dark-green text-bold">
                        Welcome to <br>
                        <b>Goldstockcanada</b>
                    </h4>
                    <br><br>
                    <div class="txt-text">
                        View all your precious metal
                        assets in one place, anywhere online. Bullion investors:
                        Track and manage virtual portfolio with spot market
                        valuations and charts. Collectors: Enjoy your collections
                        with rich images, detailed information and appraisal valuations.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="google-form-modal" class="row login-box google-login-modal modal fade">
        <button type="button" style="display: none;" class="close modal-trap" data-dismiss="modal">×</button>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content row g-0">
                <div class="col-12">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <form id="second-step-google-login" class="form-login login-form" method="POST"
                        action="{{ route('googleLogin') }}">
                        <div class="row text-center frm-title">
                            <div class="col-12">
                                <br>
                                <br>
                                <h5>Please enter your google authentication code
                                </h5><br>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-3 text-left">
                                Code
                            </div>
                            <div class="col-9">
                                <input type="password" class="email-input" name="google-code" id="google-code">
                                <div class="error username-error" style="display: none;">
                                    This field is required.
                                </div>
                            </div>
                        </div>
                        <br>
                        <br><br>
                        <div class="row">
                            <div class="col-12 text-left">
                                <button id="google-login-btn" class="button button-2">VALIDATE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // on ready show login modal
        $(document).ready(function() {
            $('#loginModal').modal('show');
        });
    </script>
@endpush
