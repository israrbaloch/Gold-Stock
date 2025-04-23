<div class="description-container">
    <div class="title">
        <select class="exchange-selected">
            <option value="gold" {{ $_metal == 'gold' ? 'selected' : '' }}>
                Gold/{{ $_currency }}
            </option>
            <option value="silver" {{ $_metal == 'silver' ? 'selected' : '' }}>
                Silver/{{ $_currency }}
            </option>
            <option value="platinum" {{ $_metal == 'platinum' ? 'selected' : '' }}>
                Platinum/{{ $_currency }}
            </option>
            <option value="palladium" {{ $_metal == 'palladium' ? 'selected' : '' }}>
                Palladium/{{ $_currency }}
            </option>
        </select>
    </div>
    <div class="notify-me-container d-flex d-md-none my-auto mx-auto">
        @auth
            <button class="button medium px-2 py-2 ms-md-0 me-md-0 ms-auto" data-bs-toggle="modal"
                data-bs-target="#productAlertModal">
                <i class="far fa-bell"></i>
            </button>
        @else
            <button class="button medium px-2 py-2 ms-md-0 me-md-0 ms-auto" data-bs-toggle="modal"
                data-bs-target="#loginModal">
                <i class="far fa-bell"></i>
            </button>
        @endauth
    </div>
    <div class="price my-auto ms-0">
        <span class="{{ $_metal }}-price">
            @php
                echo '$' . addCommas($_metals[$_metal]->value * $_currencyRate);
            @endphp
        </span>
    </div>
</div>
