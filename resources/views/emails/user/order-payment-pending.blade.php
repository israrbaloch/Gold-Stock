@component('components.base')
    @component('components.banner')
    @endcomponent

    @php
        $subTotal = $order->products->sum(function ($product) {
            return $product->price * $product->quantity;
        });

        $paidAmount = $order->payed;

        $shippingOption = $order->shippingOption()->first();
        $total = $order->total + $shippingOption->price;

        $outstandingBalance = $total - $paidAmount;
    @endphp

    <div class="content">
        <h1 style="font-size: 24px;">Your Order is Ready, But Requires Payment to Proceed</h1>
        <h2 style="font-size: 18px; font-weight: 600;">Order Number #{{ $order->orderid }}</h2>

        <p>Dear,</p>
        <p><strong>{{ $order->nameuser }}!</strong></p>
        <p>
            Thank you for your order with <strong>Gold Stock Canada.</strong> We're preparing your items, but we noticed there’s an outstanding balance that needs to be cleared before we can proceed.
        </p>

        <h3>Order Summary:</h3>
        <p>Order Number: <strong>#{{ $order->orderid }}</strong></p>
        <p>Order Total: <strong>${{ number_format($total, 2) }}</strong></p>
        <p>Amount Paid: <strong>${{ number_format($paidAmount, 2) }}</strong></p>
        <p>Outstanding Balance: <strong>${{ number_format($outstandingBalance, 2) }}</strong></p>

        <h3 style="margin-top: 30px">Item(s) ordered:</h3>

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
                <td style="padding: 8px; text-align: left;">Shipping Service:</td>
                <td style="padding: 8px; text-align: right;"><strong>${{ number_format($shippingOption->price, 2) }} {{ $order->currency }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 8px; text-align: left;">Sub Total:</td>
                <td style="padding: 8px; text-align: right;"><strong>${{ number_format($subTotal, 2) }} {{ $order->currency }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 8px; text-align: left;">Amount paid:</td>
                <td style="padding: 8px; text-align: right;"><strong>${{ number_format($paidAmount, 2) }} {{ $order->currency }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 8px; text-align: left;">Balance Due:</td>
                <td style="padding: 8px; text-align: right;"><strong>${{ number_format($outstandingBalance, 2) }} {{ $order->currency }}</strong></td>
            </tr>
        </table>

        <div style="text-align: center; margin: 20px 0;">
            @component('components.button', ['url' => '#'])
                Pay outstanding Balance
            @endcomponent
        </div>

        <hr>

        <p>You can make your payment securely by clicking the link below:<br>
            <a href="#" style="color: #007BFF; text-decoration: none;">
                Pay Outstanding Balance
            </a>
        </p>

        <p>
            Once we receive your payment, your order will be processed for:
        </p>
        <p>
            <b>Shipping</b> (if applicable): Your order will be dispatched, and a tracking link will be provided.<br>
            <b>Pick-Up</b> (if applicable): You’ll receive confirmation that your order is ready for collection.
        </p>

        @include('components.assistance')

        @include('components.social')

        <p>Thank you for choosing Gold Stock Canada.<br>
            We look forward to completing your order!</p>

        @include('components.footer')
    </div>
@endcomponent
