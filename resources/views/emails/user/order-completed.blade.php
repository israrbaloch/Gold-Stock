@component('components.base')
    @component('components.banner')
    @endcomponent

    <div class="content">
        <h1 style="font-size: 24px;">Thank You for Shopping with Gold Stock Canada! <span style="font-size: 20px;">&#127873;</span></h1>
        <h2 style="font-size: 18px; font-weight: 600;">Order Number #{{ $order->orderid }}</h2>

        <p>Dear,</p>
        <p><strong>{{ $order->nameuser }}!</strong></p>
        <p>
            Thank you for choosing <strong>Gold Stock Canada.</strong> Your business means the world to us, and we’re delighted to have been part of your journey with precious metals.<br>
            We hope your recent purchase exceeds your expectations and adds value to your goals.
        </p>
        <h3 style="margin-bottom: 0px">Stay Informed & Explore More</h3>
        <p style="margin-top: 5px">
            Track Precious Metals Prices<br>
            Stay up-to-date with live market trends and monitor your investment’s value.
        </p>
        <div style="text-align: center; margin: 20px 0;">
            @component('components.button', ['url' => route('getliveprices')])
                View Live Prices
            @endcomponent
        </div>

        <h3 style="margin-bottom: 0px">Learn & Grow</h3>
        <p style="margin-top: 5px">
            Discover expert tips and insights on investing, caring for your collection, and more.<br>
            <a href="{{ route('blog') }}" style="color: #007BFF; text-decoration: none;">Read Our Blog</a>
        </p>

        <h3 style="margin-bottom: 0px">We’d Love Your Feedback</h3>
        <p style="margin-top: 5px">
            Your experience matters. If you have a moment, we’d appreciate your thoughts; it helps us improve and serve you better.<br>
            <a href="{{URL::temporarySignedRoute('reviews.create', now()->addDays(7), ['order_id' => $order->id])}}" style="color: #007BFF; text-decoration: none;">Share Feedback</a>
        </p>

        @include('components.assistance')

        @include('components.social')

        @include('components.footer')
    </div>
@endcomponent
