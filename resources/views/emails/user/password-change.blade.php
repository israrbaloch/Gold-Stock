@component('components.base')
    <style>
        a {
            word-break: break-all;
        }
    </style>

    <x-banner />

    <h1>
        Hello
    </h1>
    <p>
        You are receiving this email because we received a password reset request for your account.
    </p>
    <br>

    @component('components.button', ['url' => url('/password/reset/' . $token)])
        Reset Password
    @endcomponent

    <br>
    <p>
        This password reset link will expire in 60 minutes.
    </p>
    <br>
    <p>
        If you did not request a password reset, no further action is required.
    </p>

    <br>
    <hr>
    <br>

    <span>
        If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:
        <a href="{{ url('/password/reset/' . $token) }}">
            {{ url('/password/reset/' . $token) }}
        </a>
    </span>

    @component('components.footer')
    @endcomponent
@endcomponent
