<div class="profile-section">
    <h2>Authentication</h2>
    <div class="profile-value">
        <span class="title">
            <div class="image-container">
                <img height="22px" src="/img/google-auth.png">
            </div>
            Two Steps Authentication using Google Authenticator
        </span>
        <span class="value form-check form-switch">
            <form id="generatefa" class="form-horizontal" method="POST" action="{{ route('generate2faSecret') }}">
                {{ csrf_field() }}
                <label class="form-check-label">
                    <input class="form-check-input" id="two-steps-input" type="checkbox"
                        data-user-id="{{ $user->id }}" data-has-google="{{ $myaccount->has_google }}"
                        data-has-email="{{ $myaccount->has_email }}">
                    <span class="slider round"></span>
                </label>
            </form>
            @if ($myaccount->has_google)
                <br><br>
                <span class="text-center d-none"><span id="renovate-qr" href="#"
                        class="btn makeup-btn-dark-green pointer"><b>RENOVATE</b></span></span>
            @endif
        </span>
    </div>

    <div class="profile-value">
        <span class="title">
            <div class="image-container">
                <img height="22px" src="/img/two-step-email.png">
            </div>
            Two Steps Authentication Using Email
        </span>
        <span class="value form-check form-switch">
            <input class="form-check-input" id="two-steps-input-email" type="checkbox"
                data-user-id="{{ $user->id }}" data-has-google="{{ $myaccount->has_google }}"
                data-has-email="{{ $myaccount->has_email }}">
            <span class="slider round"></span>
        </span>
    </div>

    <div class="profile-value">
        <span class="title">
            <div class="image-container">
                <img height="22px" src="/img/id-auth.png">
            </div>
            Status
        </span>
        <span class="value">
            @if ($myaccount->verification_status == false)
                Unverified
            @else
                Verified
            @endif
        </span>
    </div>

    @if ($myaccount->verification_status == false)
        <div class="button-container identify-show-trigger-desk pointer">
            <div class="button medium">
                Get Verified
            </div>
        </div>
    @endif
</div>
