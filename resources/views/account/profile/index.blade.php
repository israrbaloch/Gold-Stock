<div class="new-profile">
    <div class="profile-container">
        @include('account.profile.personal')

        <hr>

        @include('account.profile.details')
    </div>

    <div class="profile-container">
        @include('account.profile.auth')
        
        @include('account.profile.identity')
    </div>
</div>
