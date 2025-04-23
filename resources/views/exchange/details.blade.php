<div class="row col-md-12">
    <div class="details-container col">
        <div class="detail">
            <div class="subtitle">
                24h change
            </div>
            <div class="title">
                <span class="{{ $_metal }}-percentage {{ $_metals[$_metal]->change_percent < 0 ? 'low' : 'high' }}">
                    @php
                        echo $_metals[$_metal]->change_percent . '%';
                    @endphp
                </span>
            </div>
        </div>
        <div class="detail">
            <div class="subtitle">
                24h high
            </div>
            <div class="title">
                <span class="{{ $_metal }}-high">
                    @php
                        echo '$' . addCommas($_metals[$_metal]->daily_highest * $_currencyRate);
                    @endphp
                </span>
            </div>
        </div>
        <div class="detail">
            <div class="subtitle">
                24h low
            </div>
            <div class="title">
                <span class="{{ $_metal }}-low">
                    @php
                        echo '$' . addCommas($_metals[$_metal]->daily_lowest * $_currencyRate);
                    @endphp
                </span>
            </div>
        </div>
    </div>

    <div class="notify-me-container ms-auto mt-auto col mb-md-0 mb-3 d-flex d-md-block d-none">
        @auth
            <button class="button medium px-4 ms-md-0 me-md-0 ms-auto me-3" data-bs-toggle="modal"
                data-bs-target="#productAlertModal">
                <i class="far fa-bell me-2"></i>
                Notify Me
            </button>
        @else
            <button class="button medium px-4 ms-md-0 me-md-0 ms-auto me-3" data-bs-toggle="modal"
                data-bs-target="#loginModal">
                <i class="far fa-bell me-2"></i>
                Notify Me
            </button>
        @endauth
    </div>
    
    @include('header.exchange-alert-modal')
</div>