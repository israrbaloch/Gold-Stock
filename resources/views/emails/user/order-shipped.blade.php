@component('components.base')
    @component('components.banner')
    @endcomponent

    @php
        $subTotal = $order->products->sum(function ($product) {
            return $product->price * $product->quantity;
        });

        $fee = 0;
        $total = round($subTotal, 2);
        $dueNow = 0;
        $pending = 0;

        $shippingOption = $order->shippingOption()->first();

        if ($subTotal > $shippingOption->free_from) {
            $total += $shippingOption->price;
        }

        $trackingNumber = $order->orderid;
        $deliveryDate = now()->addDays(5)->format('d-m-Y');
    @endphp

    <div class="content">
        <h1 style="font-size: 24px;">Great News! Your Order Has Shipped <span>📦</span></h1>
        <h2 style="font-size: 18px; font-weight: 600;">ORDER > SHIPPED</h2>

        <p>Hi,</p>
        <p><strong>{{ $order->nameuser }}!</strong></p>
        <p>
            Your order is on its way! 🎉
        </p>

        <h3>Order Summary:</h3>
        <p>Order Number: <strong>#{{ $order->orderid }}</strong></p>
        <p>Shipping Method: <strong>{{ $shippingOption->name }}</strong></p>
        <p>Tracking Number: <strong>{{ $trackingNumber }}</strong></p>
        <p>Estimated Delivery Date: <strong>{{ $deliveryDate }}</strong></p>

        <h3 style="margin-top: 30px">Items Shipped:</h3>

        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="border-bottom: 1px solid #636363;">
                    <th style="text-align: left; padding: 8px; width:50%">Product</th>
                    <th style="text-align: center; padding: 8px; width:20%">Quantity</th>
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

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="padding: 8px; text-align: left;">Sub Total:</td>
                <td style="padding: 8px; text-align: right;"><strong>${{ number_format($subTotal, 2) }}
                        {{ $order->currency }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 8px; text-align: left;">Shipping Service:</td>
                <td style="padding: 8px; text-align: right;"><strong>${{ number_format($shippingOption->price, 2) }}
                        {{ $order->currency }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 8px; text-align: left;">Total:</td>
                <td style="padding: 8px; text-align: right;"><strong>${{ number_format($total, 2) }}
                        {{ $order->currency }}</strong></td>
            </tr>
        </table>

        <div style="text-align: center; margin: 20px 0;">
            @component('components.button', ['url' => '#'])
                Track your Shipment
            @endcomponent
        </div>

        <p>Click below to stay updated on your order’s journey:<br>
            <a href="#" style="color: #007BFF; text-decoration: none;">
                Track My Order
            </a>
        </p>

        <hr>

        @include('components.assistance')

        @include('components.social')

        <p>Thank you for choosing Gold Stock Canada.<br>
            We look forward to completing your order!</p>

        @include('components.footer')
    </div>
@endcomponent
