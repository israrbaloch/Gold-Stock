@component('components.base')
    @component('components.banner')
    @endcomponent

    <div class="content">
        <h1 style="font-size: 24px;">Exclusive Offer Just for You<br>Enjoy {{$discount}} Off!</h1>

        <p>Dear,</p>
        <p><strong>{{ $name }}</strong></p>
        <p>We love having you as part of the Gold Stock Canada community, and we want to show our appreciation with an
            exclusive discount just for you!</p>
        <p>For a limited time, enjoy {{$discount}} off your next purchase and invest smarter with precious metals.</p>

        <h2 style="margin: 0;">Your Discount Code:</h2>


        <h3 style="font-size: 22px; margin: 30px 0; font-weight: 600;">
            <span style="background-color: #ffd805; text-align: center; padding: 8px 25px; min-width: 150px; display: inline-block; border-radius: 5px;">
                {{ $promoCode->code }}
            </span>
        </h3>

        <p>Use this code at checkout to save {{$discount}} on your next order.</p>


        <div style="text-align: center; width: 100%; margin: 20px 0; display: flex; flex-wrap: wrap; justify-content: center;">
            <div style="flex: 1 1 20%; max-width: 20%; padding: 10px; box-sizing: border-box;">
                <img src="{{ asset('email-icons/image.png') }}" alt="Gold Bar"
                    style="object-fit: contain; width: 100%; max-width: 100px; max-height: 100px;">
            </div>
            <div style="flex: 1 1 20%; max-width: 20%; padding: 10px; box-sizing: border-box;">
                <img src="{{ asset('email-icons/image-1.png') }}" alt="Silver Coin"
                    style="object-fit: contain; width: 100%; max-width: 100px; max-height: 100px;">
            </div>
            <div style="flex: 1 1 20%; max-width: 20%; padding: 10px; box-sizing: border-box;">
                <img src="{{ asset('email-icons/image-2.png') }}" alt="Gold Coin"
                    style="object-fit: contain; width: 100%; max-width: 100px; max-height: 100px;">
            </div>
            <div style="flex: 1 1 20%; max-width: 20%; padding: 10px; box-sizing: border-box;">
                <img src="{{ asset('email-icons/image-3.png') }}" alt="Platinum Coin"
                    style="object-fit: contain; width: 100%; max-width: 100px; max-height: 100px;">
            </div>
            <div style="flex: 1 1 20%; max-width: 20%; padding: 10px; box-sizing: border-box;">
                <img src="{{ asset('email-icons/image-4.png') }}" alt="Palladium Coin"
                    style="object-fit: contain; width: 100%; max-width: 100px; max-height: 100px;">
            </div>
        </div>

        <h2>How to Redeem:</h2>
        <ol>
            <li>Visit our website: Gold Stock Canada</li>
            <li>Add your favorite products to the cart.</li>
            <li>Enter the code <strong>{{ $promoCode->code }}</strong> at checkout to enjoy your discount.</li>
        </ol>

        <div style="margin: 20px 0;">
            <p style="color: #ff0000; font-weight: bold;">Hurry – Offer Ends Soon!</p>
            <p>This special offer is valid until <strong>
                    {{ $promoCode->valid_until->format('F j, Y') }}
                </strong>
                . Don’t miss your chance to save on your next precious metals purchase!</p>
            @component('components.button', ['url' => route('shop')])
                Shop Now
            @endcomponent
        </div>

        @include('components.assistance')

        @include('components.social')

        <p>
            Thank you for choosing Gold Stock Canada.
        </p>

        @include('components.footer')
    </div>
@endcomponent
