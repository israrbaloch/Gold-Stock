@extends('header.index')

@section('content')
    <br><br><br><br>
    <div class="container-form TT2">
        <br><br>
        <div class="row">
            <div class="col-md-8">
                <div class="container">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row text-center frm-title">
                            <br><br>
                        </div>
                        <div class="row">
                            <div class="col-8 offset-2 tt3">
                                <input id="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                                    autofocus placeholder="Email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="error username-error" style="display: none;">This field is required.</div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-8 offset-2 tt4">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password" placeholder="New Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="error password-error" style="display: none;">This field is required.</div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-8 offset-2 tt5">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirm Password">
                            </div>
                        </div>
                        <br>

                        <div class="row" style="margin-left: 20px;">
                            <div class="col-8 offset-2 row">
                                <div class="col-md-5">
                                    <button type="submit" class="btnl btn-green">
                                        {{ __('RESET PASSWORD') }}
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4 txt-bg">
                <h5 class="text-center color-dark-green text-bold">
                    LOST YOUR PASSWORD? <br>

                </h5>
                <br><br>
                <div class="txt-text">
                    Please enter your username or email address. You will receive a link to create a new password via email.
                </div>
            </div>

        </div>
    </div>
@endsection
