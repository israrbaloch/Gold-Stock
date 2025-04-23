@component('components.base')
    @component('components.banner')
    @endcomponent

    <div class="content">
        <h1 style="font-size: 24px;">We’d Love Your Feedback – Help Us Improve!</h1>

        <p>Dear,</p>
        <p><strong>{{ $order->nameuser }}!</strong></p>
        <p>
            Thank you for choosing <strong>Gold Stock Canada!</strong> Your opinion means everything to us, and we’d love to hear about your experience.
        </p>

        <h3>Share Your Feedback in Two Steps:</h3>
        <ol style="margin-left: 20px;">
            <li>
                Share your thoughts about your recent purchase on our website. Your feedback helps us grow and ensures we meet your expectations. As a token of our appreciation, you’ll receive <strong>[5% off your next purchase, free shipping]</strong>.<br>
                <a href="{{URL::temporarySignedRoute('reviews.create', now()->addDays(7), ['order_id' => $order->id])}}" style="color: #007BFF; text-decoration: none;">Review My Product</a>
            </li>
            <li style="margin-top: 10px;">
                Help others discover Gold Stock Canada by sharing your experience on Google. Honest reviews like yours make a big difference.<br>
                <a href="https://g.co/kgs/obnCdtr" style="color: #007BFF; text-decoration: none;">Leave a Google Review</a>
            </li>
        </ol>

        <h3 style="margin-top: 30px;">Share Your Feedback?</h3>
        <div style="text-align: center; width: 100%; margin: 20px 0; display: flex; flex-wrap: wrap; justify-content: center;">
            @foreach ($order->products as $product)
                @php
                    $imagesData = json_decode($product->getImages());
                    $image = is_array($imagesData) && count($imagesData) > 0 ? asset('storage/' . str_replace('\\', '/', $imagesData[0])) : asset(explode(',', $product->images)[0]);
                @endphp
                <div style="flex: 1 1 50%; max-width: 50%; padding: 10px; box-sizing: border-box; display: flex; align-items: center;">
                    <img src="{{ $image }}" alt="{{ $product->name }}"
                        style="object-fit: contain; width: 100%; max-width: 100px; height: auto;">
                    <p>{{ $product->name }}</p>
                </div>
            @endforeach
        </div>

        <h3>Why Your Feedback Matters:</h3>
        <ul style="margin-left: 20px;">
            <li>Your insights help us deliver the best experience possible.</li>
            <li>Help others make informed decisions about their precious metal needs.</li>
        </ul>

        @include('components.assistance')

        @include('components.social')

        @include('components.footer')
    </div>
@endcomponent