@extends('header.index')

@section('extratitle')
    Log In
@endsection

@section('content')
    {{-- <br><br><br><br><br>
    <h4 class="text-center mt-5 mb-4">Log In</h4>
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
                            <div class="col-9 offset-1 text-bold">
                                Forgot your login details? <a class="color-dark-green"
                                    href="https://goldstockcanada.com/account/lost-password/"> Click here to reset your
                                    password.</a>
                            </div>
                        </div>
                        <br>
                        <div class="row" style="margin-left: 20px;">
                            <div class="col-md-5">
                                <input type="button" class="btnl btn-green" value="Log In">
                            </div>
                            <div class="col-md-5">
                                <input type="button" class="btnl btn-yellow" value="Register">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="col-md-4 txt-bg">
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
    </div> --}}
@endsection


@push('scripts')
    <script>
        // on ready show login modal
        $(document).ready(function() {
            $('#loginModal').modal('show');
        });
    </script>
@endpush
