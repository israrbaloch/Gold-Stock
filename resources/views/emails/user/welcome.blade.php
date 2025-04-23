@component('components.base')
    @component('components.banner')
    @endcomponent

    <div class="content">
        <h1 style="font-size: 24px">Welcome to Gold Stock Canada</h1>
        <h2 style="font-size: 20px; font-weight: bold;">Your Journey with Precious Metals Starts Here!</h2>

        <p>Hi,</p>
        <p><strong>{{ $name }}!</strong></p>
        <p>
            Welcome to <strong>Gold Stock Canada!</strong> We’re thrilled to have you as part of our community. Whether
            you're here to buy, refine, or simply explore the world of precious metals, you’ve come to the right place.
        </p>
        <p>
            At Gold Stock Canada, we pride ourselves on offering the finest gold and precious metals to investors and
            enthusiasts like you. Our mission is to make owning and managing gold simple, accessible, and rewarding.
        </p>

        <h3>What You Can Expect:</h3>
        <div style="margin-left: 20px;">
            <p style="margin-top: 0px; margin-bottom:4px;">&#10003; Stay informed with real-time prices on our <strong>Live
                    Prices</strong> page.</p>
            <p style="margin-top: 0px; margin-bottom:4px;">&#10003; Here click on this link, <a
                    href="https://goldstockcanada.com/shop"
                    style="color: #007BFF; text-decoration: none;">https://goldstockcanada.com/shop</a></p>
            <p style="margin-top: 0px; margin-bottom:4px;">&#10003; Be the first to access special deals and new arrivals.
            </p>
            <p style="margin-top: 0px; margin-bottom:4px;">&#10003; Learn the ins and outs of gold investment and refining.
            </p>
        </div>

        <h3>Ready to Explore?</h3>
        <p>
            Check out our latest gold bars, coins, and other offerings by visiting our <strong>Shop Now</strong> page.
        </p>

        <div style="text-align: center; width: 100%; margin: 20px 0; display: flex; flex-wrap: wrap; justify-content: center;">
            <div style="flex: 1 1 20%; max-width: 20%; padding: 10px; box-sizing: border-box;">
                <img src="{{ asset('email-icons/image.png') }}" alt="Gold Bar"
                    style="object-fit: contain; width: 100%; max-width: 100px; max-height: 100px">
            </div>
            <div style="flex: 1 1 20%; max-width: 20%; padding: 10px; box-sizing: border-box;">
                <img src="{{ asset('email-icons/image-1.png') }}" alt="Silver Coin"
                    style="object-fit: contain; width: 100%; max-width: 100px; max-height: 100px">
            </div>
            <div style="flex: 1 1 20%; max-width: 20%; padding: 10px; box-sizing: border-box;">
                <img src="{{ asset('email-icons/image-2.png') }}" alt="Gold Coin"
                    style="object-fit: contain; width: 100%; max-width: 100px; max-height: 100px">
            </div>
            <div style="flex: 1 1 20%; max-width: 20%; padding: 10px; box-sizing: border-box;">
                <img src="{{ asset('email-icons/image-3.png') }}" alt="Platinum Coin"
                    style="object-fit: contain; width: 100%; max-width: 100px; max-height: 100px">
            </div>
            <div style="flex: 1 1 20%; max-width: 20%; padding: 10px; box-sizing: border-box;">
                <img src="{{ asset('email-icons/image-4.png') }}" alt="Palladium Coin"
                    style="object-fit: contain; width: 100%; max-width: 100px; max-height: 100px">
            </div>
        </div>

        <p>
            As a welcome gift, enjoy <strong>5% off</strong> your first purchase with code:
        </p>
        <div style="text-align: center;">

            @component('components.button', ['url' => route('shop')])
                Welcome
            @endcomponent
        </div>

        @include('components.assistance')

        @include('components.social')

        @component('components.footer')
        @endcomponent
    </div>
@endcomponent
