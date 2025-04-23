@component('components.base')
    @component('components.banner')
    @endcomponent

    @php
        $approveLink = URL::temporarySignedRoute(
            'orders.approve', // The route name
            now()->addDay(3), // Link expiration time
            ['order' => $order->id], // Route parameter
        );
    @endphp

    <div class="content">
        <h1 style="font-size: 24px;">Please Approve Changes to Your Order</h1>
        <h2 style="font-size: 18px; font-weight: 600;">Order Number #{{ $order->orderid }}</h2>

        <p>Dear,</p>
        <p><strong>{{ $order->nameuser }}!</strong></p>
        <p>
            We’re reaching out about your recent order with <strong>Gold Stock Canada.</strong> Due to [reason, e.g., stock
            availability, product update, or special request], we’ve made changes to your order. Before we proceed, we
            kindly ask for your approval to ensure you’re completely satisfied.
        </p>

        <h3>Updated Order Details:</h3>
        <p>Order Number: <strong>#{{ $order->orderid }}</strong></p>
        <p>Original Total: <strong>${{ number_format($oldTotal, 2) }}</strong></p>
        <p>Updated Total: <strong>${{ number_format($order->total, 2) }}</strong></p>

        <h3 style="margin-top: 20px;">Order Breakdown:</h3>

        <h4>Original items:</h4>
        <table style="width: 100%; margin-top: 10px;">
            @foreach ($oldProducts as $product)
                <tr style="margin-bottom: 20px;">
                    <td style="width: 20%;">
                        @php
                            $imagesData = json_decode($product->getImages());
                            $image = is_array($imagesData) && count($imagesData) > 0 ? asset('storage/' . str_replace('\\', '/', $imagesData[0])) : asset(explode(',', $product->images)[0]);
                        @endphp
                        <img src="{{ $image }}" alt="{{ $product->name }}"
                            style="width: 100%; max-width: 100px; height: auto;">
                    </td>
                    <td style="width: 60%; padding-left: 10px;">
                        {{ $product->name }}
                    </td>
                    <td style="width: 20%; text-align: right;">
                        ${{ number_format($product->price, 2) }}
                    </td>
                </tr>
            @endforeach
        </table>

        <hr style="margin: 30px 0;">


        <h4 style="margin-top: 20px;">Proposed changes:</h4>
        <table style="width: 100%; margin-top: 10px;">
            @foreach ($order->products as $product)
                <tr style="margin-bottom: 20px;">
                    <td style="width: 20%;">
                        @php
                            $imagesData = json_decode($product->getImages());
                            $image = is_array($imagesData) && count($imagesData) > 0 ? asset('storage/' . str_replace('\\', '/', $imagesData[0])) : asset(explode(',', $product->images)[0]);
                        @endphp
                        <img src="{{ $image }}" alt="{{ $product->name }}"
                            style="width: 100%; max-width: 100px; height: auto;">
                    </td>
                    <td style="width: 60%; padding-left: 10px;">
                        {{ $product->name }}
                    </td>
                    <td style="width: 20%; text-align: right;">
                        ${{ number_format($product->price, 2) }}
                    </td>
                </tr>
            @endforeach
        </table>

        <div style="text-align: center; margin-top: 20px;">
            @component('components.button', ['url' => $approveLink])
                Approve My Order
            @endcomponent
        </div>

        <hr>

        <p style="margin-top: 10px;">
            Click below to confirm the changes and allow us to proceed:<br>
            <a href="{{$approveLink}}" style=" text-decoration: none;">Approve My Order</a>
        </p>

        <h3>Once you approve the changes:</h3>
        <div style="margin-left: 20px;">
            <p style="margin-top: 0px; margin-bottom:4px;">&#10003; Your order will be processed immediately.</p>
            <p style="margin-top: 0px; margin-bottom:4px;">&#10003; You’ll receive tracking information once dispatched.</p>
            <p style="margin-top: 0px; margin-bottom:4px;">&#10003; You’ll receive confirmation when your items are ready.
            </p>
        </div>


        @include('components.assistance')

        @include('components.social')

        <p>Thank you for your understanding and prompt response!</p>

        @include('components.footer')
    </div>
@endcomponent
