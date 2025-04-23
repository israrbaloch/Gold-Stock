<div class="profile-section">
    <h2>Account Details</h2>
    <div class="profile-value">
        <span class="title">
            Account number:
        </span>
        <span class="value">
            {{ $myaccount->number }}
        </span>
    </div>
    <div class="profile-value">
        <span class="title">
            Last login time:
        </span>
        <span class="value">
            {{ $myaccount->last_login_time }}
        </span>
    </div>
    <div class="profile-value">
        <span class="title">
            IP:
        </span>
        <span class="value">
            {{ $myaccount->last_ip_address }}
        </span>
    </div>
</div>
