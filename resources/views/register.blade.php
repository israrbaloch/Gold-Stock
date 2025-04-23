@extends('header.index')

@section('extratitle')
    Register
@endsection

@section('content')
    <br><br><br><br><br>
    <h4 class="text-center mt-5">Create a free account</h4>
    <p class="text-center mb-5 fs-6">Welcome To Gold Stock Canada</p>
    <div class="container-form">
        <br><br>
        <div class="row">
            <div class="col-md-8">
                <div class="container">
                    <form class="woocommerce-form-login login-form" method="post">
                        @csrf
                        <div class="row text-center frm-title">
                            <br><br>
                        </div>
                        <div class="row">
                            <div class="col-10 offset-1">
                                <input type="text" class="input-form" placeholder="Email" name="username" id="username"
                                    autocomplete="username" value="">
                                <div class="error username-error" style="display: none;">This field is required.</div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-10 offset-1">
                                <input type="password" class="input-form" placeholder="Password" name="password"
                                    id="password" autocomplete="current-password" value="">
                                <div class="error password-error" style="display: none;">This field is required.</div>
                            </div>
                        </div>
                        <br>
                        <div class="row text-center">
                            <div class="col-9 offset-1">
                                <input class="form-check-input" type="checkbox">
                                I agree to Goldstockcanada Terms of Use
                            </div>
                        </div>
                        <br>
                        <div class="row" style="margin-left: 20px;">
                            <div class="col-md-5">
                                <input type="button" class="btnl btn-green" value="Register">
                            </div>
                            <div class="col-md-5">
                                <input type="button" class="btnl btn-yellow" value="Log In">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="col-md-4 txt-bg">
                <h5 class="text-center color-dark-green text-bold">
                    THINKING OF INVESTING ON <br>
                    PRECIOUS METALS TODAY?
                </h5>
                <br><br>
                <div class="txt-text">
                    We offer a FREE investors account that offer exclusive personal, private & secured benefits.<br><br>
                    Contact your local branch to speak to a representative for account set-up.<br><br>
                    Visit our website to register or contact any of our branches to request for a registration form
                </div>
            </div>
        </div>
    </div>
@endsection
