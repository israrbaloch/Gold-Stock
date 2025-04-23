@extends('header.index')

@push('styles')
    <link href="{{ URL::to('/') }}/css/login.css?ver=1.1.0" rel="stylesheet">
@endpush

@section('content')
    <br class="d-none d-md-block">
    <br class="d-none d-md-block">
    <br class="d-none d-md-block">
    <br class="d-none d-md-block">

    <div class="container-form">
        <br class="d-none d-md-block">
        <br class="d-none d-md-block">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="container">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <br class="d-none d-md-block">
                        <br class="d-none d-md-block">
                        <div class="form-main">
                            <div class="div-container">
                                <div class="row">
                                    <div class="col-12 col-md-9 offset-md-1">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus
                                            placeholder="Email">
                                        <div class="error username-error" style="display: none;">This field is required.
                                        </div>
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-12 col-md-9 offset-md-1 btn-reset-container">
                                        <button type="submit" class="btnl btn-green btn-reset">
                                            {{ __('Send Password Reset Link') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="d-none d-md-block col-md-4 txt-bg">
                <h4 class="text-center color-dark-green text-bold">
                    LOST YOUR PASSWORD?
                </h4>
                <br><br>
                <div class="txt-text">
                    Please enter your username or email address. You will receive a link to create a new password via email.
                </div>
            </div>
        </div>
    </div>
@endsection
