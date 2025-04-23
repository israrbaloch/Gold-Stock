<div class="shipping-container d-none">
    <h2>
        Shipping Information
    </h2>
    <hr>

    {{-- Shipping --}}
    <div class="shipping-method-container">
        <label for="shipping-method">
            Shipping Method:
        </label>
        <select id="shipping-method" class="form-select">
            @foreach ($shippingOptions as $option)
                <option value="{{ $option->id }}" data-name="{{ $option->name }}"
                    data-price="{{ $subTotal > $option->free_from ? 0 : $option->price }}"
                    {{ $shippingOption->id == $option->id ? 'selected' : '' }}>
                    {{ $option->name }}:
                    @if ($subTotal > $option->free_from && $option->price > 0)
                        $20 {{ $currency }}
                    @else
                        Free
                    @endif
                </option>
            @endforeach
        </select>
    </div>

    <hr>

    {{-- Apply promo code --}}


    <form id="shipping-address-form" method="post" action="/update-shiping-info">
        @csrf

        <div class="update-billing">
            Add/Update Shipping Address
        </div>

        <div class="validate-required validate-required" id="billing_first_name_field" data-priority="10">
            <input type="text" class="input-text " name="billing_first_name" id="billing_first_name"
                placeholder="First name" value="{{ $account->fname }}" autocomplete="given-name" disabled="">
        </div>
        <div class="validate-required validate-required" id="billing_last_name_field" data-priority="20">
            <input type="text" class="input-text " name="billing_last_name" id="billing_last_name"
                placeholder="Last name" value="{{ $account->lname }}" autocomplete="family-name" disabled="">
        </div>
        <div class="validate-required validate-required validate-phone" id="billing_phone_field" data-priority="40">
            <input type="text" class="input-text " name="billing_phone" id="billing_phone" placeholder="Phone"
                value="{{ $account->phone }}" autocomplete="tel" disabled="">
        </div>
        <div class="address-field form-row-wide validate-required" id="billing_address_1_field" data-priority="50">
            <input type="text" class="input-text " name="billing_address_1" id="billing_address_1"
                placeholder="Street address" value="{{ $account->address_line1 }}" autocomplete="address-line1"
                disabled="">
        </div>
        <div class="address-field validate-required" id="billing_city_field" data-priority="70">
            <input type="text" class="input-text " name="billing_city" id="billing_city" placeholder="Town / City"
                value="{{ $account->city }}" autocomplete="address-level2" disabled="">
        </div>
        <div class="address-field validate-required" id="billing_province_field" data-priority="80">

            @php
                // $provinceName = $provinces_list[$account->province_id];
                $provinceName = isset($provinces_list[$account->province_id]) ? $provinces_list[$account->province_id] : '';
            @endphp
            <input type="text" class="input-text " name="billing_province" id="billing_province"
                placeholder="Province" value="{{ $provinceName }}" autocomplete="address-level2" disabled="">
            <select id="billing_province_id" name="billing_province_id" class="form-control d-none">
                @foreach ($provinces as $province)
                    @php
                        $selected = $provinceName == $province->name ? ' selected' : null;
                    @endphp
                    <option value={{ $province->id }}{{ $selected }}>
                        {{ $province->name }}</option>
                @endforeach
            </select>

        </div>
        <div class="address-field form-row-wide validate-required validate-postcode" id="billing_postcode_field"
            data-priority="110">
            <input type="text" class="input-text " name="billing_postcode" id="billing_postcode"
                placeholder="Postcode / ZIP" value="{{ $account->postcode }}" autocomplete="postal-code"
                disabled="">
        </div>

        <div id="buttonsContainer" class="buttons-container d-none">
            <button id="btn-cancel-save-info" class="button medium cancel">Cancel</button>
            <button type="submit" id="btn-save-info" class="button medium done">Save</button>
        </div>

        <div id="orderComments" data-priority="70">
            <textarea name="order_comments" class="input-text " id="order_comments"
                placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
        </div>
    </form>

    <div id="pick-up-container" class="d-none" itemscope itemtype="https://schema.org/LocalBusiness">
        <h2>Pick up your order in:</h2>
        <p itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
            <span itemprop="streetAddress">3rd Floor - 55 Dundas St East</span><br>
            <span itemprop="addressLocality">Toronto</span>,
            <span itemprop="addressRegion">Ontario</span>
            <span itemprop="postalCode">M5B-1C6</span>
        </p>
        <p itemprop="openingHours" content="Mo-Fr 09:00-18:00">Monday - Friday 9am - 6pm</p>
    </div>

    <div class="buttons-container">
        <button type="button" class="button medium progress-button" id="progressButtonShipping"
            data-step="summary">
            Continue
        </button>
    </div>
</div>
