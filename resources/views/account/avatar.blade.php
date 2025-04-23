<div class="avatar-container">
    <div class="icon-container">
        <img class="profile-img" src="/img/userprofile-avatar.png" alt="profile">
    </div>
    <div class="content">
        <span class="name">
            {{ $myaccount->fname }} {{ $myaccount->lname }}
        </span>
        @if ($myaccount->verification_status == false)
            <div class="unverified">
                <img src="{{ URL::to('/') }}/img/icons/unverified.png" alt="unverified">
                <span>Unverified</span>
            </div>
        @else
            <div class="verified">
                <img src="{{ URL::to('/') }}/img/icons/verified.png" alt="verified">
                <span>Verified</span>
            </div>
        @endif
    </div>
</div>
