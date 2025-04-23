@component('components.base')
    @component('components.banner')
    @endcomponent

    @php
        $subTotal = $order->products->sum(function ($product) {
            return $product->price * $product->quantity;
        });
    @endphp

    <div class="content">
        <h1 style="font-size: 24px;">Your Order Has Been Cancelled <span style="color: red;">❌</span></h1>
        <h2 style="font-size: 18px; font-weight: 600;">ORDER > CANCELLED</h2>

        <p>Dear,</p>
        <p><strong>{{ $order->nameuser }}!</strong></p>
        <p>
            We’re reaching out to inform you that your order with <strong>Gold Stock Canada</strong> has been cancelled. Below are the details and reasons for the cancellation:
        </p>

        <h3>Order Summary:</h3>
        <p>Order Number: <strong>#{{ $order->orderid }}</strong></p>
        <p>Order Total: <strong>${{ number_format($subTotal, 2) }}</strong></p>

        <h3 style="margin-top: 30px">Item(s) ordered:</h3>

        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="border-bottom: 1px solid #636363;">
                    <th style="text-align: left; padding: 8px; width:70%">Product</th>
                    <th style="text-align: center; padding: 8px; width:15%">Quantity</th>
                    <th style="text-align: right; padding: 8px; width:15%">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $product)
                    <tr style="border-bottom: 1px solid #636363;">
                        <td style="padding: 8px;">
                            @php
                                $imagesData = json_decode($product->getImages());
                                $image = is_array($imagesData) && count($imagesData) > 0 ? asset('storage/' . str_replace('\\', '/', $imagesData[0])) : asset(explode(',', $product->images)[0]);
                            @endphp
                            <img src="{{ $image }}" alt="{{ $product->name }}"
                                style="width: 50px; height: auto; vertical-align: middle; margin-right: 10px;">
                            {{ $product->name }}
                        </td>
                        <td style="padding: 8px; text-align: center;">
                            {{ $product->quantity }}
                        </td>
                        <td style="padding: 8px; text-align: right;">
                            ${{ number_format($product->price, 2) }}
                            {{ $order->currency }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p>
            Your request to cancel the order has been processed. If you have any questions or wish to place a new order, feel free to contact us.
        </p>

        <p>
            If you’d like to place a new order or have further questions about this cancellation, we’re here to help.<br>
            Browse Products: <a href="{{ route('shop') }}" style="color: #007BFF; text-decoration: none;">Shop Now</a><br>
            Contact Us: <a href="mailto:support@goldstockcanada.com" style="color: #007BFF; text-decoration: none;">support@goldstockcanada.com</a> or <a href="tel:1-844-504-4653" style="color: #007BFF; text-decoration: none;">1-844-504-4653</a>.
        </p>

        <p>
            We apologize for any inconvenience this may have caused and appreciate your understanding.<br>
            Thank you for choosing Gold Stock Canada.<br>
            We hope to assist you again soon!
        </p>


        @include('components.footer')
    </div>
@endcomponent