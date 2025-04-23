<div class="profile-section">
    <h2>Personal Information</h2>
    <div class="profile-value">
        <span class="title">
            Name:
        </span>
        <span class="value">
            {{ $myaccount->fname }} {{ $myaccount->lname }}
        </span>
    </div>
    <div class="profile-value">
        <span class="title">
            Email:
        </span>
        <span class="value">
            {{ $user->email }}
        </span>
    </div>
    <div class="profile-value">
        <span class="title">
            Address:
        </span>
        <span class="value">
            {{ $myaccount->address_line1 }}
        </span>
    </div>
    <div class="profile-value">
        <span class="title">
            City:
        </span>
        <span class="value">
            {{ $myaccount->city }}, {{ $myaccount->abbrev }}
        </span>
    </div>
    <div class="profile-value">
        <span class="title">
            Phone number:
        </span>
        <span class="value">
            {{ $myaccount->phone }}
        </span>
    </div>
    {{-- <div class="profile-value">
        <span class="title">
            Email Notifications:
        </span>
        <span class="value form-check form-switch">
            <input class="form-check-input" id="user-subscribed"
                type="checkbox" data-is-subscribed="{{ $user->subscribed }}">
            <span class="slider round"></span>
        </span>
    </div> --}}
    <div class="profile-value">
        <span class="title">
            News Notifications:
        </span>
        <span class="value form-check form-switch">
            <input class="form-check-input" id="news-subscribed" type="checkbox"
                data-is-subscribed="{{ $user->news_subscribed }}" data-type="news">
            <span class="slider round"></span>
        </span>
    </div>
    <div class="profile-value">
        <span class="title">
            Blogs Notifications:
        </span>
        <span class="value form-check form-switch">
            <input class="form-check-input" id="blogs-subscribed" type="checkbox"
                data-is-subscribed="{{ $user->blogs_subscribed }}" data-type="blogs">
            <span class="slider round"></span>
        </span>
    </div>
    <div class="profile-value">
        <span class="title">
            Promotional Notifications:
        </span>
        <span class="value form-check form-switch">
            <input class="form-check-input" id="promo-subscribed" type="checkbox"
                data-is-subscribed="{{ $user->promo_subscribed }}" data-type="promo">
            <span class="slider round"></span>
        </span>
    </div>
    <div class="profile-value">
        <span class="title">
            Change Password
        </span>
        <span class="value">
            <a href="{{ route('password.request') }}">Change</a>
        </span>
    </div>
</div>
