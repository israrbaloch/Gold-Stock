@component('components.base')
    @component('components.banner')
    @endcomponent

    @php
        $subTotal = $order->products->sum(function ($product) {
            return $product->price * $product->quantity;
        });

        $shippingOption = $order->shippingOption()->first();
        $total = $subTotal + $shippingOption->price;
    @endphp

    <div class="content">
        <h1 style="font-size: 24px;">Order Update</h1>
        <h2 style="font-size: 18px; font-weight: 600;">Order Number #{{ $order->orderid }}</h2>

        <p>Dear,</p>
        <p><strong>{{ $order->nameuser }}!</strong></p>
        <p>
            We’re writing to keep you updated on the status of your order with <strong>Gold Stock Canada.</strong><br>
            Here’s the latest information:
        </p>

        <h3>Order Summary:</h3>
        <p>Order Number: <strong>#{{ $order->orderid }}</strong></p>
        <p>Order Total: <strong>${{ number_format($total, 2) }}</strong></p>
        <p>Current order status: <strong>{{ $order->status }}</strong></p>

        <h3 style="margin-top: 30px">Item(s) ordered:</h3>

        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="border-bottom: 1px solid #636363;">
                    <th style="text-align: left; padding: 8px; width:70%">Product</th>
                    <th style="text-align: right; padding: 8px; width:30%">Price</th>
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
                        <td style="padding: 8px; text-align: right;">
                            ${{ number_format($product->price, 2) }}
                            {{ $order->currency }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="padding: 8px; text-align: left;">Shipping Service:</td>
                <td style="padding: 8px; text-align: right;"><strong>${{ number_format($shippingOption->price, 2) }}
                        {{ $order->currency }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 8px; text-align: left;">Sub Total:</td>
                <td style="padding: 8px; text-align: right;"><strong>${{ number_format($subTotal, 2) }}
                        {{ $order->currency }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 8px; text-align: left;">Total:</td>
                <td style="padding: 8px; text-align: right;"><strong>${{ number_format($total, 2) }}
                        {{ $order->currency }}</strong></td>
            </tr>
        </table>

        <h3 style="margin-top: 30px">Current order status: <strong>{{ $order->status }}</strong></h3>
        <p>
            Thank you! We’ve received your payment of <strong>${{ number_format($order->payed, 2) }}</strong>. Your
            order is now being processed.
        </p>
        <p>
            Your order is being carefully prepared by our team. We’ll notify you once it’s ready for shipment or pick-up.
        </p>


        @include('components.assistance')

        @include('components.social')

        <p>Thank you for choosing Gold Stock Canada.<br>
            We appreciate your trust in us!</p>

        @include('components.footer')
    </div>
@endcomponent
