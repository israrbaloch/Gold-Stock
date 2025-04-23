@component('components.base')
    @component('components.banner')
    @endcomponent

    <div class="content">
        <h1 style="font-size: 24px">Welcome to Gold Stock Canada</h1>
        <h2 style="font-size: 20px; font-weight: bold;">Let’s Grow Together!</h2>

        <p>Hi welcome,</p>
        <p><strong>{{ $name }}!</strong></p>
        <p>
            Thank you for signing up with <strong>Gold Stock Canada!</strong> We’re excited to have your business join our trusted network of partners in the world of precious metals. Whether you're buying, selling, or refining, we’re here to help you succeed every step of the way.
        </p>

        <h3>What We Offer to Businesses Like Yours:</h3>
        <div style="margin-left: 20px;">
            <p style="margin-top: 0px; margin-bottom:4px;">&#10003; Access industry-leading pricing for gold, silver, and other precious metals.</p>
            <p style="margin-top: 0px; margin-bottom:4px;">&#10003; Fast and reliable solutions for refining scrap gold, silver, and more.</p>
            <p style="margin-top: 0px; margin-bottom:4px;">&#10003; Your success is our priority, our team is always here to assist you.</p>
        </div>

        <h3>Start Your Journey Today!</h3>
        <p>
            Explore our range of services designed specifically for businesses like yours:
        </p>

        <div style="text-align: center;">
            @component('components.button', ['url' => route('home')])
                View Business Services
            @endcomponent
        </div>

        <h3>Ready to Explore?</h3>
        <p>See our latest products:</p>

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

        <h3>Your Exclusive Benefits:</h3>
        <p>As a valued partner, you’ll enjoy:</p>
        <div style="margin-left: 20px;">
            <p style="margin-top: 0px; margin-bottom:4px;">&#10003; Priority Service for refining and bulk orders.</p>
            <p style="margin-top: 0px; margin-bottom:4px;">&#10003; Access to Live Prices directly on our platform.</p>
            <p style="margin-top: 0px; margin-bottom:4px;">&#10003; Custom Solutions tailored to your business needs.</p>
        </div>

        @include('components.assistance')

        @include('components.social')

        @component('components.footer')
        @endcomponent
    </div>
@endcomponent