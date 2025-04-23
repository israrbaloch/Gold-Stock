@component('components.base')
    @component('components.banner')
    @endcomponent

    <div class="content">
        <h1 style="font-size: 20px">Verify your email address</h1>

        <p>Hi,</p>
        <p><strong>{{$name}}!</strong></p>
        <p>Thank you for signing up. Please verify your email address to activate your account.</p>

        <p>
            <a href="{{$url}}" style="color: #007BFF; text-decoration: none;">
                {{$url}}
            </a>
        </p>

        <p>This link will expire in 24 hours.</p>

        @component('components.button', ['url' => $url])
            Verify your Email
        @endcomponent

        <p>If you didn’t request this, please ignore this email or contact support.</p>

        @component('components.assistance')

        @include('components.social')

        @include('components.footer')
    </div>
@endcomponent
